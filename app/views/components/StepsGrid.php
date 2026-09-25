<?php

$stepsGrid = [
    'id' => 'proceso-rediseño-seo',

    'title' => 'Un rediseño <span>con red de seguridad</span>',

   'excerpt' => 'Un rediseño con red de seguridad: primero el SEO, después el diseño y, finalmente, una migración medida al milímetro.',
   
    'steps' => [
        [
            'title' => 'Revisión SEO completa',
            'text'  => 'Inventario de URLs, keywords y páginas con tráfico para blindar cada decisión del rediseño.'
        ],
        [
            'title' => 'Nueva arquitectura web',
            'text'  => 'Jerarquía clara de servicios y contenidos: mejor para el usuario y para el rastreo de los buscadores.'
        ],
        [
            'title' => 'Flujos de usuario y navegabilidad',
            'text'  => 'Menús y recorridos rediseñados para que el usuario llegue antes y con menos fricción a la conversión.'
        ],
        [
            'title' => 'Customer journey completo',
            'text'  => 'Nuevas páginas que cubren cada fase del recorrido del cliente, del descubrimiento a la decisión.'
        ],
        [
            'title' => 'Plan de migración',
            'text'  => 'Mapa de redirecciones 1:1, checklist técnico y validación en entorno de pruebas antes del cambio.'
        ],
        [
            'title' => 'Migración sin pérdida de tráfico',
            'text'  => 'Lanzamiento coordinado con desarrollo y monitorización post-migración hasta confirmar la estabilidad.'
        ],
        [
            'title' => 'Analítica y CRM verificados',
            'text'  => 'GA4, eventos, conversiones y conexión con el CRM comprobados de punta a punta, sin huecos de datos.'
        ],
        [
            'title' => 'Implementaciones nuevas',
            'text'  => 'Mejoras técnicas y funcionales que la web anterior no permitía, incorporadas desde el lanzamiento.'
        ]
    ]
];

//include __DIR__ . '/StepsGrid.php';
?>
<?php
/**
 * IKUSA — Steps Grid Component
 *
 * Uso:
 * $stepsGrid = [
 *     'title' => 'Un rediseño <span>con red<br>de seguridad</span>',
 *     'excerpt' => 'Un rediseño con red de seguridad: primero el SEO, después el diseño...',
 *     'steps' => [...]
 * ];
 *
 * include __DIR__ . '/StepsGrid.php';
 */

if (empty($stepsGrid) || !is_array($stepsGrid)) return;

$title   = $stepsGrid['title'] ?? '';
$excerpt = $stepsGrid['excerpt'] ?? '';
$steps   = $stepsGrid['steps'] ?? [];
$id      = $stepsGrid['id'] ?? 'ikusa-steps';
?>

<section class="ik-steps" id="<?= htmlspecialchars($id) ?>">
    <div class="ik-steps__container">

        <?php if ($title || $excerpt): ?>
            <header class="ik-steps__header">

                <?php if ($title): ?>
                    <h2 class="ik-steps__title">
                        <?= $title ?>
                    </h2>
                <?php endif; ?>

                <?php if ($excerpt): ?>
                    <p class="ik-steps__excerpt">
                        <?= htmlspecialchars($excerpt) ?>
                    </p>
                <?php endif; ?>

            </header>
        <?php endif; ?>

        <?php if ($steps): ?>
            <div class="ik-steps__grid">

                <?php foreach ($steps as $index => $step): ?>
                    <article class="ik-steps__item">

                        <span class="ik-steps__number" aria-hidden="true">
                            <?= str_pad($index + 1, 2, '0', STR_PAD_LEFT) ?>
                        </span>

                        <h3 class="ik-steps__item-title">
                            <?= htmlspecialchars($step['title'] ?? '') ?>
                        </h3>

                        <?php if (!empty($step['text'])): ?>
                            <p class="ik-steps__text">
                                <?= htmlspecialchars($step['text']) ?>
                            </p>
                        <?php endif; ?>

                    </article>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>

    </div>
</section>

<style>
.ik-steps,
.ik-steps__container,
.ik-steps__header,
.ik-steps__title,
.ik-steps__excerpt,
.ik-steps__grid{
    position:static !important;
    top:auto !important;
    right:auto !important;
    bottom:auto !important;
    left:auto !important;
    transform:none !important;
}

.ik-steps{
    background:#080808;
    color:#fff;
    padding:110px 0;
}

.ik-steps__container{
    width:min(100% - 48px,1340px);
    margin:auto;
}

.ik-steps__header{
    display:block;
    width:100%;
    max-width:720px;
    margin:0 0 55px;
    padding:0;
}

.ik-steps__title{
    display:block;
    width:100%;
    max-width:720px;
    margin:0 0 24px !important;
    padding:0 !important;
    font-family:var(--font-text) !important;
    font-size:clamp(42px,4vw,62px) !important;
    line-height:1.05 !important;
    font-weight:300 !important;
    letter-spacing:-.035em !important;
    text-transform:none !important;
    color:#f3f3f3 !important;
}

.ik-steps__title span{
    color:var(--color-primary) !important;
}

.ik-steps__excerpt{
    display:block;
    width:100%;
    max-width:650px;
    margin:0 !important;
    padding:0 !important;
    font-family:var(--font-text);
    font-size:18px;
    line-height:1.65;
    font-weight:400;
    color:#aaa;
}

.ik-steps__grid{
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    width:100%;
    border-top:1px solid rgba(255,255,255,.1);
    border-left:1px solid rgba(255,255,255,.1);
}

.ik-steps__item{
    min-width:0;
    min-height:180px;
    padding:30px;
    border-right:1px solid rgba(255,255,255,.1);
    border-bottom:1px solid rgba(255,255,255,.1);
    transition:background .25s ease;
}

.ik-steps__item:hover{
    background:rgba(255,255,255,.025);
}

.ik-steps__number{
    display:block;
    margin:0 0 12px;
    font-family:var(--font-text);
    font-size:34px;
    line-height:1;
    font-weight:300;
    color:var(--color-primary);
}

.ik-steps__item-title{
    margin:0 0 10px !important;
    padding:0 !important;
    font-family:var(--font-text) !important;
    font-size:16px !important;
    line-height:1.35 !important;
    font-weight:600 !important;
    text-transform:none !important;
    color:#f5f5f5 !important;
}

.ik-steps__text{
    margin:0 !important;
    padding:0 !important;
    font-family:var(--font-text);
    font-size:14px;
    line-height:1.6;
    color:#aaa;
}

@media(max-width:900px){
    .ik-steps{
        padding:80px 0;
    }

    .ik-steps__grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
}

@media(max-width:600px){
    .ik-steps{
        padding:65px 0;
    }

    .ik-steps__container{
        width:min(100% - 32px,1340px);
    }

    .ik-steps__header{
        margin-bottom:40px;
    }

    .ik-steps__title{
        font-size:clamp(38px,12vw,52px) !important;
    }

    .ik-steps__excerpt{
        font-size:16px;
    }

    .ik-steps__grid{
        grid-template-columns:1fr;
    }

    .ik-steps__item{
        min-height:auto;
        padding:25px;
    }
}
</style>