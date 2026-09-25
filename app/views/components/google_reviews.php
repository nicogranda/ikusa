<?php
/**
 * Componente: Google Reviews
 * Uso: include ROOT_PATH . '/app/views/Components/google_reviews.php';
 */

$googleReviews = [
    'rating'        => 5.0,
    'total_ratings' => 7,
    'reviews'       => [
        [
            'author'   => 'AVEGANAR',
            'avatar'   => '',
            'rating'   => 5,
            'text'     => "Excelente servicio y resultados impecables. Ikusa logró desarrollar nuestro branding, identidad visual y página web a medida con gran profesionalismo y creatividad.\n\nEl equipo demostró compromiso, calidad técnica (PHP, MySQL y JavaScript) y una atención al detalle extraordinaria, incluso en el diseño de nuestro merchandising institucional.\n\nTotalmente recomendados para quienes buscan una marca sólida y una presencia digital profesional.",
            'time_ago' => 'Hace 5 meses',
        ],
        [
            'author'   => 'Porlamar Servicio de Catering',
            'avatar'   => '',
            'rating'   => 5,
            'text'     => 'Trabajar con Ikusa ha sido un acierto total. Se encargan de todo: redes, branding y estrategia digital con una velocidad sorprendente. Son una verdadera maquinaria de marketing que te soluciona todo de forma integral. Muy satisfecho con los resultados.',
            'time_ago' => 'Hace 5 meses',
        ],
        [
            'author'   => 'BidMyCar',
            'avatar'   => '',
            'rating'   => 5,
            'text'     => 'Es nuestra Agencia de Marketing, nos han desarrollado la web, y el branding. Muy contentos con su propuesta y producción.',
            'time_ago' => 'Hace 5 meses',
        ],
        [
            'author'   => 'alvaro arocha',
            'avatar'   => '',
            'rating'   => 5,
            'text'     => 'Es una empresa de marketing/publicidad que cubre todas nuestras necesidades. Los resultados han sido fantásticos y estamos muy satisfechos con su trabajo. ¡Altamente recomendados!',
            'time_ago' => 'Hace un año',
        ],
        [
            'author'   => 'Borja Barrado Diseño Web Donostia',
            'avatar'   => '',
            'rating'   => 5,
            'text'     => 'Nicolás coincidió en mi curso de posicionamiento web - SEO y me gustaría recalcar que es un gran programador con muchos conocimientos en el mundo de la publicidad, marketing y redes sociales. Sin duda lo recomiendo.',
            'time_ago' => 'Hace 2 años',
        ],
        [
            'author'   => 'BB Kafe Donostia',
            'avatar'   => '',
            'rating'   => 5,
            'text'     => 'Una gran agencia de marketing, nos desarrollan nuestro portfolio.',
            'time_ago' => 'Hace 3 meses',
        ],
        [
            'author'   => 'Felicia Guilarte',
            'avatar'   => '',
            'rating'   => 5,
            'text'     => '',
            'time_ago' => 'Hace un año',
        ],
    ],
];

if (empty($googleReviews['reviews'])) {
    return;
}

$rating       = $googleReviews['rating'];
$totalRatings = $googleReviews['total_ratings'];
$reviews      = $googleReviews['reviews'];

function grRenderStars(float $rating, string $size = '18'): string
{
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($rating >= $i) {
            $fill = '#FBBC04';
        } elseif ($rating >= $i - 0.5) {
            $fill = 'url(#half-' . $size . ')';
        } else {
            $fill = '#E0E0E0';
        }
        $stars .= '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="' . $fill . '" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <defs>
                <linearGradient id="half-' . $size . '" x1="0" x2="1" y1="0" y2="0">
                    <stop offset="50%" stop-color="#FBBC04"/>
                    <stop offset="50%" stop-color="#E0E0E0"/>
                </linearGradient>
            </defs>
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
        </svg>';
    }
    return $stars;
}
?>

<section class="gr" aria-label="Reseñas de Google">

    <div class="gr__header">
        <div class="gr__brand">
            <svg class="gr__logo" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            <span class="gr__brand-text">Reseñas de Google</span>
        </div>
        <div class="gr__summary">
            <span class="gr__global-rating"><?= number_format($rating, 1, ',', '.') ?></span>
            <div class="gr__global-stars"><?= grRenderStars($rating, '20') ?></div>
            <span class="gr__total"><?= number_format($totalRatings, 0, ',', '.') ?> reseñas</span>
        </div>
    </div>

    <div class="gr__slider-wrapper">
        <button class="gr__nav gr__nav--prev" aria-label="Anterior" onclick="grSlide(this, -1)">
            <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>

        <div class="gr__track" role="list">
            <?php foreach ($reviews as $i => $review): ?>
            <article class="gr__card" role="listitem">
                <header class="gr__card-header">
                    <?php if (!empty($review['avatar'])): ?>
                        <img
                            class="gr__avatar"
                            src="<?= htmlspecialchars($review['avatar']) ?>"
                            alt="Foto de <?= htmlspecialchars($review['author']) ?>"
                            loading="lazy"
                            width="40" height="40"
                        >
                    <?php else: ?>
                        <div class="gr__avatar gr__avatar--placeholder" aria-hidden="true">
                            <?= mb_strtoupper(mb_substr($review['author'], 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <div class="gr__card-meta">
                        <span class="gr__author"><?= htmlspecialchars($review['author']) ?></span>
                        <span class="gr__time"><?= htmlspecialchars($review['time_ago']) ?></span>
                    </div>
                </header>
                <div class="gr__stars" aria-label="Valoración: <?= $review['rating'] ?> de 5">
                    <?= grRenderStars((float) $review['rating'], '16') ?>
                </div>
                <?php if (!empty($review['text'])): ?>
                <p class="gr__text"><?= nl2br(htmlspecialchars($review['text'])) ?></p>
                <?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>

        <button class="gr__nav gr__nav--next" aria-label="Siguiente" onclick="grSlide(this, 1)">
            <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
    </div>

    <div class="gr__dots" aria-hidden="true">
        <?php foreach ($reviews as $i => $review): ?>
        <span class="gr__dot<?= $i === 0 ? ' gr__dot--active' : '' ?>"></span>
        <?php endforeach; ?>
    </div>

    <div class="gr__cta">
        
        <a  href="https://g.page/r/CbP7i0R85bctEBM/review"
            target="_blank"
            rel="noopener noreferrer"
            class="gr__cta-link"
        >
            Déjanos tu reseña en Google
        </a>
    </div>

</section>

<style>
.gr {
    max-width: 1100px;
    margin: 0 auto;
    padding: 60px 20px;
    position: relative;
    z-index: 1;
}

.gr__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 32px;
}

.gr__brand {
    display: flex;
    align-items: center;
    gap: 10px;
}

.gr__logo {
    width: 28px;
    height: 28px;
    flex-shrink: 0;
}

.gr__brand-text {
    font-size: 20px;
    font-weight: 600;
    color: #0B0F19;
}

.gr__summary {
    display: flex;
    align-items: center;
    gap: 10px;
}

.gr__global-rating {
    font-size: 22px;
    font-weight: 700;
    color: #0B0F19;
}

.gr__global-stars {
    display: flex;
    gap: 2px;
}

.gr__total {
    font-size: 14px;
    color: #6b7280;
}

.gr__slider-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
}

.gr__nav {
    flex-shrink: 0;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 1px solid #e5e7eb;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s;
    z-index: 2;
}

.gr__nav:hover {
    background: #f3f4f6;
    border-color: #FF2400;
}

.gr__track {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    scroll-behavior: smooth;
    scroll-snap-type: x mandatory;
    padding: 4px;
    flex: 1;
    scrollbar-width: none;
}

.gr__track::-webkit-scrollbar {
    display: none;
}

.gr__card {
    flex: 0 0 320px;
    scroll-snap-align: start;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}

.gr__card-header {
    display: flex;
    align-items: center;
    gap: 12px;
}

.gr__avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}

.gr__avatar--placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #FF2400;
    color: #fff;
    font-weight: 700;
    font-size: 16px;
}

.gr__card-meta {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.gr__author {
    font-size: 15px;
    font-weight: 600;
    color: #0B0F19;
}

.gr__time {
    font-size: 13px;
    color: #9ca3af;
}

.gr__stars {
    display: flex;
    gap: 2px;
}

.gr__text {
    font-size: 14.5px;
    line-height: 1.5;
    color: #374151;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.gr__dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 20px;
}

.gr__dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #e5e7eb;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s;
}

.gr__dot--active {
    background: #FF2400;
    transform: scale(1.2);
}

.gr__cta {
    text-align: center;
    margin-top: 32px;
}

.gr__cta-link {
    display: inline-block;
    padding: 12px 28px;
    border-radius: 999px;
    background: #FF2400;
    color: #fff;
    font-weight: 600;
    font-size: 15px;
    text-decoration: none;
    transition: background 0.2s;
}

.gr__cta-link:hover {
    background: #d81e00;
}

@media (max-width: 640px) {
    .gr__card {
        flex: 0 0 85%;
    }
    .gr__header {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>