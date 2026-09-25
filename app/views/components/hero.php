<?php
// app/views/components/hero.php

$title       = $content['h1'] ?? '';
$highlight   = $content['hero_highlight'] ?? '';
$description = $content['excerpt'] ?? '';
$image       = $content['og_image'] ?? '';
$eyebrow     = $content['hero_eyebrow'] ?? '';

$buttons = [
    [
        'label' => 'Hablemos de tu proyecto',
        'url'   => '/' . $language . '/contacto',
        'style' => 'primary',
        'icon'  => 'arrow'
    ]
];

$trustBar = [
    ['icon' => 'calendar', 'text' => '+5 años de experiencia'],
    ['icon' => 'location', 'text' => 'Con base en Gipuzkoa'],
    ['icon' => 'shield',   'text' => 'Un cliente por sector'],
    ['icon' => 'chart',    'text' => 'Resultados medibles'],
];


?>

<section class="landing-hero">

    <?php if ($image): ?>
        <div class="landing-hero__image">
            <img
                src="<?= htmlspecialchars($image) ?>"
                alt="<?= htmlspecialchars(strip_tags($highlight ?: $title)) ?>"
                loading="eager"
                fetchpriority="high"
            >
        </div>
    <?php endif; ?>

    <div class="landing-hero__overlay"></div>

    <div class="landing-hero__container">

        <div class="landing-hero__content">

            <?php if ($eyebrow): ?>
                <p class="landing-hero__eyebrow">
                    <?= htmlspecialchars($eyebrow) ?>
                </p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h1 class="landing-hero__title">

                    <?= $title ?>

                    <?php if ($highlight): ?>
                        <span><?= $highlight ?></span>
                    <?php endif; ?>

                </h1>
            <?php endif; ?>

            <?php if ($description): ?>
                <p class="landing-hero__description">
                    <?= $description ?>
                </p>
            <?php endif; ?>

            <?php if ($buttons): ?>
                <div class="landing-hero__actions">

                    <?php foreach ($buttons as $button): ?>
                        <?php include __DIR__ . '/button.php'; ?>
                    <?php endforeach; ?>

                </div>
            <?php endif; ?>

            <?php if ($trustBar): ?>
                <?php include __DIR__ . '/trust_bar.php'; ?>
            <?php endif; ?>

        </div>

    </div>

</section>

<style>
.landing-hero{
    position:relative;
    width:100%;
    min-height:95vh;
    display:flex;
    align-items:center;
    overflow:hidden;
}

.landing-hero__image{
    position:absolute;
    inset:0;
    z-index:1;
}

.landing-hero__image img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.landing-hero__overlay{
    position:absolute;
    inset:0;
    z-index:2;
    background:linear-gradient(
        90deg,
        rgba(0,0,0,.82) 0%,
        rgba(0,0,0,.62) 45%,
        rgba(0,0,0,.30) 100%
    );
}

.landing-hero__container{
    position:relative;
    z-index:3;
    width:100%;
    max-width:1400px;
    margin:auto;
    padding:150px 70px 80px;
}

.landing-hero__content{
    max-width:760px;
}

.landing-hero__eyebrow{
    margin:0 0 18px;
    color:var(--color-brand);
    font-size:13px;
    line-height:1;
    font-weight:700;
    letter-spacing:.14em;
    text-transform:uppercase;
}

.landing-hero__title{
    color:#fff;
    font-size:clamp(42px,4.5vw,64px);
    line-height:.95;
    font-weight:800;
    margin:0 0 30px;
}

.landing-hero__title span{
    display:block;
    color:var(--color-brand);
}

.landing-hero__description{
    color:#fff;
    font-size:20px;
    line-height:1.8;
    opacity:.95;
    margin:0 0 42px;
}

.landing-hero__actions{
    display:flex;
    gap:18px;
    flex-wrap:wrap;
    margin-bottom:40px;
}

.landing-hero .btn{
    min-width:240px;
    height:60px;
    border-radius:12px;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    transition:.25s;
}

.landing-hero .btn--primary{
    background:var(--color-brand);
    border:2px solid var(--color-brand);
    color:#fff;
}

.landing-hero .btn--primary:hover{
    background:#fff;
    color:var(--color-brand);
}

.landing-hero a,
.landing-hero a:visited,
.landing-hero a:hover{
    text-decoration:none;
}

/* TRUST BAR — TODO BLANCO */

.landing-hero .trust-bar,
.landing-hero .trust-bar *{
    color:#fff;
}

.landing-hero .trust-bar i,
.landing-hero .trust-bar svg{
    color:#fff;
}

.landing-hero .trust-bar svg{
    stroke:currentColor;
}

@media (max-width:991px){

    .landing-hero{
        min-height:100vh;
    }

    .landing-hero__container{
        padding:120px 24px 60px;
    }

    .landing-hero__eyebrow{
        font-size:11px;
        margin-bottom:16px;
    }

    .landing-hero__title{
        font-size:42px;
    }

    .landing-hero__title span{
        font-size:42px;
    }

    .landing-hero__description{
        font-size:16px;
    }

    .landing-hero__actions{
        flex-direction:column;
    }

    .landing-hero .btn{
        width:100%;
        min-width:0;
    }
}
</style>