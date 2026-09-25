<?php

$hero = [
    'tag' => 'Diseño Gráfico',
    'title' => 'Diseño que comunica, convence y diferencia',
    'description' => 'Creamos identidades visuales coherentes y materiales gráficos que reflejan la personalidad de tu marca y conectan con tu audiencia.',
    'cta_primary' => [
        'label' => 'Cuéntanos tu proyecto',
        'url' => '/es/contacto'
    ],
    'cta_secondary' => [
        'label' => 'Ver trabajos',
        'url' => '#portfolio'
    ],
    'image' => '/assets/img/services/graphic_design/hero.png',
    'alt' => 'Diseño gráfico profesional'
];

$services = [
    [
        'icon' => 'fa-solid fa-palette',
        'title' => 'Identidad Corporativa',
        'description' => 'Diseñamos tu logo, paleta de colores, tipografías y guía de estilo para que tu marca sea reconocible y coherente en todos los canales.',
    ],
    [
        'icon' => 'fa-solid fa-newspaper',
        'title' => 'Diseño Editorial',
        'description' => 'Folletos, dípticos, trípticos y catálogos con una maquetación profesional que comunica con claridad y elegancia.',
    ],
    [
        'icon' => 'fa-solid fa-hashtag',
        'title' => 'Diseño para Redes Sociales',
        'description' => 'Plantillas, posts y creatividades adaptadas a cada plataforma para mantener una presencia visual consistente y atractiva.',
    ],
    [
        'icon' => 'fa-solid fa-shirt',
        'title' => 'Merchandising',
        'description' => 'Diseñamos para camisetas, tazas, bolsas y cualquier soporte físico que ayude a proyectar tu marca en el mundo real.',
    ],
    [
        'icon' => 'fa-solid fa-box-open',
        'title' => 'Packaging',
        'description' => 'Envases y embalajes con diseño estratégico que destacan en el punto de venta y refuerzan la experiencia de marca.',
    ],
    [
        'icon' => 'fa-solid fa-id-card',
        'title' => 'Tarjetas de Visita',
        'description' => 'Tarjetas con diseño cuidado que generan una primera impresión memorable y transmiten profesionalidad.',
    ],
];

$process = [
    ['step' => 1, 'title' => 'Briefing', 'description' => 'Entendemos tu marca, tu sector y tus objetivos.'],
    ['step' => 2, 'title' => 'Concepto', 'description' => 'Desarrollamos la dirección creativa y las primeras propuestas.'],
    ['step' => 3, 'title' => 'Diseño', 'description' => 'Creamos las piezas con atención al detalle y coherencia visual.'],
    ['step' => 4, 'title' => 'Revisión', 'description' => 'Ajustamos hasta que el resultado sea exactamente el que necesitas.'],
    ['step' => 5, 'title' => 'Entrega', 'description' => 'Archivos listos para imprenta y uso digital en todos los formatos.'],
];

$portfolio = [
    ['image' => '/assets/img/services/graphic_design/branding.jpg','title' => 'Branding corporativo', 'description' => 'Identidad completa para empresa de servicios.'],
    ['image' => '/assets/img/services/graphic_design/editorial_line.jpg', 'title' => 'Diseño editorial', 'description' => 'Diseño y diagramación de comunicaciones corporativas.'],
    ['image' => '/assets/img/services/graphic_design/visual_identity.jpg', 'title' => 'Identidad visual', 'description' => 'Logo y guía de marca para startup tecnológica.'],
    ['image' => '/assets/img/services/graphic_design/merchandising.jpg', 'title' => 'Merchandising', 'description' => 'Colección de materiales promocionales.'],
    ['image' => '/assets/img/services/graphic_design/redes_sociales.jpg', 'title' => 'Redes sociales', 'description' => 'Pack de plantillas para marca lifestyle.'],
    ['image' => '/assets/img/services/graphic_design/packeting.jpg', 'title' => 'Packaging', 'description' => 'Diseño de envase para producto gourmet.'],
];

?>

<main class="graphic-design-page">
    <!-- HERO -->
    <section class="hero">
        <div class="container">
            <div class="hero__content">
                <span class="hero__tag"><?= $hero['tag'] ?></span>
                <h1><?= $hero['title'] ?></h1>
                <p><?= $hero['description'] ?></p>
            </div>
            <div class="hero__visual">
                <img src="<?= $hero['image'] ?>" alt="<?= $hero['alt'] ?>">
            </div>
            <div class="hero__actions">
                <a href="<?= $hero['cta_primary']['url'] ?>" class="btn btn-primary">
                    <?= $hero['cta_primary']['label'] ?>
                </a>
                <a href="<?= $hero['cta_secondary']['url'] ?>" class="btn btn-secondary">
                    <?= $hero['cta_secondary']['label'] ?>
                </a>
            </div>
        </div>
    </section>
    <!-- SERVICES -->
    <section class="services">
        <div class="container">
            <div class="services__header">
                <span class="section-tag">Qué hacemos</span>
                <h2>Diseño gráfico para cada necesidad</h2>
            </div>
            <div class="services__grid">
                <?php foreach ($services as $s): ?>
                    <article class="service-card">
                        <div class="service-card__icon">
                            <i class="<?= $s['icon'] ?>"></i>
                        </div>
                        <h3><?= $s['title'] ?></h3>
                        <p><?= $s['description'] ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- PROCESS -->
    <section class="process">
        <div class="container">
            <span class="section-tag">Cómo trabajamos</span>
            <h2>Un proceso creativo claro y colaborativo</h2>
            <div class="steps">
                <?php foreach ($process as $p): ?>
                    <article class="step">
                        <div class="step__icon"><?= $p['step'] ?></div>
                        <h3><?= $p['title'] ?></h3>
                        <p><?= $p['description'] ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- PORTFOLIO -->
    <section id="portfolio" class="portfolio">
        <div class="container">
            <span class="section-tag">Nuestro trabajo</span>
            <h2>Algunos proyectos de diseño</h2>
            <div class="portfolio-grid">
                <?php foreach ($portfolio as $p): ?>
                    <article class="portfolio-item">
                        <div class="portfolio-item__img">
                            <img src="<?= $p['image'] ?>" alt="<?= $p['title'] ?>">
                        </div>
                        <h3><?= $p['title'] ?></h3>
                        <p><?= $p['description'] ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- CTA -->
    <section class="cta">
        <div class="container">
            <div class="cta__content">
                <h2>¿Tu marca merece un mejor diseño?</h2>
                <p>Cuéntanos tu proyecto y te proponemos una solución visual que funcione.</p>
            </div>
            <div class="cta__actions">
                <a href="/es/contacto" class="btn btn-primary">Solicitar presupuesto</a>
            </div>
        </div>
    </section>
</main>

<style>
/* =========================
   BASE
========================= */
.graphic-design-page {
    font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
    color: #111;
}

.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.section-tag {
    color: #E8332A;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    display: block;
    margin-bottom: 10px;
}

/* =========================
   HERO
========================= */
.hero {
    background: #0A0A0A;
    position: relative;
    overflow: hidden;
}

.hero::before {
    content: '';
    position: absolute;
    right: -120px;
    top: -120px;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(232,51,42,0.18) 0%, transparent 70%);
}

.hero .container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    padding: 120px 20px 100px;
    min-height: 600px;
}

.hero__tag {
    color: #E8332A;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.hero h1 {
    color: #fff;
    font-size: 52px;
    font-weight: 800;
    line-height: 1.05;
    margin: 0;
}

.hero p {
    color: #AAA;
    font-size: 16px;
    line-height: 1.7;
    max-width: 420px;
}

.hero__content {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.hero__actions {
    display: flex;
    gap: 12px;
}

.hero__visual img {
    width: 100%;
    max-width: 560px;
    border-radius: 12px;
}

/* =========================
   BUTTONS
========================= */
.btn {
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    border-radius: 6px;
    padding: 14px 26px;
}

.btn-primary {
    background: #E8332A;
    color: #fff;
}

.btn-primary:hover {
    background: #B5241D;
}

.btn-secondary {
    background: transparent;
    color: #fff;
    border: 1px solid #444;
}

/* =========================
   SERVICES
========================= */
.services {
    padding: 90px 0;
    background: #fff;
}

.services__header {
    margin-bottom: 50px;
}

.services__header h2 {
    font-size: 38px;
    font-weight: 800;
    margin: 0;
    color: #111;
}

.services__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}

.service-card {
    padding: 32px 28px;
    border-radius: 14px;
    border: 1px solid #eee;
    transition: 0.2s;
}

.service-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.07);
}

.service-card__icon {
    width: 48px;
    height: 48px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #FFF0EF;
    border-radius: 10px;
    color: #E8332A;
    font-size: 22px;
}

.service-card h3 {
    font-size: 17px;
    font-weight: 700;
    margin-bottom: 8px;
    color: #111;
}

.service-card p {
    font-size: 14px;
    color: #666;
    line-height: 1.6;
}

/* =========================
   PROCESS
========================= */
.process {
    background: #F5F5F2;
    padding: 90px 0;
    text-align: center;
}

.process h2 {
    font-size: 38px;
    font-weight: 800;
    margin-bottom: 50px;
    color: #111;
}

.steps {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
}

.step {
    background: #fff;
    border-radius: 14px;
    padding: 24px 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    transition: 0.2s;
}

.step:hover {
    transform: translateY(-6px);
}

.step__icon {
    width: 46px;
    height: 46px;
    margin: 0 auto 12px;
    background: #E8332A;
    color: #fff;
    font-weight: 800;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.step h3 {
    font-size: 15px;
    margin-bottom: 6px;
    color: #111;
}

.step p {
    font-size: 13px;
    color: #777;
    line-height: 1.5;
}

/* =========================
   PORTFOLIO
========================= */
.portfolio {
    padding: 90px 0;
    background: #fff;
}

.portfolio h2 {
    font-size: 38px;
    font-weight: 800;
    margin-bottom: 10px;
    color: #111;
}

.portfolio-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-top: 40px;
}

.portfolio-item {
    border-radius: 12px;
    overflow: hidden;
}

.portfolio-item__img {
    overflow: hidden;
    border-radius: 10px;
}

.portfolio-item__img img {
    width: 100%;
    aspect-ratio: 4/3;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.3s ease;
}

.portfolio-item:hover .portfolio-item__img img {
    transform: scale(1.04);
}

.portfolio-item h3 {
    font-size: 15px;
    font-weight: 700;
    margin-top: 12px;
    margin-bottom: 4px;
    color: #111;
}

.portfolio-item p {
    font-size: 13px;
    color: #777;
}

/* =========================
   CTA
========================= */
.cta {
    background: #0A0A0A;
    padding: 90px 0;
}

.cta .container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.cta h2 {
    color: #fff;
    font-size: 42px;
    font-weight: 800;
    line-height: 1.1;
    margin: 0;
}

.cta p {
    color: #aaa;
    margin-top: 10px;
    font-size: 16px;
}

/* =========================
   RESPONSIVE MOBILE
========================= */
@media (max-width: 768px) {

    .hero .container {
        display: flex;
        flex-direction: column;
        padding: 80px 20px 60px;
        gap: 10px;
        min-height: auto;
    }
    
    .hero__visual {
        margin-top: -30px;
    }

    .hero__content { order: 1; }
    .hero__visual  { order: 2; }
    .hero__actions { order: 3; }

    .hero__visual img {
        width: 100%;
        max-width: 100%;
        border-radius: 10px;
    }

    .hero h1 {
        font-size: 34px;
    }

    .hero p {
        font-size: 15px;
    }

    .hero__actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .services__grid {
        grid-template-columns: 1fr;
    }

    .services__header h2,
    .process h2,
    .portfolio h2 {
        font-size: 28px;
    }

    .steps {
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .portfolio-grid {
        grid-template-columns: 1fr;
    }

    .cta .container {
        grid-template-columns: 1fr;
        gap: 30px;
        text-align: center;
    }

    .cta h2 {
        font-size: 30px;
    }
}
</style>