# Google Calendar en Appointments

Se reutilizan `GOOGLE_CLIENT_ID` y `GOOGLE_CLIENT_SECRET` del backend existente
(`public_html/.env`). No hacen falta nuevas credenciales ni una cuenta de servicio.
`GOOGLE_CALENDAR_ID` es opcional: por defecto se usa `primary` de la cuenta
`ikusa.creativestudio@gmail.com`. La configuración antigua de `calendar.local.php`
y `credentials.json` ya no se usa en el servicio.

Entrar al panel y abrir **Google Calendar**, ruta `index.php?page=appointments`.
Pulsar **Conectar Google Calendar** y autorizar con esa cuenta. El login con Google
Identity Services sigue separado del consentimiento para acceder a eventos.
La pantalla permite consultar intervalos, crear, modificar y eliminar eventos.
Los eventos de día completo se consultan y eliminan; el formulario de edición
trabaja con eventos horarios. Las instancias recurrentes se editan individualmente.

Retornos exactos, ya autorizados:

- Producción: `https://ikusa.net/admin`
- Local MAMP: `http://localhost:8888/ikusa/admin`

El módulo selecciona estas URLs sin depender del valor antiguo
`GOOGLE_REDIRECT_URI` (actualmente apunta a `/login`). No hay que añadir otra URL.
Se pide `calendar.events`, `openid` y `email`, acceso offline y consentimiento.
El retorno valida state de un solo uso, caducidad, sesión administradora, cuenta,
email verificado, scope y presencia del refresh token.

Los tokens se guardan en `storage/google-calendar/token.json` del backend,
excluido de Git y bloqueado por Apache, con permisos 0600 y escritura atómica.
El usuario del proceso PHP necesita permiso de escritura en `storage`.
La renovación usa un bloqueo de archivo para evitar renovaciones simultáneas,
conserva el refresh token si Google no devuelve uno nuevo y borra la conexión
si Google devuelve `invalid_grant`. No se envían tokens ni secretos al navegador.
Si se sirve desde Nginx, bloquear `/app`, `/storage`, `/vendor` y archivos ocultos,
o usar exclusivamente `public_html` como raíz pública y bloquear su `.env`.

Las capas Domain, Application e Infrastructure están dentro de
`Appointments/Calendar`; `GoogleCalendarService` adapta las citas existentes a
la misma conexión. El calendario pertenece al estudio y se comparte entre los
administradores; no se guardan calendarios por usuario del panel.

Comprobaciones:

```sh
php tests/appointments-calendar.php
php tests/appointments-calendar-live.php
```

La primera prueba simula las respuestas HTTP de Google y verifica CRUD,
paginación, fechas, renovación, revocación y protección OAuth. La segunda
requiere haber autorizado la conexión y crea un evento temporal, lo modifica,
lo consulta y lo elimina. No modifica eventos existentes.

Si la pantalla de consentimiento de Google está en estado Testing, Google
limita a siete días los refresh tokens que incluyen scopes de Calendar; al
caducar hay que volver a conectar.
Fuente: https://developers.google.com/identity/protocols/oauth2

## Formulario de leads

`public_html/appointment.php` atiende el formulario «Hablemos», consulta los
horarios reales mediante JSON y crea reuniones de 30 minutos en el mismo
calendario. Conserva las franjas existentes y los dos días laborables de
antelación del formulario. Un día completo ocupado muestra «No está disponible»
sin abrir el selector. Las franjas parcialmente ocupadas tampoco se ofrecen.
Si Google falla, no se ofrecen horarios ni se confirma ninguna cita.

Los datos del lead (nombre, email, teléfono y servicio) quedan en la descripción
del evento; este flujo no utiliza las tablas de pacientes o tratamientos.
El envío exige CSRF y aceptación de privacidad. Un bloqueo serializa las reservas
de Ikusa y se vuelve a consultar Calendar antes de insertar. Calendar no ofrece
una transacción de disponibilidad e inserción: una edición externa simultánea
puede producir un solapamiento. Los eventos tienen un ID estable por solicitud
y la sesión conserva el resultado para evitar duplicados al repetir el envío.

Prueba de horarios y reservas: `php tests/lead-appointments.php`.

Tras guardar la cita, se envía una confirmación SMTP al email del solicitante,
con copia (CC) a `ikusa.creativestudio@gmail.com` y esa misma dirección como
Reply-To. Se reutilizan MAIL_HOST, MAIL_USERNAME, MAIL_PASSWORD, MAIL_PORT y
MAIL_FROM_ADDRESS del backend. Si SMTP falla, la cita permanece registrada y
el formulario informa de que el correo no pudo enviarse. Repetir una petición
ya procesada no vuelve a crear la cita ni a enviar el correo.
Prueba sin envío real: `php tests/booking-confirmation-mail.php`.

El selector de fechas marca en amarillo las festividades nacionales españolas
(en su fecha propia, incluido Viernes Santo), y no permite reservar fines de
semana ni festivos. No incluye los festivos autonómicos/locales ni sus traslados.
La regla de dos días laborables excluye también estas fechas. Las mañanas 09:00–14:00 están ocupadas por Ecommjuice de lunes a viernes: se
muestran en verde manzana y no se pueden reservar. El backend rechaza también
esas horas. Se mantienen las tardes 15:00–19:00.
Referencia de 2026: https://www.boe.es/buscar/doc.php?id=BOE-A-2025-21667
