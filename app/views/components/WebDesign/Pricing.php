<?php
/**
 * Component: WebDesign/Pricing.php
 *
 * Pricing de diseño y desarrollo web.
 * Componente autocontenido.
 * Reutiliza las clases visuales del pricing existente.
 */

$pricing = [

    'eyebrow' => 'DISEÑO Y DESARROLLO WEB',

    'title' => 'Una página web a la medida<br>de tu negocio.',

    'intro' => 'Cada proyecto tiene objetivos diferentes. Elige el tipo de web que necesitas y cuéntanos tu idea para preparar una propuesta adaptada a tu negocio.',

    'plans' => [

        [
            'title' => 'Web Corporativa',

            'description' => 'Una página web profesional para presentar tu negocio, comunicar tus servicios y facilitar que tus clientes contacten contigo.',

            'amount' => 'Presupuesto a medida',
            'currency' => '',
            'period' => '',

            'featured' => false,
            'badge' => '',

            'features' => [
                'Diseño adaptado a tu identidad visual',
                'Diseño responsive para móvil, tablet y ordenador',
                'Páginas esenciales de tu negocio',
                'Formularios de contacto y llamadas a la acción',
                'Estructura básica de SEO técnico',
                'Optimización inicial de velocidad e imágenes',
                'Configuración de analítica cuando corresponda',
                'Revisión y publicación de la web',
            ],

            'note' => 'El presupuesto depende del número de páginas, los contenidos y las funcionalidades necesarias.',

            'service' => 'diseno-web',
            'project' => 'web-corporativa',
        ],

        [
            'title' => 'Web Profesional',

            'description' => 'Una web diseñada para competir en tu sector, presentar tus servicios con claridad y convertir las visitas en oportunidades de negocio.',

            'amount' => 'Presupuesto a medida',
            'currency' => '',
            'period' => '',

            'featured' => true,
            'badge' => 'MÁS SOLICITADO',

            'features' => [
                'Investigación inicial de palabras clave',
                'Arquitectura web orientada a SEO y conversión',
                'Diseño de interfaz y experiencia de usuario en Figma',
                'Diseño personalizado y adaptable a todos los dispositivos',
                'Desarrollo de páginas de servicios y secciones estratégicas',
                'Formularios y elementos de captación de contactos',
                'Optimización técnica SEO inicial',
                'Integración de Analytics y Search Console cuando corresponda',
                'Pruebas de funcionamiento y lanzamiento',
            ],

            'note' => 'La creación de contenidos, el posicionamiento SEO mensual y las integraciones especiales se presupuestan según el alcance.',

            'service' => 'diseno-web',
            'project' => 'web-profesional',
        ],

        [
            'title' => 'Desarrollo a Medida',

            'description' => 'Para negocios que necesitan funcionalidades específicas, una plataforma propia o una web conectada con sus procesos comerciales.',

            'amount' => 'Presupuesto a medida',
            'currency' => '',
            'period' => '',

            'featured' => false,
            'badge' => '',

            'features' => [
                'Análisis de requisitos y objetivos del proyecto',
                'Diseño UX/UI adaptado a los usuarios',
                'Arquitectura y desarrollo modular',
                'Bases de datos y paneles de administración cuando se requieran',
                'Integraciones con servicios y herramientas externas',
                'Formularios y flujos personalizados',
                'Pruebas funcionales y de seguridad',
                'Preparación para futuras ampliaciones',
            ],

            'note' => 'El alcance, los plazos, las integraciones y el mantenimiento se definen en una propuesta personalizada.',

            'service' => 'diseno-web',
            'project' => 'desarrollo-a-medida',
        ],

    ],

    'button' => [
        'text' => 'Solicitar presupuesto',
        'url' => '/es/contacto',
    ],

];

?>

<section class="pricing-section web-design-pricing" id="precios-diseno-web">

    <div class="pricing-container">

        <div class="pricing-eyebrow">
            <span class="pricing-eyebrow-line"></span>

            <span class="pricing-eyebrow-text">
                <?= htmlspecialchars($pricing['eyebrow'], ENT_QUOTES, 'UTF-8') ?>
            </span>
        </div>

        <h2 class="pricing-title">
            <?= $pricing['title'] ?>
        </h2>

        <p class="web-design-pricing__intro">
            <?= htmlspecialchars($pricing['intro'], ENT_QUOTES, 'UTF-8') ?>
        </p>

        <div class="pricing-grid">

            <?php foreach ($pricing['plans'] as $index => $plan): ?>

                <?php
                $number = str_pad(
                    (string)($index + 1),
                    2,
                    '0',
                    STR_PAD_LEFT
                );

                $contactUrl = $pricing['button']['url']
                    . '?'
                    . http_build_query([
                        'servicio' => $plan['service'],
                        'proyecto' => $plan['project'],
                    ]);
                ?>

                <article class="pricing-card<?= $plan['featured'] ? ' pricing-card-featured' : '' ?>">

                    <?php if (!empty($plan['badge'])): ?>
                        <span class="pricing-badge">
                            <?= htmlspecialchars($plan['badge'], ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    <?php endif; ?>

                    <span class="pricing-num">
                        <?= $number ?>
                    </span>

                    <h3 class="pricing-card-title">
                        <?= htmlspecialchars($plan['title'], ENT_QUOTES, 'UTF-8') ?>
                    </h3>

                    <p class="pricing-card-description">
                        <?= htmlspecialchars($plan['description'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <div class="pricing-price">
                        <span class="pricing-amount">
                            <?= htmlspecialchars($plan['amount'], ENT_QUOTES, 'UTF-8') ?>
                        </span>

                        <?php if ($plan['currency'] !== ''): ?>
                            <span class="pricing-currency">
                                <?= htmlspecialchars($plan['currency'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        <?php endif; ?>

                        <?php if ($plan['period'] !== ''): ?>
                            <span class="pricing-period">
                                <?= htmlspecialchars($plan['period'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <ul class="pricing-features">

                        <?php foreach ($plan['features'] as $feature): ?>
                            <li>
                                <i class="fa-solid fa-check" aria-hidden="true"></i>

                                <span>
                                    <?= htmlspecialchars($feature, ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </li>
                        <?php endforeach; ?>

                    </ul>

                    <p class="pricing-card-note">
                        <?= htmlspecialchars($plan['note'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <a
                        href="<?= htmlspecialchars($contactUrl, ENT_QUOTES, 'UTF-8') ?>"
                        class="pricing-btn<?= $plan['featured'] ? ' pricing-btn-solid' : '' ?>"
                    >
                        <?= htmlspecialchars($pricing['button']['text'], ENT_QUOTES, 'UTF-8') ?>
                    </a>

                </article>

            <?php endforeach; ?>

        </div>

    </div>

</section>
