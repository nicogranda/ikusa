<?php

$fases = [
    [
        'numero'  => '01',
        'icono'   => 'ti-search',
        'titulo'  => 'Estudio del proyecto',
        'desc'    => 'Analizamos cuáles son tus objetivos, el público al que nos dirigimos y estudiamos a la competencia. A partir del estudio te presentamos un proyecto web y una estrategia de marketing digital ganadoras.',
    ],
    [
        'numero'  => '02',
        'icono'   => 'ti-palette',
        'titulo'  => 'Diseño web',
        'desc'    => 'Nuestros diseñadores querrán conocer tus gustos y las referencias del sector. Te propondrán un diseño a medida de las principales páginas de tu futura web, que discutiremos, enmendaremos y aprobaremos.',
    ],
    [
        'numero'  => '03',
        'icono'   => 'ti-code',
        'titulo'  => 'Programación',
        'desc'    => 'Nuestros programadores crean el código de la web para que responda al diseño planteado e incorpore todas las funcionalidades necesarias. Realizamos pruebas de calidad y seguridad.',
    ],
    [
        'numero'  => '04',
        'icono'   => 'ti-chart-bar',
        'titulo'  => 'SEO',
        'desc'    => 'A partir de un estudio de palabras clave y una estrategia acordada, preparamos los fundamentos de la web para que sea rastreada por los buscadores y esté lista para posicionar.',
    ],
    [
        'numero'  => '05',
        'icono'   => 'ti-rocket',
        'titulo'  => 'Seguimiento y mejora continua',
        'desc'    => 'La publicación de la web solo es el comienzo. Esta necesita atraer tráfico cualificado, darse a conocer y generar ventas a través del SEO y el SEM. Haremos seguimiento y mejoras constantes para crecer contigo.',
    ],
];

?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            /*background: #0a0a0a;*/
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .fases-wrap {
            /*background: #111111;*/
            max-width: 780px;
            margin: 48px auto;
            padding: 56px 48px;
            border-radius: 12px;
        }

        .fases-eyebrow {
            font-size: 12px;
            letter-spacing: 0.12em;
            color: #FF5E1F;
            font-weight: 500;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .fases-title {
            font-size: 30px;
            font-weight: 500;
            /*color: #ffffff;*/
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .fases-sub {
            font-size: 14px;
            /*color: rgba(255,255,255,0.45);*/
            margin-bottom: 48px;
            max-width: 520px;
            line-height: 1.6;
        }

        .fase-row {
            display: grid;
            grid-template-columns: 48px 1fr;
            gap: 0 20px;
        }

        .fase-left {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .fase-num {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 94, 31, 0.12);
            border: 0.5px solid rgba(255, 94, 31, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 500;
            color: #FF5E1F;
            flex-shrink: 0;
        }

        .fase-line {
            width: 0.5px;
            flex: 1;
            background: rgba(255, 255, 255, 0.1);
            margin: 4px 0;
            min-height: 32px;
        }

        .fase-row:last-child .fase-line {
            display: none;
        }

        .fase-content {
            padding: 10px 0 40px;
        }

        .fase-row:last-child .fase-content {
            padding-bottom: 0;
        }

        .fase-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .fase-icon {
            font-size: 17px;
            color: #FF5E1F;
        }

        .fase-name {
            font-size: 16px;
            font-weight: 500;
            /*color: #ffffff;*/
        }

        .fase-desc {
            font-size: 13px;
            /*color: rgba(255, 255, 255, 0.5);*/
            line-height: 1.65;
            max-width: 560px;
        }
    </style>
</head>
<body>

<section class="fases-wrap">

    <p class="fases-eyebrow">Nuestro proceso</p>
    <h2 class="fases-title">Las fases de una página web</h2>
    <p class="fases-sub">Para alcanzar un sitio web exitoso las cosas deben hacerse con el cuidado necesario y en el orden correspondiente — el orden de los factores sí altera el producto.</p>

    <?php foreach ($fases as $fase): ?>
    <div class="fase-row">

        <div class="fase-left">
            <div class="fase-num"><?= $fase['numero'] ?></div>
            <div class="fase-line"></div>
        </div>

        <div class="fase-content">
            <div class="fase-header">
                <i class="ti <?= $fase['icono'] ?> fase-icon" aria-hidden="true"></i>
                <p class="fase-name"><?= $fase['titulo'] ?></p>
            </div>
            <p class="fase-desc"><?= $fase['desc'] ?></p>
        </div>

    </div>
    <?php endforeach; ?>

</section>
