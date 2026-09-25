<?php
/**
 * CTA general — IKUSA
 * Un único componente para todas las páginas.
 * El mensaje y el servicio del formulario dependen de la URL actual.
 */

$ctaLang = strtolower((string)($lang ?? 'es'));

if (!in_array($ctaLang, ['es', 'en', 'eu'], true)) {
    $ctaLang = 'es';
}

$ctaPath = strtolower(
    trim((string)(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? ''), '/')
);

$ctaSegments = explode('/', $ctaPath);
$ctaSlug = (string)end($ctaSegments);

/* Mensaje predeterminado */
$ctaType = 'general';

/* Identificación de la página */
if (in_array($ctaSlug, [
    'seo-donostia',
    'posicionamiento-seo',
    'agencia-seo',
    'seo',
], true)) {
    $ctaType = 'seo';
} elseif (in_array($ctaSlug, [
    'diseno-web-donostia',
    'diseno-web',
    'desarrollo-web',
    'desarrollo-web-donostia',
], true)) {
    $ctaType = 'diseno-web';
}

/* Contenidos */
$ctaMessages = [

    'general' => [
        'es' => [
            'title'   => '¿Hablamos de tu próximo proyecto?',
            'content' => 'Cuéntanos qué necesita tu negocio. Te ayudamos a definir una solución digital adaptada a tus objetivos.',
            'button'  => 'Cuéntanos tu proyecto',
        ],
        'en' => [
            'title'   => 'Shall we talk about your next project?',
            'content' => 'Tell us what your business needs. We will help you define a digital solution tailored to your goals.',
            'button'  => 'Tell us about your project',
        ],
        'eu' => [
            'title'   => 'Zure hurrengo proiektuaz hitz egingo dugu?',
            'content' => 'Kontatu zer behar duen zure negozioak. Zure helburuetara egokitutako irtenbide digitala definitzen lagunduko dizugu.',
            'button'  => 'Kontatu zure proiektua',
        ],
    ],

    'seo' => [
        'es' => [
            'title'   => '¿Quieres que tus clientes te encuentren en Google?',
            'content' => 'Cuéntanos qué servicios ofreces y dónde quieres posicionarte. Estudiaremos tu web y las oportunidades SEO para atraer visitas que puedan convertirse en clientes.',
            'button'  => 'Quiero mejorar mi SEO',
        ],
        'en' => [
            'title'   => 'Want your customers to find you on Google?',
            'content' => 'Tell us what you offer and where you want to rank. We will review your website and its SEO opportunities.',
            'button'  => 'I want to improve my SEO',
        ],
        'eu' => [
            'title'   => 'Zure bezeroek Googlen aurkitzea nahi duzu?',
            'content' => 'Kontatu zer zerbitzu eskaintzen dituzun eta non agertu nahi duzun. Zure webgunearen SEO aukerak aztertuko ditugu.',
            'button'  => 'Nire SEOa hobetu nahi dut',
        ],
    ],

    'diseno-web' => [
        'es' => [
            'title'   => '¿Necesitas una página web para tu negocio?',
            'content' => 'Cuéntanos qué tienes en mente: una web nueva, un rediseño o una tienda online. Diseñaremos una propuesta a medida, con una experiencia de usuario clara y orientada a conseguir contactos y ventas.',
            'button'  => 'Quiero mi página web',
        ],
        'en' => [
            'title'   => 'Need a website for your business?',
            'content' => 'Tell us whether you need a new website, a redesign or an online store. We will prepare a tailored proposal focused on usability and conversions.',
            'button'  => 'I want my website',
        ],
        'eu' => [
            'title'   => 'Zure negoziorako webgune bat behar duzu?',
            'content' => 'Kontatu webgune berria, birdiseinua edo online denda behar duzun. Zure beharretara egokitutako proposamena prestatuko dugu.',
            'button'  => 'Nire webgunea nahi dut',
        ],
    ],
];

$ctaData = $ctaMessages[$ctaType][$ctaLang]
    ?? $ctaMessages[$ctaType]['es'];

$ctaContactPaths = [
    'es' => '/es/contacto',
    'en' => '/en/contact',
    'eu' => '/eu/kontaktua',
];

$ctaContactUrl = $ctaContactPaths[$ctaLang]
    . '?servicio=' . rawurlencode($ctaType);

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
            href="<?= htmlspecialchars($ctaContactUrl, ENT_QUOTES, 'UTF-8') ?>"
        >
            <?= htmlspecialchars($ctaData['button'], ENT_QUOTES, 'UTF-8') ?>
            <span aria-hidden="true">→</span>
        </a>

        <p class="cta__note">
            Sin compromiso. Cuéntanos qué necesitas.
        </p>

    </div>
</section>

<style>
.cta {
    --cta-brand: var(--color-primary, #f4511e);

    width: 100%;
    padding: 90px 24px;
    background: var(--cta-brand);
    color: #fff;
    text-align: center;
}

.cta *,
.cta *::before,
.cta *::after {
    box-sizing: border-box;
}

.cta__inner {
    max-width: 850px;
    margin: 0 auto;
}

.cta .cta__title {
    position: static;
    margin: 0 0 18px;
    padding: 0;
    color: #fff;
    background: transparent;
    font-family: var(--font-text, 'Montserrat', Arial, sans-serif);
    font-size: clamp(30px, 4vw, 44px);
    font-weight: 700;
    line-height: 1.2;
    text-align: center;
    transform: none;
}

.cta .cta__content {
    position: static;
    max-width: 740px;
    margin: 0 auto 34px;
    padding: 0;
    color: #fff;
    background: transparent;
    font-family: var(--font-text, 'Montserrat', Arial, sans-serif);
    font-size: 17px;
    line-height: 1.7;
    text-align: center;
    transform: none;
}

.cta .cta__button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 54px;
    padding: 14px 32px;
    border: 1px solid #fff;
    border-radius: 50px;
    background: #fff;
    color: #191b20;
    font-family: var(--font-text, 'Montserrat', Arial, sans-serif);
    font-size: 15px;
    font-weight: 700;
    text-decoration: none;
    transition: background .2s ease, color .2s ease;
}

.cta .cta__button:hover {
    background: transparent;
    color: #fff;
}

.cta .cta__note {
    margin: 18px 0 0;
    color: #fff;
    font-size: 13px;
}

@media (max-width: 600px) {
    .cta {
        padding: 65px 20px;
    }

    .cta .cta__content {
        font-size: 15px;
    }

    .cta .cta__button {
        width: 100%;
        max-width: 340px;
    }
}
</style>