<?php

$lang = $lang ?? 'es';

$marca_i18n = [
    'es' => [
        'color'  => '#FF2400',
        'nombre' => 'Ikusa',
        'slogan' => 'Agencia de Diseño Web, SEO y Marketing Digital en Irun, Guipúzcoa',
    ],
    'en' => [
        'color'  => '#FF2400',
        'nombre' => 'Ikusa',
        'slogan' => 'Web Design, SEO and Digital Marketing Agency in Irun, Gipuzkoa',
    ],
];

$servicios_i18n = [
    'es' => [
        [
            'color'        => '#E91E8C',
            'color_soft'   => 'rgba(233, 30, 140, 0.1)',
            'color_border' => 'rgba(233, 30, 140, 0.3)',
            'icono'        => 'ti-palette',
            'titulo'       => 'Diseño Gráfico',
            'desc'         => 'Diseñamos para formatos online y offline. Tu marca con personalidad y coherencia visual.',
            'tags'         => ['Branding', 'Catálogos', 'Dípticos', 'Audiovisual'],
            'slug'         => 'diseno-grafico',
        ],
        [
            'color'        => '#00B4D8',
            'color_soft'   => 'rgba(0, 180, 216, 0.1)',
            'color_border' => 'rgba(0, 180, 216, 0.3)',
            'icono'        => 'ti-code',
            'titulo'       => 'Desarrollo Web',
            'desc'         => 'Diseñamos y programamos desde cero la web que tu empresa necesita para triunfar.',
            'tags'         => ['Páginas web', 'Tiendas online'],
            'slug'         => 'desarrollo-web',
        ],
        [
            'color'        => '#F5C800',
            'color_soft'   => 'rgba(245, 200, 0, 0.1)',
            'color_border' => 'rgba(245, 200, 0, 0.3)',
            'icono'        => 'ti-trending-up',
            'titulo'       => 'Marketing Digital',
            'desc'         => 'Estrategias para encontrar a tu cliente, convertirlo y fidelizarlo con resultados medibles.',
            'tags'         => ['SEO', 'SEM'],
            'slug'         => 'marketing-digital',
        ],
    ],
    'en' => [
        [
            'color'        => '#E91E8C',
            'color_soft'   => 'rgba(233, 30, 140, 0.1)',
            'color_border' => 'rgba(233, 30, 140, 0.3)',
            'icono'        => 'ti-palette',
            'titulo'       => 'Graphic Design',
            'desc'         => 'We design for online and offline formats. Your brand with personality and visual consistency.',
            'tags'         => ['Branding', 'Catalogs', 'Brochures', 'Audiovisual'],
            // TODO: confirmar slug real en inglés antes de publicar (ver nota abajo)
            'slug'         => 'graphic-design',
        ],
        [
            'color'        => '#00B4D8',
            'color_soft'   => 'rgba(0, 180, 216, 0.1)',
            'color_border' => 'rgba(0, 180, 216, 0.3)',
            'icono'        => 'ti-code',
            'titulo'       => 'Web Development',
            'desc'         => 'We design and build from scratch the website your business needs to succeed.',
            'tags'         => ['Websites', 'Online stores'],
            // TODO: confirmar si debe apuntar a /en/web-design-agency en vez de este slug
            'slug'         => 'web-development',
        ],
        [
            'color'        => '#F5C800',
            'color_soft'   => 'rgba(245, 200, 0, 0.1)',
            'color_border' => 'rgba(245, 200, 0, 0.3)',
            'icono'        => 'ti-trending-up',
            'titulo'       => 'Digital Marketing',
            'desc'         => 'Strategies to find your customer, convert them and build loyalty with measurable results.',
            'tags'         => ['SEO', 'SEM'],
            // TODO: confirmar si debe apuntar a /en/seo-company en vez de este slug
            'slug'         => 'digital-marketing',
        ],
    ],
];

$marca     = $marca_i18n[$lang]     ?? $marca_i18n['es'];
$servicios = $servicios_i18n[$lang] ?? $servicios_i18n['es'];

?>

<style>
    .servicios-wrap {
        padding: 56px 200px;
    }

    .servicios-eyebrow {
        font-size: 12px;
        letter-spacing: 0.12em;
        color: <?= $marca['color'] ?>;
        font-weight: 500;
        text-transform: uppercase;
        margin-bottom: 12px;
        text-align: center;
    }

    .servicios-title {
        font-size: 28px;
        font-weight: 500;
        color: #000;
        text-align: center;
        margin-bottom: 40px;
    }

    .card-title a,
    .card-title a:visited,
    .card-title a:hover,
    .card-title a:focus,
    .card-title a:active {
        color: #ffffff;
        text-decoration: none;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .card {
        border-radius: 10px;
        padding: 32px 28px;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        min-height: 280px;
        background: #111111;
        border: 0.5px solid rgba(255,255,255,0.08);
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: var(--accent);
    }

    .card-circle {
        position: absolute;
        bottom: -40px;
        right: -40px;
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: var(--accent);
        opacity: 0.07;
    }

    .card-icon-wrap {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        background: var(--accent-soft);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 20px;
        color: var(--accent);
    }

    .card-title {
        font-size: 18px;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 10px;
    }

    .card-desc {
        font-size: 13px;
        color: rgba(255,255,255,0.5);
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .card-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: auto;
    }

    .tag {
        font-size: 11px;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 999px;
        background: var(--accent-soft);
        color: var(--accent);
        border: 0.5px solid var(--accent-border);
    }

    .ikusa-bar {
        margin-top: 32px;
        border-radius: 10px;
        padding: 20px 28px;
        background: rgba(255, 36, 0, 0.08);
        border: 0.5px solid rgba(255, 36, 0, 0.25);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .ikusa-bar-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .ikusa-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: <?= $marca['color'] ?>;
        flex-shrink: 0;
    }

    .ikusa-bar-text {
        font-size: 13px;
        color: #000;
        line-height: 1.5;
    }

    .ikusa-bar-text strong {
        color: <?= $marca['color'] ?>;
        font-weight: 600;
    }

    .ikusa-label {
        font-size: 11px;
        color: <?= $marca['color'] ?>;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .color-legend {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 16px 24px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 0.5px solid rgba(255,255,255,0.08);
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 11px;
        color: #000;
    }

    .legend-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    @media (max-width: 900px) {
        .servicios-wrap {
            padding: 48px 40px;
        }

        .cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .card:last-child:nth-child(odd) {
            grid-column: 1 / -1;
            max-width: 50%;
            margin: 0 auto;
            width: 100%;
        }
    }

    @media (max-width: 600px) {
        .servicios-wrap {
            padding: 40px 20px;
        }

        .servicios-title {
            font-size: 22px;
        }

        .cards-grid {
            grid-template-columns: 1fr;
        }

        .card:last-child:nth-child(odd) {
            grid-column: auto;
            max-width: 100%;
        }

        .card {
            min-height: auto;
            padding: 24px 20px;
        }

        .ikusa-bar {
            flex-direction: column;
            align-items: flex-start;
            padding: 16px 20px;
        }

        .ikusa-label {
            display: none;
        }

        .color-legend {
            gap: 12px 16px;
        }
    }
</style>

<section class="servicios-wrap">

    <p class="servicios-eyebrow"><?= $lang === 'en' ? 'Our services' : 'Nuestros servicios' ?></p>
    <h2 class="servicios-title"><?= $lang === 'en' ? 'How can we help you?' : '¿En qué podemos ayudarte?' ?></h2>

    <div class="cards-grid">
        <?php foreach ($servicios as $servicio): ?>
        <div class="card" style="
            --accent: <?= $servicio['color'] ?>;
            --accent-soft: <?= $servicio['color_soft'] ?>;
            --accent-border: <?= $servicio['color_border'] ?>;
        ">
            <div class="card-circle"></div>
            <div class="card-icon-wrap">
                <i class="ti <?= $servicio['icono'] ?>"></i>
            </div>
            <h3 class="card-title"><a href="/<?= $lang ?>/<?= $servicio['slug'] ?>"><?= $servicio['titulo'] ?></a></h3>
            <p class="card-desc"><?= $servicio['desc'] ?></p>
            <div class="card-tags">
                <?php foreach ($servicio['tags'] as $tag): ?>
                <span class="tag"><?= $tag ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="ikusa-bar">
        <div class="ikusa-bar-left">
            <div class="ikusa-dot"></div>
            <p class="ikusa-bar-text">
                <strong><?= $marca['nombre'] ?></strong> — <?= $marca['slogan'] ?>
            </p>
        </div>
        <span class="ikusa-label"><?= $marca['nombre'] ?>®</span>
    </div>

    <div class="color-legend">
        <?php foreach ($servicios as $servicio): ?>
        <div class="legend-item">
            <div class="legend-dot" style="background: <?= $servicio['color'] ?>"></div>
            <?= $servicio['titulo'] ?>
        </div>
        <?php endforeach; ?>
        <div class="legend-item">
            <div class="legend-dot" style="background: <?= $marca['color'] ?>"></div>
            <?= $marca['nombre'] ?>
        </div>
    </div>

</section>