<?php

$brand = $config['site_name'];

$conditions = [

    'slug'  => 'condiciones-para-sitio-web',

    'title' => 'Condiciones para el Desarrollo de Sitios Web',

    'updated' => '12/07/2026',

    'sections' => [

        [
            'title' => '1. Objeto',
            'body' => 'Las presentes condiciones regulan la prestación de los servicios de diseño, desarrollo e implementación de sitios web realizados por %BRAND%. La aceptación de un presupuesto o propuesta comercial implica la aceptación íntegra de estas condiciones.'
        ],

        [
            'title' => '2. Alcance del servicio',
            'body' => 'Cada proyecto incluirá exclusivamente los trabajos descritos en el presupuesto aceptado. Cualquier funcionalidad, modificación o servicio no contemplado inicialmente será considerado un trabajo adicional y podrá ser presupuestado por separado.'
        ],

        [
            'title' => '3. Tecnologías utilizadas',
            'body' => 'Los proyectos podrán desarrollarse utilizando PHP, MySQL, JavaScript, HTML, CSS y aquellas tecnologías que %BRAND% considere adecuadas para garantizar el correcto funcionamiento, mantenimiento y escalabilidad del proyecto.'
        ],

        [
            'title' => '4. Idiomas',
            'body' => 'Salvo indicación expresa en el presupuesto, el desarrollo será entregado en un único idioma. La arquitectura podrá quedar preparada para futuras traducciones sin que ello implique la inclusión de las mismas.'
        ],

        [
            'title' => '5. Dominio',
            'body' => 'Cuando %BRAND% gestione el registro del dominio, este será registrado a nombre del cliente. Para ello será necesario facilitar los datos legales requeridos por el registrador, especialmente en dominios .es y .eu.'
        ],

        [
            'title' => '6. Hosting',
            'body' => 'El alojamiento podrá realizarse mediante un servicio de hosting compartido. Un hosting compartido implica que varios sitios web utilizan recursos de un mismo servidor físico. Aunque este tipo de servicio ofrece una elevada disponibilidad, pueden producirse incidencias ocasionadas por mantenimientos, averías, problemas de conectividad o cortes eléctricos en los centros de datos.'
        ],

        [
            'title' => '7. Correo electrónico',
            'body' => 'Se configurará una cuenta de correo electrónico bajo el dominio contratado cuando dicho servicio esté incluido en el presupuesto.'
        ],

        [
            'title' => '8. Plazos',
            'body' => 'Los plazos de desarrollo comenzarán una vez aprobado el diseño, recibida toda la documentación necesaria y confirmado el pago acordado. Los retrasos ocasionados por la falta de información o validaciones del cliente ampliarán automáticamente los plazos de entrega.'
        ],

        [
            'title' => '9. Contenidos',
            'body' => 'El cliente será responsable de facilitar los textos, imágenes, logotipos y demás materiales necesarios para el desarrollo del proyecto. %BRAND% no será responsable de posibles infracciones de derechos de propiedad intelectual sobre los contenidos facilitados por el cliente.'
        ],

        [
            'title' => '10. Fotografías y contenidos',
            'body' => 'El presupuesto no incluye la compra de fotografías, bancos de imágenes, creación de textos profesionales ni contenidos sujetos a derechos de autor, salvo que se indique expresamente.'
        ],

        [
            'title' => '11. SEO',
            'body' => 'Los sitios web serán desarrollados siguiendo buenas prácticas técnicas de SEO y GEO, incluyendo estructura semántica, URLs amigables y optimización del código. Estas actuaciones no garantizan posicionamiento en buscadores ni sustituyen un servicio profesional de posicionamiento SEO.'
        ],

        [
            'title' => '12. Renovaciones',
            'body' => 'Los servicios de dominio, hosting, certificados SSL u otros servicios de terceros deberán renovarse periódicamente. Salvo acuerdo expreso, dichos costes corresponderán al cliente.'
        ],

        [
            'title' => '13. Forma de pago',
            'body' => 'Los pagos se realizarán exclusivamente mediante transferencia bancaria. %BRAND% emitirá la correspondiente factura una vez recibidos los datos fiscales necesarios.'
        ],

        [
            'title' => '14. Datos fiscales',
            'body' => 'Para la emisión de la factura el cliente deberá facilitar su nombre o razón social, DNI, NIE o CIF, así como su dirección fiscal.'
        ],

        [
            'title' => '15. Garantía',
            'body' => 'Una vez entregado el proyecto se corregirán sin coste aquellos errores derivados directamente del desarrollo realizado por %BRAND% y comunicados dentro del periodo de garantía acordado. Quedan excluidas las modificaciones solicitadas por el cliente o las incidencias ocasionadas por terceros.'
        ],

        [
            'title' => '16. Servicios no incluidos',
            'body' => 'Salvo que se indique expresamente en el presupuesto, no se incluyen mantenimiento, actualización de contenidos, campañas SEO, publicidad, gestión de redes sociales, traducciones, fotografía profesional ni nuevas funcionalidades.'
        ],

        [
            'title' => '17. Aceptación',
            'body' => 'La aceptación de un presupuesto, propuesta comercial o el inicio del proyecto supone la aceptación íntegra de las presentes condiciones generales.'
        ]

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