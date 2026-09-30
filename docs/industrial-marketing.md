# Landing de marketing industrial

Ruta: `/es/agencia-marketing-industrial`.

La traducción existente en `page_translations` sigue resolviendo la página y su identidad. `IndustrialMarketing.php` define el contenido editorial y los metadatos españoles, aplicados antes de generar el head. `Views/IndustrialMarketing.php` sustituye los componentes genéricos de esta landing; el CSS queda limitado a `.industrial-page` y reutiliza los tokens de la marca y los helpers de rutas y assets.

No requiere migraciones SQL. Desplegar los cuatro archivos de este cambio en la estructura existente. El editor de la base de datos no modificará estos textos: se mantienen en `IndustrialMarketing.php` y en la vista específica.

Contenido: propuesta B2B, seis servicios, necesidades de ingeniería/compras/dirección, proceso de trabajo, indicadores comerciales, siete preguntas frecuentes y enlaces a contacto. No se reutilizan estadísticas de otros proyectos ni se presentan como resultados industriales.

Validación: análisis sintáctico PHP, render de la vista con PHP 8.4 en WebAssembly sin avisos, un H1, un main, siete elementos details y anclas internas válidas; `git diff --check`. Pendiente la revisión visual en navegador y la integración con MySQL/servidor real: el entorno no incluye navegador y su descarga falló.
