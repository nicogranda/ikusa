<?php

define('PORTFOLIO_EXT', 'jpg');
define('PORTFOLIO_BASE', '/assets/img/portfolio/');

function portfolio_src(string $cat, string $file): string {
    return PORTFOLIO_BASE . $cat . '/' . $file . '.' . PORTFOLIO_EXT;
}

$portfolio = [

    'pop-displays' => [
        'label' => 'Material POP',
        'items' => [
            ['file' => 'promotional_caps',   'title' => 'Gorras promocionales',      'desc' => 'Merchandising corporativo'],
            ['file' => 'promotional_mugs',               'title' => 'Mugs',                      'desc' => 'Merchandising corporativo'],
            ['file' => 'promotional_pens',   'title' => 'Bolígrafos personalizados', 'desc' => 'Material promocional'],
            ['file' => 'insulated_tumblers', 'title' => 'Termos y botellas',         'desc' => 'Merchandising corporativo'],
            ['file' => 'branded_backpacks',  'title' => 'Morrales con marca',        'desc' => 'Material promocional'],
        ],
    ],

    'large-format-printing' => [
        'label' => 'Gigantografía',
        'items' => [
            ['file' => 'storefront_sign',        'title' => 'Rótulo de establecimiento', 'desc' => 'Señalética exterior'],
            ['file' => 'back_lit_sing',          'title' => 'Cartel luminoso',           'desc' => 'Señalética con retroiluminación'],
            ['file' => 'banner',                     'title' => 'Banner',                    'desc' => 'Impresión gran formato'],
            ['file' => 'hanging_banner',         'title' => 'Banner colgante',           'desc' => 'Impresión gran formato'],
            ['file' => 'large_formant_printing', 'title' => 'Impresión gran formato',    'desc' => 'Impresión gran formato'],
            ['file' => 'safety_sign',            'title' => 'Señalética de seguridad',   'desc' => 'Señalética industrial'],
        ],
    ],

    'print-collateral' => [
        'label' => 'Impresos',
        'items' => [
            ['file' => 'magazines',      'title' => 'Revistas',                 'desc' => 'Diseño editorial'],
            ['file' => 'calendars',      'title' => 'Calendarios',              'desc' => 'Material promocional'],
            ['file' => 'flyers',         'title' => 'Flyers',                   'desc' => 'Piezas impresas'],
            ['file' => 'business_cards', 'title' => 'Tarjetas de presentación', 'desc' => 'Branding'],
            ['file' => 'brochure',       'title' => 'Folletos',      'desc' =>  'Material impreso'],
        ],
    ],

];

?>

<style>
.portfolio-grid-section {
    margin-bottom: 3rem;
}

.portfolio-grid-section h2 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1.25rem;
    color: #111;
}

.portfolio-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 8px;
}

.portfolio-card {
    position: relative;
    overflow: hidden;
    border-radius: 6px;
    background: #f0f0f0;
    aspect-ratio: 1 / 1;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.portfolio-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.35s ease;
}

.portfolio-card:hover img {
    transform: scale(1.06);
}

.portfolio-card__overlay {
    display: none;
}

.portfolio-card__caption {
    padding: 0.4rem 0 0;
}

.portfolio-card__title {
    font-size: 0.8rem;
    font-weight: 600;
    color: #111;
    margin: 0 0 2px;
    line-height: 1.2;
}

.portfolio-card__desc {
    font-size: 0.7rem;
    color: #888;
    margin: 0;
    line-height: 1.3;
}

@media (max-width: 768px) {
    .portfolio-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 5px;
    }

    .portfolio-card__overlay {
        inset: 0;
        background: rgba(0, 0, 0, 0.62);
        display: none;
    }
}
</style>
<main style="margin:0 auto;width:80%; margin-top: 70px;">
<?php foreach ($portfolio as $catSlug => $cat): ?>
<section class="portfolio-grid-section">
    <h2><?= $cat['label'] ?></h2>
    <div class="portfolio-grid">
        <?php foreach ($cat['items'] as $item): ?>
        <div class="portfolio-item">
            <div class="portfolio-card">
                <img
                    src="<?= portfolio_src($catSlug, $item['file']) ?>"
                    alt="<?= htmlspecialchars($item['title']) ?>"
                    loading="lazy"
                >
            </div>
            <div class="portfolio-card__caption">
                <p class="portfolio-card__title"><?= htmlspecialchars($item['title']) ?></p>
                <p class="portfolio-card__desc"><?= htmlspecialchars($item['desc']) ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endforeach; ?>
</main>
