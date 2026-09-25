<?php
/**
 * Component: pricing.php
 * Datos → Vista → Styles
 * Sin dependencias de Bootstrap
 * Pendiente: precios por monedas
 */


/* =========================================================
   DATA
========================================================= */

$pricing = [

    'eyebrow' => 'PRECIOS',

    'title' => 'Simple, transparente,<br>sin sorpresas.',

    'plans' => [

        [
            'title' => 'Diagnóstico Web',

            'description' => 'Una primera revisión de tu presencia digital para detectar problemas y oportunidades antes de plantear cualquier servicio.',

            'amount' => 'Gratis',
            'currency' => '',
            'period' => '',

            'featured' => false,
            'badge' => '',

            'features' => [
                'Análisis rápido de tu presencia digital',
                'Detección de problemas críticos',
                'Recomendaciones prioritarias',
                'Reunión sin compromiso',
            ],

            'note' => 'Una primera valoración para conocer tu situación y determinar qué acciones pueden tener mayor impacto.',
        ],

        [
            'title' => 'SEO Profesional',

            'description' => 'Servicio mensual de posicionamiento SEO para mejorar de forma continua la visibilidad de tu negocio en Google y atraer búsquedas con intención comercial.',

            'amount' => 'Desde 445',
            'currency' => '€',
            'period' => '/mes',

            'featured' => true,
            'badge' => 'POPULAR',

            'features' => [
                'Auditoría SEO inicial de 53 módulos',
                'Optimización técnica y on-page continua',
                'Seguimiento de palabras clave y oportunidades',
                'Optimización y creación de contenidos SEO',
                'Enlazado interno y mejora de páginas estratégicas',
                'SEO local y Google Maps cuando aplica',
                'Seguimiento con Search Console y Analytics',
                'Dashboard de resultados en tiempo real',
            ],

            'note' => 'Servicio mensual. El alcance se adapta al tamaño, competencia y necesidades de cada proyecto.',
        ],

        [
            'title' => 'Google Ads (SEM)',

            'description' => 'Gestión profesional de campañas de Google Ads para captar clientes mediante búsquedas y campañas publicitarias orientadas a conversión.',

            'amount' => 'Desde 440',
            'currency' => '€',
            'period' => '/mes',

            'featured' => false,
            'badge' => '',

            'features' => [
                'Configuración y gestión de campañas',
                'Search, Shopping y Performance Max',
                'Investigación de palabras clave',
                'Optimización continua de campañas',
                'Seguimiento real de conversiones',
                'Coordinación de estrategia SEO + SEM',
            ],

            'note' => 'La inversión publicitaria en Google Ads no está incluida. La gestión se calcula según el alcance y la inversión de cada proyecto.',
        ],

        [
            'title' => 'Redes Sociales',

            'description' => 'Gestión mensual de redes sociales para mantener una presencia profesional, coherente con tu marca y orientada a conectar con tu público.',

            'amount' => 'Desde 486',
            'currency' => '€',
            'period' => '/mes',

            'featured' => false,
            'badge' => '',

            'features' => [
                'Instagram, Facebook y LinkedIn',
                'Creatividades adaptadas a tu identidad visual',
                'Calendario editorial mensual',
                'Planificación de contenidos',
                'Entre 2 y 5 publicaciones por semana',
                'Seguimiento de rendimiento',
            ],

            'note' => 'La frecuencia, redes y volumen de contenido se definen según las necesidades de cada marca.',
        ],

        [
            'title' => 'Mantenimiento WP',

            'description' => 'Mantenimiento técnico de sitios WordPress para mantener la web actualizada, respaldada, monitorizada y funcionando correctamente.',

            'amount' => 'Desde 50',
            'currency' => '€',
            'period' => '/mes',

            'featured' => false,
            'badge' => '',

            'features' => [
                'Actualizaciones de WordPress CORE',
                'Actualización de plugins',
                'Backup diario automático',
                'Monitorización 24/7',
                'Revisión de funcionamiento',
                'Soporte WooCommerce incluido',
            ],

            'note' => 'El precio depende del tamaño, complejidad y necesidades técnicas del sitio web.',
        ],

        [
            'title' => 'Auditoría SEO',

            'description' => 'Análisis completo del estado SEO de tu web para identificar problemas técnicos, oportunidades de posicionamiento y prioridades de mejora.',

            'amount' => '1.490',
            'currency' => '€',
            'period' => '/proyecto',

            'featured' => false,
            'badge' => '',

            'features' => [
                'Análisis completo de 53 módulos',
                'Revisión técnica y on-page',
                'Análisis de indexación y rastreo',
                'Evaluación de contenidos',
                'Detección de oportunidades SEO',
                'Informe técnico detallado',
                'Plan de acción priorizado',
                'Presentación ejecutiva incluida',
            ],

            'note' => 'Servicio puntual de auditoría. La implementación posterior de las mejoras se presupuesta según el alcance del proyecto.',
        ],

    ],

    'button' => [
        'text' => 'Solicitar información',
        'url' => '/es/contacto',
    ],

    'cta' => [
        'title' => '¿Listo para mejorar tu presencia digital?',
        'text' => 'Cuéntanos tu proyecto. Analizamos tu situación y te proponemos un plan adaptado a tus objetivos.',
        'button' => 'Solicitar diagnóstico gratis →',
        'url' => '/es/contacto',
        'subtext' => 'Sin compromiso. Respuesta en menos de 24h.',
    ],

];

?>


<!-- =======================================================
     VIEW
======================================================== -->

<section class="pricing-section">

    <div class="pricing-container">

        <div class="pricing-eyebrow">
            <span class="pricing-eyebrow-line"></span>

            <span class="pricing-eyebrow-text">
                <?= htmlspecialchars($pricing['eyebrow']) ?>
            </span>
        </div>


        <h2 class="pricing-title">
            <?= $pricing['title'] ?>
        </h2>


        <div class="pricing-grid">

            <?php foreach ($pricing['plans'] as $index => $plan): ?>

                <?php
                $number = str_pad(
                    (string) ($index + 1),
                    2,
                    '0',
                    STR_PAD_LEFT
                );
                ?>

                <article class="pricing-card<?= $plan['featured'] ? ' pricing-card-featured' : '' ?>">

                    <?php if (!empty($plan['badge'])): ?>
                        <span class="pricing-badge">
                            <?= htmlspecialchars($plan['badge']) ?>
                        </span>
                    <?php endif; ?>


                    <span class="pricing-num">
                        <?= $number ?>
                    </span>


                    <h3 class="pricing-card-title">
                        <?= htmlspecialchars($plan['title']) ?>
                    </h3>


                    <?php if (!empty($plan['description'])): ?>

                        <p class="pricing-card-description">
                            <?= htmlspecialchars($plan['description']) ?>
                        </p>

                    <?php endif; ?>


                    <div class="pricing-price">

                        <span class="pricing-amount">
                            <?= htmlspecialchars($plan['amount']) ?>
                        </span>

                        <?php if (!empty($plan['currency'])): ?>

                            <span class="pricing-currency">
                                <?= htmlspecialchars($plan['currency']) ?>
                            </span>

                        <?php endif; ?>


                        <?php if (!empty($plan['period'])): ?>

                            <span class="pricing-period">
                                <?= htmlspecialchars($plan['period']) ?>
                            </span>

                        <?php endif; ?>

                    </div>


                    <?php if (!empty($plan['features'])): ?>

                        <ul class="pricing-features">

                            <?php foreach ($plan['features'] as $feature): ?>

                                <li>
                                    <i class="fa-solid fa-check" aria-hidden="true"></i>

                                    <span>
                                        <?= htmlspecialchars($feature) ?>
                                    </span>
                                </li>

                            <?php endforeach; ?>

                        </ul>

                    <?php endif; ?>


                    <?php if (!empty($plan['note'])): ?>

                        <p class="pricing-card-note">
                            <?= htmlspecialchars($plan['note']) ?>
                        </p>

                    <?php endif; ?>


                    <a
                        href="<?= htmlspecialchars($pricing['button']['url']) ?>"
                        class="pricing-btn<?= $plan['featured'] ? ' pricing-btn-solid' : '' ?>"
                    >
                        <?= htmlspecialchars($pricing['button']['text']) ?>
                    </a>

                </article>

            <?php endforeach; ?>

        </div>

    </div>

</section>


<!-- =======================================================
     CTA
======================================================== -->

<section class="pricing-cta">

    <div class="pricing-container pricing-cta-inner">

        <h2 class="pricing-cta-title">
            <?= htmlspecialchars($pricing['cta']['title']) ?>
        </h2>

        <p class="pricing-cta-text">
            <?= htmlspecialchars($pricing['cta']['text']) ?>
        </p>

        <a
            href="<?= htmlspecialchars($pricing['cta']['url']) ?>"
            class="pricing-cta-btn"
        >
            <?= htmlspecialchars($pricing['cta']['button']) ?>
        </a>

        <p class="pricing-cta-sub">
            <?= htmlspecialchars($pricing['cta']['subtext']) ?>
        </p>

    </div>

</section>


<style>

/* =========================================================
   PRICING
========================================================= */

.pricing-section{
    --pricing-brand:var(--color-brand,#F15A24);
    background:#fff;
    padding:5rem 0;
}

.pricing-container{
    max-width:1200px;
    margin:0 auto;
    padding:0 20px;
}


/* EYEBROW */

.pricing-eyebrow{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    margin-bottom:1rem;
}

.pricing-eyebrow-line{
    width:24px;
    height:1px;
    background:#c4c4c4;
}

.pricing-eyebrow-text{
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-size:.75rem;
    letter-spacing:.15em;
    color:#9a9a9a;
}


/* TITLE */

.pricing-title{
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-weight:600;
    font-size:clamp(1.9rem,4vw,2.8rem);
    color:#0B0F19;
    line-height:1.2;
    text-align:center;
    margin:0 0 3rem;
}


/* GRID */

.pricing-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:1.5rem;
    align-items:stretch;
}


/* CARD */

.pricing-card{
    position:relative;
    background:#fff;
    border:1px solid #e2e2e2;
    border-radius:20px;
    padding:2rem;
    display:flex;
    flex-direction:column;
}

.pricing-card-featured{
    border-color:var(--pricing-brand);
    border-width:2px;
}

.pricing-badge{
    position:absolute;
    top:-14px;
    left:50%;
    transform:translateX(-50%);
    background:#0B0F19;
    color:#fff;
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-size:.7rem;
    letter-spacing:.1em;
    padding:.35rem .9rem;
    border-radius:999px;
}

.pricing-num{
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-size:.8rem;
    color:#a0a0a0;
}

.pricing-card-title{
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-weight:600;
    font-size:1.4rem;
    line-height:1.3;
    color:#0B0F19;
    margin:.5rem 0 .75rem;
}

.pricing-card-description{
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-size:.92rem;
    line-height:1.6;
    color:#666;
    margin:0 0 1.25rem;
}


/* PRICE */

.pricing-price{
    display:flex;
    align-items:baseline;
    flex-wrap:wrap;
    gap:.25rem;
    margin-bottom:1.5rem;
}

.pricing-amount{
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-weight:700;
    font-size:2.1rem;
    line-height:1.1;
    color:#0B0F19;
}

.pricing-currency{
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-size:1.1rem;
    color:#0B0F19;
}

.pricing-period{
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-size:.95rem;
    color:#9a9a9a;
}


/* FEATURES */

.pricing-features{
    list-style:none;
    padding:0;
    margin:0 0 1.5rem;
    flex-grow:1;
}

.pricing-features li{
    display:flex;
    align-items:flex-start;
    gap:.6rem;
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-size:.92rem;
    line-height:1.45;
    color:#444;
    margin-bottom:.8rem;
}

.pricing-features li i{
    flex:0 0 auto;
    font-size:.8rem;
    color:var(--pricing-brand);
    margin-top:4px;
}


/* NOTE */

.pricing-card-note{
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-size:.8rem;
    line-height:1.5;
    color:#777;
    border-top:1px solid #eee;
    padding-top:1rem;
    margin:0 0 1.5rem;
}


/* BUTTON */

.pricing-btn{
    display:block;
    text-align:center;
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-weight:600;
    color:var(--pricing-brand);
    border:1px solid var(--pricing-brand);
    border-radius:999px;
    padding:.85rem 1.5rem;
    text-decoration:none;
    transition:.2s ease;
}

.pricing-btn:hover{
    background:var(--pricing-brand);
    color:#fff;
}

.pricing-btn-solid{
    background:var(--pricing-brand);
    color:#fff;
}

.pricing-btn-solid:hover{
    filter:brightness(.9);
    color:#fff;
}


/* =========================================================
   CTA
========================================================= */

.pricing-cta{
    background:var(--color-brand,#F15A24);
    padding:5rem 0;
}

.pricing-cta-inner{
    text-align:center;
}

.pricing-cta-title{
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-weight:700;
    font-size:clamp(1.7rem,3vw,2.3rem);
    color:#fff;
    margin:0 0 .5rem;
}

.pricing-cta-text{
    max-width:720px;
    margin:0 auto 2rem;
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-size:1.1rem;
    line-height:1.6;
    color:rgba(255,255,255,.9);
}

.pricing-cta-btn{
    display:inline-block;
    background:#fff;
    color:#0B0F19;
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-weight:600;
    padding:1rem 2rem;
    border-radius:999px;
    text-decoration:none;
    transition:.2s ease;
}

.pricing-cta-btn:hover{
    transform:translateY(-2px);
}

.pricing-cta-sub{
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-size:.85rem;
    color:rgba(255,255,255,.75);
    margin:1rem 0 0;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:992px){

    .pricing-grid{
        grid-template-columns:repeat(2,1fr);
    }

}

@media(max-width:640px){

    .pricing-section{
        padding:4rem 0;
    }

    .pricing-grid{
        grid-template-columns:1fr;
    }

    .pricing-card{
        padding:1.6rem;
    }

    .pricing-cta{
        padding:4rem 0;
    }

}

</style>