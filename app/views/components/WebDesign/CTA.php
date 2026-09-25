<?php
/**
 * Component: CTA
 *
 * Componente reutilizable y autocontenido.
 * Selecciona el contenido según la página actual y el idioma.
 *
 * No requiere variables $cta definidas en la vista.
 */

/* =========================================================
   IDIOMA
========================================================= */

$ctaLang = strtolower((string)($lang ?? 'es'));

if (!in_array($ctaLang, ['es', 'en', 'eu'], true)) {
    $ctaLang = 'es';
}

/* =========================================================
   IDENTIFICAR LA PÁGINA
========================================================= */

/*
 * Utiliza el slug de la página cuando está disponible.
 * También contempla la variable de ruta $page.
 *
 * Si tu controlador utiliza otro campo para el slug,
 * solo tendrás que ajustar este bloque.
 */

$ctaPage = '';

if (isset($page) && is_array($page)) {
    $ctaPage = (string)(
        $page['slug']
        ?? $page['reference']
        ?? ''
    );
} elseif (isset($page) && is_string($page)) {
    $ctaPage = $page;
}

if ($ctaPage === '' && isset($slug)) {
    $ctaPage = (string)$slug;
}

$ctaPage = strtolower(trim($ctaPage, '/'));

/* =========================================================
   CONTENIDO POR TIPO DE PÁGINA
========================================================= */

$ctaContent = [

    'seo' => [

        'es' => [
            'title'   => '¿Listo para hacer crecer tu tráfico orgánico?',
            'content' => 'Solicita una consultoría gratuita y descubre cómo una estrategia SEO a medida puede ayudar a tu negocio a aumentar su visibilidad, atraer clientes potenciales y generar más oportunidades de negocio.',
            'button'  => 'Quiero mejorar mi posicionamiento',
            'url'     => '/es/contacto',
        ],

        'en' => [
            'title'   => 'Ready to grow your organic traffic?',
            'content' => 'Request a free consultation and discover how a tailored SEO strategy can help your business increase visibility, attract potential customers and generate more business opportunities.',
            'button'  => 'Improve my search rankings',
            'url'     => '/en/contact',
        ],

        'eu' => [
            'title'   => 'Prest al zaude zure trafiko organikoa handitzeko?',
            'content' => 'Eskatu doako aholkularitza eta ezagutu neurrira egindako SEO estrategia batek zure negozioaren ikusgarritasuna handitzen eta bezero potentzialak erakartzen nola lagun dezakeen.',
            'button'  => 'Nire posizionamendua hobetu',
            'url'     => '/eu/kontaktua',
        ],

    ],

    'web-design' => [

        'es' => [
            'title'   => '¿Listo para crear una web que impulse tu negocio?',
            'content' => 'Cuéntanos tu proyecto. Diseñamos y desarrollamos páginas web a medida, preparadas para posicionarse en Google, ofrecer una excelente experiencia de usuario y convertir visitas en oportunidades de negocio.',
            'button'  => 'Hablemos de tu proyecto',
            'url'     => '/es/contacto',
        ],

        'en' => [
            'title'   => 'Ready to build a website that helps your business grow?',
            'content' => 'Tell us about your project. We design and develop custom websites built for search visibility, a great user experience and turning visitors into business opportunities.',
            'button'  => 'Let’s talk about your project',
            'url'     => '/en/contact',
        ],

        'eu' => [
            'title'   => 'Zure negozioa hazten lagunduko duen webgunea sortzeko prest?',
            'content' => 'Kontatu zure proiektua. Neurrira egindako webguneak diseinatu eta garatzen ditugu, bilatzaileetan ikusgarritasuna, erabiltzaile-esperientzia ona eta negozio-aukerak lortzeko.',
            'button'  => 'Hitz egin dezagun zure proiektuaz',
            'url'     => '/eu/kontaktua',
        ],

    ],

];

/* =========================================================
   SELECCIONAR CTA SEGÚN LA PÁGINA
========================================================= */

$ctaType = 'seo'; // CTA predeterminado para las páginas actuales.

$webDesignPages = [
    'desarrollo-web',
    'diseno-web',
    'diseno-web-donostia',
    'desarrollo-web-donostia',
    'web-design',
    'web-development',
];

if (in_array($ctaPage, $webDesignPages, true)) {
    $ctaType = 'web-design';
}

/*
 * También reconoce rutas como:
 * /es/diseno-web
 * /es/desarrollo-web
 */

if (
    $ctaType === 'seo'
    && isset($_SERVER['REQUEST_URI'])
) {
    $ctaPath = strtolower(
        (string)(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '')
    );

    $ctaPath = trim($ctaPath, '/');

    $ctaPathParts = explode('/', $ctaPath);

    $ctaLastSegment = end($ctaPathParts);

    if (in_array($ctaLastSegment, $webDesignPages, true)) {
        $ctaType = 'web-design';
    }
}

$ctaData = $ctaContent[$ctaType][$ctaLang]
    ?? $ctaContent[$ctaType]['es'];

?>

<section class="cta" aria-labelledby="cta-title">

    <div class="cta__inner">

        <h2 class="cta__title" id="cta-title">
            <?= htmlspecialchars($ctaData['title'], ENT_QUOTES, 'UTF-8') ?>
        </h2>

        <p class="cta__content">
            <?= htmlspecialchars($ctaData['content'], ENT_QUOTES, 'UTF-8') ?>
        </p>

        <a
            class="cta__button"
            href="<?= htmlspecialchars($ctaData['url'], ENT_QUOTES, 'UTF-8') ?>"
        >
            <?= htmlspecialchars($ctaData['button'], ENT_QUOTES, 'UTF-8') ?>

            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>

    </div>

</section>

<style>
/* =========================================================
   CTA — COMPONENTE GENERAL
========================================================= */

.cta {
    --cta-ink: var(--color-ink, #121826);
    --cta-paper: var(--color-paper-alt, #ffffff);
    --cta-brand: var(--color-primary, #f4511e);

    width: 100%;
    padding: 96px 24px;

    background: var(--cta-ink);
    color: var(--cta-paper);

    text-align: center;
}

.cta *,
.cta *::before,
.cta *::after {
    box-sizing: border-box;
}

.cta__inner {
    width: 100%;
    max-width: 760px;
    margin: 0 auto;
}

.cta .cta__title {
    position: static;

    margin: 0 0 20px;
    padding: 0;

    color: var(--cta-paper);
    background: transparent;

    font-family: var(
        --font-text,
        'Montserrat',
        Arial,
        sans-serif
    );

    font-size: clamp(30px, 4vw, 44px);
    font-weight: 700;
    line-height: 1.2;
    letter-spacing: -1px;

    text-align: center;
    transform: none;
}

.cta .cta__content {
    position: static;

    max-width: 680px;
    margin: 0 auto 34px;
    padding: 0;

    color: rgba(255, 255, 255, 0.78);
    background: transparent;

    font-family: var(
        --font-text,
        'Montserrat',
        Arial,
        sans-serif
    );

    font-size: 16px;
    font-weight: 400;
    line-height: 1.8;

    text-align: center;
    transform: none;
}

.cta .cta__button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 12px;

    min-height: 52px;
    padding: 14px 28px;

    border: 1px solid var(--cta-brand);
    border-radius: 4px;

    background: var(--cta-brand);
    color: #ffffff;

    font-family: var(
        --font-text,
        'Montserrat',
        Arial,
        sans-serif
    );

    font-size: 14px;
    font-weight: 600;
    line-height: 1.4;

    text-align: center;
    text-decoration: none;

    transition:
        background .25s ease,
        border-color .25s ease,
        color .25s ease;
}

.cta .cta__button:hover {
    background: transparent;
    border-color: #ffffff;
    color: #ffffff;
    transform: none;
}

.cta .cta__button:focus-visible {
    outline: 2px solid #ffffff;
    outline-offset: 4px;
}

.cta .cta__button i {
    color: inherit;
    font-size: 13px;
}

@media (max-width: 600px) {

    .cta {
        padding: 70px 20px;
    }

    .cta .cta__title {
        font-size: 30px;
    }

    .cta .cta__content {
        font-size: 14px;
    }

    .cta .cta__button {
        width: 100%;
        max-width: 340px;
    }

}

@media (prefers-reduced-motion: reduce) {

    .cta .cta__button {
        transition: none;
    }

}
</style>