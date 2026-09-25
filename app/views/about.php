<?php

$about = [
    'hero' => [
        'eyebrow'  => 'Irún, Gipuzkoa · Desde 1998',
        'title'    => 'No somos una agencia de Madrid que atiende Donostia por teléfono.',
        'title_em' => 'por teléfono.',
        'body'     => 'Llevamos más de 25 años posicionando marcas. Primero en América Latina, hoy desde Gipuzkoa. Conocemos el mercado local, el mercado bilingüe y la dinámica de búsqueda del consumidor vasco.',
        'cta_primary'   => ['label' => 'Cuéntanos tu proyecto', 'href' => '/es/contacto'],
        'cta_secondary' => ['label' => 'Ver clientes', 'href' => '#clientes'],
        'stats' => [
            ['num' => '+25', 'label' => 'Años de trayectoria'],
            ['num' => '1',   'label' => 'Cliente por sector y zona'],
            ['num' => '3',   'label' => 'Idiomas: es · eu · en'],
            ['num' => '18',  'label' => 'Años con Avalón Estetic'],
        ],
        'badge' => 'Si ya trabajamos con tu competidor, te lo decimos desde el primer día.',
    ],

    'origen' => [
        'eyebrow' => 'Nuestro origen',
        'title'   => 'Una agencia con historia real detrás',
        'body'    => 'Ikusa no nació de la nada. Es la evolución de más de dos décadas gestionando marcas y campañas en mercados exigentes.',
        'timeline' => [
            ['year' => '1998', 'text' => 'Fundación de <strong>Cadena Panamericana</strong>.'],
            ['year' => '2006', 'text' => 'Relación con <strong>Avalón Estetic</strong>.'],
            ['year' => '2021', 'text' => 'Transformación en <strong>Ikusa Digital</strong>.'],
            ['year' => 'Hoy',  'text' => 'Operación desde Gipuzkoa con foco local real.'],
        ],
    ],

    'compromiso' => [
        'title' => 'Un compromiso que pocas agencias se atreven a hacer',
        'body'  => 'Exclusividad por sector y zona. No competimos con nuestros propios clientes.',
        'badge' => 'Exclusividad por sector y por zona geográfica',
    ],

    'clientes' => [
        'eyebrow' => 'Clientes en Gipuzkoa',
        'title'   => 'Relaciones de largo plazo, no proyectos puntuales',
        'items'   => [
            ['nombre' => 'Avalón Estetic', 'desc' => 'Clínica de medicina estética en Donostia.', 'tag' => 'Desde 2006'],
            ['nombre' => 'BB Specialty Coffee', 'desc' => 'Cafetería en Antiguo.', 'tag' => 'Antiguo'],
        ],
    ],

    'valores' => [
        'eyebrow' => 'Cómo trabajamos',
        'title'   => 'Lo que nos diferencia',
        'items'   => [
            ['icon' => 'ti-map-pin', 'title' => 'Presencia local real', 'body' => 'Vivimos y trabajamos en Gipuzkoa.'],
            ['icon' => 'ti-language', 'title' => 'Mercado bilingüe', 'body' => 'SEO en castellano y euskera.'],
        ],
    ],

    'cta' => [
        'eyebrow' => '¿Hablamos?',
        'title'   => 'Diagnóstico en 48 horas',
        'body'    => 'Sin compromiso.',
        'whatsapp' => [
            'num'  => '+34 600 142 663',
            'href' => 'https://wa.me/34600142663'
        ],
        'address' => 'Calle General Freire, 5 · Irún'
    ],
];

// Helpers
$titleParts = explode($about['hero']['title_em'], $about['hero']['title']);
$titleBefore = $titleParts[0] ?? '';

?>

<!-- HERO -->
<section class="about-hero">
    <div class="about-hero__content">

        <div class="about-eyebrow">
            <?= htmlspecialchars($about['hero']['eyebrow']) ?>
        </div>

        <h1 class="about-hero__title">
            <?= htmlspecialchars($titleBefore) ?><em><?= htmlspecialchars($about['hero']['title_em']) ?></em>
        </h1>

        <p class="about-hero__body">
            <?= htmlspecialchars($about['hero']['body']) ?>
        </p>

        <div class="about-hero__actions">
            <a href="<?= $about['hero']['cta_primary']['href'] ?>" class="btn btn--primary">
                <?= htmlspecialchars($about['hero']['cta_primary']['label']) ?>
            </a>
            <a href="<?= $about['hero']['cta_secondary']['href'] ?>" class="btn btn--ghost">
                <?= htmlspecialchars($about['hero']['cta_secondary']['label']) ?>
            </a>
        </div>

        <div class="about-hero__badge">
            <i class="ti ti-shield-check"></i>
            <?= htmlspecialchars($about['hero']['badge']) ?>
        </div>

    </div>


    <div class="about-stats">
        <?php foreach ($about['hero']['stats'] as $stat): ?>
            <div class="about-stat">
                <strong class="about-stat__num"><?= htmlspecialchars($stat['num']) ?></strong>
                <span class="about-stat__label"><?= htmlspecialchars($stat['label']) ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ORIGEN -->
<section class="about-origen">
    <div class="about-eyebrow">
        <?= htmlspecialchars($about['origen']['eyebrow']) ?>
    </div>
    <h2><?= htmlspecialchars($about['origen']['title']) ?></h2>
    <p class="about-lead"><?= htmlspecialchars($about['origen']['body']) ?></p>

    <ul class="about-timeline">
        <?php foreach ($about['origen']['timeline'] as $item): ?>
            <li class="about-timeline__item">
                <span class="about-timeline__year"><?= htmlspecialchars($item['year']) ?></span>
                <span class="about-timeline__text"><?= $item['text'] ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<?php
$dir = __DIR__ . '/../../public_html/assets/img/rrhh'; // Ajusta la ruta según tu proyecto

$imagenes = glob($dir . '/*.{jpg,jpeg,png,webp,gif,avif}', GLOB_BRACE);
?>

<div class="rrhh-gallery">
    <?php foreach ($imagenes as $imagen): ?>
        <img
            src="/assets/img/rrhh/<?= basename($imagen); ?>"
            alt=""
            loading="lazy"
        >
    <?php endforeach; ?>
</div>
<style>
    .rrhh-gallery{
    display:flex;
    gap:20px;
    justify-content:center;
    align-items:flex-start;
    flex-wrap:nowrap;
}

.rrhh-gallery img{
    width:100%;
    max-width:300px;
    height:auto;
    border-radius:10px;
    object-fit:cover;
}

/* Móvil */
@media (max-width:768px){

    .rrhh-gallery{
        flex-direction:column;
        align-items:center;
    }

    .rrhh-gallery img{
        max-width:100%;
    }

}
</style>

<!-- COMPROMISO -->
<section class="about-compromiso">
    <div class="about-compromiso__card">
        <div class="about-eyebrow" style="color:rgba(255,255,255,.6);">Nuestro compromiso</div>
        <h2><?= htmlspecialchars($about['compromiso']['title']) ?></h2>
        <p><?= htmlspecialchars($about['compromiso']['body']) ?></p>
        <div class="about-compromiso__badge">
            <i class="ti ti-shield-check"></i>
            <?= htmlspecialchars($about['compromiso']['badge']) ?>
        </div>
    </div>
</section>

<!-- CLIENTES -->
<section class="about-clientes" id="clientes">
    <div class="about-eyebrow">
        <?= htmlspecialchars($about['clientes']['eyebrow']) ?>
    </div>
    <h2><?= htmlspecialchars($about['clientes']['title']) ?></h2>

    <ul class="about-clientes__grid">
        <?php foreach ($about['clientes']['items'] as $cliente): ?>
            <li class="about-cliente">
                <strong class="about-cliente__nombre"><?= htmlspecialchars($cliente['nombre']) ?></strong>
                <p class="about-cliente__desc"><?= htmlspecialchars($cliente['desc']) ?></p>
                <span class="about-cliente__tag"><?= htmlspecialchars($cliente['tag']) ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<!-- VALORES -->
<section class="about-valores">
    <div class="about-eyebrow">
        <?= htmlspecialchars($about['valores']['eyebrow']) ?>
    </div>
    <h2><?= htmlspecialchars($about['valores']['title']) ?></h2>

    <ul class="about-valores__grid">
        <?php foreach ($about['valores']['items'] as $valor): ?>
            <li class="about-valor">
                <div class="about-valor__icon">
                    <i class="ti <?= htmlspecialchars($valor['icon']) ?>"></i>
                </div>
                <h3><?= htmlspecialchars($valor['title']) ?></h3>
                <p><?= htmlspecialchars($valor['body']) ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<!-- CTA -->
<section class="about-cta">
    <div class="about-eyebrow" style="justify-content:center;">
        <?= htmlspecialchars($about['cta']['eyebrow']) ?>
    </div>
    <h2><?= htmlspecialchars($about['cta']['title']) ?></h2>
    <p><?= htmlspecialchars($about['cta']['body']) ?></p>

    <a href="<?= $about['cta']['whatsapp']['href'] ?>" class="btn btn--primary" target="_blank" rel="noopener">
        <i class="ti ti-brand-whatsapp"></i>
        WhatsApp <?= htmlspecialchars($about['cta']['whatsapp']['num']) ?>
    </a>

    <p class="about-cta__address">
        <i class="ti ti-map-pin"></i>
        <?= htmlspecialchars($about['cta']['address']) ?>
    </p>
</section>

<style>
/* ==========================
   ABOUT
========================== */

.about-hero,
.about-origen,
.about-compromiso,
.about-clientes,
.about-valores,
.about-cta {
    padding: 6rem 0;
}

.about-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    font-size: .85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--primary);
    margin-bottom: 1rem;
}

.about-lead {
    max-width: 800px;
    font-size: 1.15rem;
    line-height: 1.8;
    color: #666;
}

/* ==========================
   HERO
========================== */

.about-hero {
    display: grid;
    grid-template-columns: 1.3fr .7fr;
    gap: 4rem;
    align-items: center;
}

.about-hero__title {
    font-size: clamp(2.5rem, 5vw, 4.8rem);
    line-height: 1.05;
    margin-bottom: 1.5rem;
}

.about-hero__title em {
    font-style: normal;
    color: var(--primary);
}

.about-hero__body {
    font-size: 1.15rem;
    line-height: 1.8;
    color: #666;
    max-width: 720px;
}

.about-hero__actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 2rem;
}

.about-stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}

.about-stat {
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 16px;
    padding: 1.5rem;
}

.about-stat__num {
    display: block;
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary);
}

.about-stat__label {
    display: block;
    margin-top: .5rem;
    color: #666;
    font-size: .95rem;
}

.about-hero__badge {
    margin-top: 1.5rem;
    padding: 1rem 1.25rem;
    background: #f7f7f7;
    border-left: 4px solid var(--primary);
    border-radius: 12px;
    display: flex;
    gap: .75rem;
    align-items: flex-start;
}

/* ==========================
   ORIGEN
========================== */

.about-origen h2,
.about-clientes h2,
.about-valores h2,
.about-cta h2,
.about-compromiso h2 {
    font-size: clamp(2rem, 4vw, 3rem);
    margin-bottom: 1rem;
}

.about-timeline {
    list-style: none;
    padding: 0;
    margin: 4rem 0 0;
    position: relative;
}

.about-timeline::before {
    content: "";
    position: absolute;
    left: 85px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e5e5e5;
}

.about-timeline__item {
    display: grid;
    grid-template-columns: 80px 1fr;
    gap: 2rem;
    margin-bottom: 3rem;
    position: relative;
}

.about-timeline__year {
    font-weight: 800;
    color: var(--primary);
}

.about-timeline__text {
    line-height: 1.8;
    color: #555;
}

.about-timeline__text strong {
    color: #111;
}

/* ==========================
   COMPROMISO
========================== */

.about-compromiso__card {
    background: #111;
    color: white;
    padding: 4rem;
    border-radius: 24px;
}

.about-compromiso__card p {
    color: rgba(255, 255, 255, .8);
    line-height: 1.8;
}

.about-compromiso__badge {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    margin-top: 2rem;
    background: rgba(255, 255, 255, .1);
    padding: .75rem 1rem;
    border-radius: 999px;
    font-size: .9rem;
}

/* ==========================
   CLIENTES
========================== */

.about-clientes__grid {
    list-style: none;
    padding: 0;
    margin: 3rem 0 0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.about-cliente {
    padding: 2rem;
    border: 1px solid #ececec;
    border-radius: 18px;
    transition: .25s ease;
}

.about-cliente:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
}

.about-cliente__nombre {
    display: block;
    font-size: 1.2rem;
    margin-bottom: 1rem;
}

.about-cliente__desc {
    color: #666;
    line-height: 1.7;
}

.about-cliente__tag {
    display: inline-block;
    margin-top: 1rem;
    color: var(--primary);
    font-weight: 600;
}

/* ==========================
   VALORES
========================== */

.about-valores__grid {
    list-style: none;
    padding: 0;
    margin: 3rem 0 0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.about-valor {
    text-align: center;
    padding: 2.5rem;
    border-radius: 20px;
    border: 1px solid #ececec;
}

.about-valor__icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    border-radius: 50%;
    background: rgba(0, 0, 0, .05);
    display: flex;
    align-items: center;
    justify-content: center;
}

.about-valor__icon i {
    font-size: 2rem;
    color: var(--primary);
}

.about-valor h3 {
    margin-bottom: 1rem;
}

.about-valor p {
    color: #666;
    line-height: 1.7;
}

/* ==========================
   CTA
========================== */

.about-cta {
    text-align: center;
    background: #f8f8f8;
    border-radius: 30px;
    padding: 5rem 2rem;
}

.about-cta .btn {
    margin-top: 2rem;
}

.about-cta__address {
    margin-top: 1.5rem;
    color: #777;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
}

/* ==========================
   BUTTONS
========================== */

.btn {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
}

.btn--primary {
    background: var(--primary);
    color: white;
}

.btn--ghost {
    border: 1px solid #ddd;
    color: #111;
}

/* ==========================
   MOBILE
========================== */

@media (max-width: 992px) {

    .about-hero {
        grid-template-columns: 1fr;
    }

    .about-stats {
        grid-template-columns: 1fr 1fr;
    }

    .about-timeline::before {
        display: none;
    }

    .about-timeline__item {
        grid-template-columns: 1fr;
        gap: .5rem;
    }

    .about-compromiso__card {
        padding: 2rem;
    }
}

@media (max-width: 640px) {

    .about-hero,
    .about-origen,
    .about-compromiso,
    .about-clientes,
    .about-valores,
    .about-cta {
        padding: 4rem 0;
    }

    .about-stats {
        grid-template-columns: 1fr;
    }

    .about-hero__title {
        font-size: 2.4rem;
    }

    .about-hero__actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>