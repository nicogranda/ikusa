<?php

$brand = htmlspecialchars((string) ($config['site_name'] ?? 'Ikusa'), ENT_QUOTES, 'UTF-8');

$conditions = [
    'slug' => 'condiciones-marketing-digital',
    'title' => 'Condiciones para los Servicios de Marketing Digital',
    'updated' => '10/10/2026',
    'sections' => [
        [
            'title' => '1. Objeto',
            'body' => 'Las presentes condiciones regulan la prestación de los servicios de estrategia, planificación, ejecución y seguimiento de marketing digital realizados por %BRAND%. La aceptación de un presupuesto o propuesta comercial implica la aceptación de estas condiciones, que deberán estar disponibles para el cliente antes de la contratación.'
        ],
        [
            'title' => '2. Alcance del servicio',
            'body' => 'Cada proyecto incluirá exclusivamente los canales, campañas, acciones, entregables y dedicación descritos en el presupuesto aceptado. Cualquier ampliación, nuevo canal o trabajo no contemplado inicialmente podrá ser presupuestado por separado y requerirá la aprobación del cliente.'
        ],
        [
            'title' => '3. Herramientas y plataformas',
            'body' => 'Los servicios podrán realizarse mediante plataformas publicitarias, redes sociales, herramientas de analítica, automatización y otras soluciones adecuadas al proyecto. Su utilización estará sujeta a las condiciones y políticas de sus respectivos proveedores.'
        ],
        [
            'title' => '4. Idiomas',
            'body' => 'Salvo indicación expresa en el presupuesto, los contenidos, campañas e informes se realizarán en un único idioma. Las traducciones y la adaptación de campañas a otros mercados se presupuestarán por separado.'
        ],
        [
            'title' => '5. Cuentas y accesos',
            'body' => 'Las cuentas publicitarias, perfiles sociales y activos del cliente permanecerán bajo su titularidad. El cliente facilitará a %BRAND% los permisos necesarios para prestar el servicio, preferentemente mediante accesos delegados. La creación o recuperación de cuentas solo se incluirá cuando figure en el presupuesto.'
        ],
        [
            'title' => '6. Inversión publicitaria',
            'body' => 'Los honorarios de gestión no incluyen la inversión en anuncios, salvo indicación expresa. El presupuesto publicitario deberá ser aprobado por el cliente y se abonará a la plataforma correspondiente o conforme al sistema acordado. No se aumentará la inversión aprobada sin autorización del cliente.'
        ],
        [
            'title' => '7. Comunicaciones y aprobaciones',
            'body' => 'El presupuesto identificará los interlocutores y el procedimiento de aprobación de contenidos y campañas. Las validaciones necesarias se solicitarán antes de la publicación, salvo autorización previa para ejecutar acciones dentro del plan acordado. La falta de respuesta no se considerará por sí sola una aprobación.'
        ],
        [
            'title' => '8. Plazos',
            'body' => 'Los plazos comenzarán una vez aceptada la propuesta, recibidos los materiales y accesos necesarios y confirmado el pago acordado. Los retrasos en la entrega de información o en las aprobaciones del cliente podrán exigir un ajuste de la planificación, que se comunicará al cliente.'
        ],
        [
            'title' => '9. Contenidos y materiales',
            'body' => 'El cliente facilitará información veraz sobre su actividad, productos, precios y promociones, así como los materiales necesarios y las autorizaciones para utilizarlos. %BRAND% empleará los materiales facilitados únicamente para las acciones contratadas y avisará de las incidencias que detecte.'
        ],
        [
            'title' => '10. Creatividades y revisiones',
            'body' => 'La cantidad y el tipo de piezas, publicaciones, anuncios y revisiones incluidas serán los establecidos en el presupuesto. Salvo acuerdo expreso, no se incluyen fotografía profesional, vídeo, compra de imágenes, licencias ni producción de materiales adicionales. Las condiciones de uso de las piezas entregadas se concretarán en la propuesta y respetarán las licencias de terceros.'
        ],
        [
            'title' => '11. Objetivos y resultados',
            'body' => 'Los objetivos, indicadores y criterios de seguimiento se definirán en la propuesta. %BRAND% ejecutará las acciones acordadas con diligencia profesional, pero no garantiza un número determinado de ventas, contactos, seguidores, posiciones en buscadores o rentabilidad, salvo compromiso expreso. Los resultados dependen también de la inversión, la competencia, la oferta del cliente y los cambios de las plataformas.'
        ],
        [
            'title' => '12. Duración y renovaciones',
            'body' => 'La duración del servicio, su periodicidad y las condiciones de renovación y cancelación serán las indicadas en el presupuesto. Cualquier permanencia o plazo de preaviso deberá acordarse expresamente. Al finalizar el servicio se retirarán los accesos de gestión de %BRAND% y se facilitarán los entregables y la información de las campañas conforme a lo pactado.'
        ],
        [
            'title' => '13. Forma de pago',
            'body' => 'Los pagos se realizarán mediante transferencia bancaria en los importes y plazos establecidos en el presupuesto. %BRAND% emitirá la correspondiente factura una vez recibidos los datos fiscales necesarios. Los honorarios y la inversión publicitaria se identificarán de forma diferenciada.'
        ],
        [
            'title' => '14. Datos fiscales y protección de datos',
            'body' => 'El cliente facilitará los datos fiscales necesarios para la facturación. Cuando el servicio requiera tratar datos personales por cuenta del cliente, se formalizará el acuerdo de encargo de tratamiento correspondiente. Las campañas respetarán las bases de legitimación aplicables, los derechos de los destinatarios y los requisitos de información y consentimiento para comunicaciones comerciales, cookies y tecnologías de seguimiento cuando procedan.'
        ],
        [
            'title' => '15. Incidencias y correcciones',
            'body' => 'Se corregirán sin coste los errores directamente atribuibles a la ejecución de %BRAND% dentro del alcance contratado. Las incidencias de plataformas, rechazos de anuncios o cambios de sus políticas se comunicarán al cliente y se gestionarán dentro del servicio acordado. Esta cláusula no excluye las responsabilidades ni los derechos que resulten legalmente exigibles.'
        ],
        [
            'title' => '16. Servicios no incluidos',
            'body' => 'Salvo que se indiquen expresamente en el presupuesto, no se incluyen desarrollo o mantenimiento web, creación de páginas de destino, gestión de consultas y ventas, atención al cliente, contratación de influencers, traducciones, licencias, inversión publicitaria ni servicios adicionales de SEO, contenidos o redes sociales.'
        ],
        [
            'title' => '17. Aceptación',
            'body' => 'La aceptación expresa del presupuesto o propuesta comercial supone la aceptación de las condiciones facilitadas antes de la contratación. Las condiciones particulares de la propuesta completarán estas condiciones generales. Cualquier modificación del alcance, precio o duración requerirá acuerdo entre las partes, sin perjuicio de los derechos legalmente aplicables.'
        ],
    ]
];

?>
<head>
	<title><?= $conditions['title']; ?></title>
	<meta name="robots" content="noindex,nofollow">
</head>
<section class="legal-text">
<p class="principal"><?= $conditions['title']; ?></p>


<?php foreach ($conditions['sections'] as $section): ?>
<b><?= $section['title']; ?></b><br>
<?= nl2br(str_replace('%BRAND%', '<b>' . $brand . '</b>', $section['body'])); ?><br><br>
<?php endforeach; ?>
<p><strong>Última actualización:</strong> <?= $conditions['updated']; ?></p><br>
</section>