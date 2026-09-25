<?php
$seoResults = [
    "badge" => "Resultados reales",
    "title" => "Así crece tu negocio con una estrategia SEO efectiva",
    "description" => "Datos reales de un proyecto gestionado por Ikusa. Más visibilidad, más clics y mejores posiciones en Google.",
    "image" => "/assets/img/landings/google-search-console-results.png",
    "stats" => [
        ["value" => "+1,04 mil", "title" => "Clics orgánicos", "text" => "Más visitas cualificadas desde Google.", "icon" => "fa-solid fa-arrow-pointer"],
        ["value" => "+154 mil", "title" => "Impresiones", "text" => "Tu negocio aparece cada vez más en Google.", "icon" => "fa-solid fa-eye"],
        ["value" => "0,7%", "title" => "CTR medio", "text" => "Mayor interés de los usuarios.", "icon" => "fa-solid fa-chart-line"],
        ["value" => "9,5", "title" => "Posición media", "text" => "Más palabras clave en primera página.", "icon" => "fa-solid fa-trophy"],
    ],
];
?>
<section class="seo-results">

    <div class="container">

        <span class="seo-results__badge">
            <?= $seoResults['badge']; ?>
        </span>

        <h2><?= $seoResults['title']; ?></h2>

        <p class="seo-results__description">
            <?= $seoResults['description']; ?>
        </p>

        <div class="seo-results__image">

            <img
                src="<?= $seoResults['image']; ?>"
                alt="Resultados SEO reales"
                loading="lazy">

        </div>

        <div class="seo-results__stats">

            <?php foreach($seoResults['stats'] as $item): ?>

                <article class="seo-stat">

                    <i class="<?= $item['icon']; ?>"></i>

                    <div>

                        <strong><?= $item['value']; ?></strong>

                        <h3><?= $item['title']; ?></h3>

                        <p><?= $item['text']; ?></p>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </div>

</section>

<style>
    .seo-results{
    padding:90px 0;
    background:#fff;
}

.seo-results .container{
    max-width:1200px;
    margin:auto;
}

.seo-results__badge{
    display:inline-block;
    color:var(--color-brand);
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:2px;
    margin-bottom:15px;
}

.seo-results h2{
    font-size:clamp(34px,4vw,58px);
    margin-bottom:20px;
}

.seo-results__description{
    max-width:760px;
    margin:0 auto 50px;
    font-size:20px;
    color:#666;
    text-align:center;
}

.seo-results__image img{
    width:100%;
    border-radius:20px;
    box-shadow:0 25px 70px rgba(0,0,0,.12);
}

.seo-results__stats{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:25px;
    margin-top:50px;
}

.seo-stat{
    background:#fff;
    border:1px solid #eee;
    border-radius:16px;
    padding:24px;
    display:flex;
    gap:18px;
}

.seo-stat i{
    color:var(--color-brand);
    font-size:30px;
}

.seo-stat strong{
    display:block;
    font-size:34px;
    color:var(--color-brand);
}

.seo-stat h3{
    margin:8px 0;
    font-size:18px;
}

.seo-stat p{
    color:#666;
    font-size:.95rem;
}

@media(max-width:991px){

.seo-results__stats{
    grid-template-columns:1fr;
}

}
</style>