<?php

if (empty($translation) || !is_array($translation)) return;

$eyebrow  = $translation['hero_eyebrow'] ?? '';
$title    = $translation['h1'] ?? '';
$excerpt  = $translation['excerpt'] ?? '';

$sector   = $translation['project_sector'] ?? '';
$location = $translation['project_location'] ?? '';
$role     = $translation['project_role'] ?? '';
$website  = $translation['project_website'] ?? '';

$image    = $translation['hero_image'] ?? '';
$imageAlt = $translation['hero_image_alt'] ?? '';

$ctaText  = $translation['hero_cta_text'] ?? '';
$ctaUrl   = $translation['hero_cta_url'] ?? '';
?>

<section class="case-hero">

    <div class="case-hero__container">

        <div class="case-hero__content">

            <?php if ($eyebrow): ?>
                <div class="case-hero__eyebrow">
                    <?= htmlspecialchars($eyebrow) ?>
                </div>
            <?php endif; ?>

            <?php if ($title): ?>
                <h1 class="case-hero__title">
                    <?= $title ?>
                </h1>
            <?php endif; ?>

            <?php if ($excerpt): ?>
                <p class="case-hero__excerpt">
                    <?= htmlspecialchars($excerpt) ?>
                </p>
            <?php endif; ?>

            <div class="case-hero__meta">

                <?php if ($sector): ?>
                    <div class="case-hero__meta-item">
                        <span>Sector</span>
                        <strong><?= htmlspecialchars($sector) ?></strong>
                    </div>
                <?php endif; ?>

                <?php if ($location): ?>
                    <div class="case-hero__meta-item">
                        <span>Ubicación</span>
                        <strong><?= htmlspecialchars($location) ?></strong>
                    </div>
                <?php endif; ?>

                <?php if ($role): ?>
                    <div class="case-hero__meta-item case-hero__meta-item--wide">
                        <span>Trabajo realizado</span>
                        <strong><?= htmlspecialchars($role) ?></strong>
                    </div>
                <?php endif; ?>

                <?php if ($website): ?>
                    <div class="case-hero__meta-item">
                        <span>Website</span>
                        <strong><?= htmlspecialchars($website) ?></strong>
                    </div>
                <?php endif; ?>

            </div>

<?php if ($ctaText && $ctaUrl): ?>
    <a
        class="case-hero__cta"
        href="<?= htmlspecialchars($ctaUrl) ?>"
    >
        <?= htmlspecialchars($ctaText) ?> →
    </a>
<?php endif; ?>

        </div>


        <?php if ($image): ?>
            <div class="case-hero__visual">

                <img
                    src="<?= htmlspecialchars($image) ?>"
                    alt="<?= htmlspecialchars($imageAlt) ?>"
                    width="900"
                    height="650"
                    fetchpriority="high"
                >

                <?php if ($website): ?>
                    <div class="case-hero__website">
                        <?= htmlspecialchars($website) ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

    </div>

</section>

<style>
.case-hero{
    position:relative;
    background:#fff;
    color:#111;
    padding:100px 0 90px;
}

.case-hero__container{
    width:min(100% - 48px,1340px);
    margin:auto;
    display:grid;
    grid-template-columns:minmax(0,.9fr) minmax(0,1.1fr);
    gap:80px;
    align-items:center;
}

.case-hero__content{
    min-width:0;
}

.case-hero__eyebrow{
    margin-bottom:22px;
    font-family:var(--font-text);
    font-size:11px;
    font-weight:600;
    letter-spacing:.16em;
    text-transform:uppercase;
    color:#888;
}

.case-hero__title{
    margin:0 0 25px !important;
    padding:0 !important;
    font-family:var(--font-text) !important;
    font-size:clamp(48px,5vw,76px) !important;
    line-height:1.02 !important;
    font-weight:300 !important;
    letter-spacing:-.045em !important;
    text-transform:none !important;
    color:#111 !important;
}

.case-hero__title span{
    color:var(--color-primary);
}

.case-hero__excerpt{
    max-width:650px;
    margin:0 0 35px;
    font-family:var(--font-text);
    font-size:18px;
    line-height:1.65;
    color:#555;
}

.case-hero__meta{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:22px 35px;
    margin-bottom:35px;
}

.case-hero__meta-item{
    min-width:0;
}

.case-hero__meta-item--wide{
    grid-column:1/-1;
}

.case-hero__meta-item span{
    display:block;
    margin-bottom:5px;
    font-family:var(--font-text);
    font-size:10px;
    font-weight:600;
    letter-spacing:.14em;
    text-transform:uppercase;
    color:#999;
}

.case-hero__meta-item strong{
    display:block;
    font-family:var(--font-text);
    font-size:13px;
    line-height:1.5;
    font-weight:600;
    color:#111;
}

.case-hero__cta{
    display:inline-flex;
    align-items:center;
    min-height:48px;
    padding:0 25px;
    background:var(--color-primary);
    color:#fff;
    font-family:var(--font-text);
    font-size:12px;
    font-weight:600;
    letter-spacing:.1em;
    text-transform:uppercase;
    text-decoration:none;
    transition:opacity .2s ease;
}

.case-hero__cta:hover{
    opacity:.85;
}

.case-hero__visual{
    position:relative;
    min-width:0;
}

.case-hero__visual img{
    display:block;
    width:100%;
    height:auto;
    object-fit:contain;
}

.case-hero__website{
    margin-top:15px;
    text-align:right;
    font-family:var(--font-text);
    font-size:12px;
    letter-spacing:.08em;
    color:#888;
}

@media(max-width:900px){
    .case-hero{
        padding:75px 0;
    }

    .case-hero__container{
        grid-template-columns:1fr;
        gap:50px;
    }

    .case-hero__visual{
        order:-1;
    }
}

@media(max-width:600px){
    .case-hero{
        padding:55px 0;
    }

    .case-hero__container{
        width:min(100% - 32px,1340px);
    }

    .case-hero__title{
        font-size:clamp(42px,13vw,58px) !important;
    }

    .case-hero__meta{
        grid-template-columns:1fr;
    }

    .case-hero__meta-item--wide{
        grid-column:auto;
    }
}    
</style>