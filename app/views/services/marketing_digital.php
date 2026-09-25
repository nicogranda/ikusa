<?php

$hero = [
    'tag' => 'Marketing Digital',
    'title' => 'Marketing que atrae, convierte y fideliza',
    'description' => 'Diseñamos estrategias digitales orientadas a resultados que aumentan tu visibilidad, generan leads cualificados y hacen crecer tu negocio.',
    'cta_primary' => [
        'label' => 'Cuéntanos tu proyecto',
        'url' => '/es/contacto'
    ],
    'cta_secondary' => [
        'label' => 'Ver resultados',
        'url' => '#portfolio'
    ],
    'image' => '/assets/img/services/marketing_digital/hero.jpg',
    'alt' => 'Marketing digital profesional'
];

$services = [
    [
        'icon' => 'fa-solid fa-magnifying-glass-chart',
        'title' => 'SEO',
        'description' => 'Optimizamos tu web para que aparezca en los primeros resultados de Google y atraiga tráfico orgánico cualificado de forma sostenida.',
    ],
    [
        'icon' => 'fa-brands fa-google',
        'title' => 'SEM / Google Ads',
        'description' => 'Creamos y gestionamos campañas de pago en Google para captar clientes en el momento exacto en que te están buscando.',
    ],
    [
        'icon' => 'fa-solid fa-comments',
        'title' => 'Social Media',
        'description' => 'Gestionamos tus redes sociales con contenido estratégico que construye comunidad, refuerza tu marca y genera engagement real.',
    ],
    [
        'icon' => 'fa-solid fa-envelope-open-text',
        'title' => 'Email Marketing',
        'description' => 'Diseñamos y automatizamos campañas de email que nutren tus contactos, reactivan clientes y aumentan las conversiones.',
    ],
    [
        'icon' => 'fa-solid fa-chart-line',
        'title' => 'Analítica Web',
        'description' => 'Configuramos y analizamos tus métricas para que tomes decisiones basadas en datos reales y optimices continuamente tus resultados.',
    ],
    [
        'icon' => 'fa-solid fa-bullseye',
        'title' => 'Consultoría de Marketing Digital',
        'description' => 'Te ayudamos a definir una estrategia digital coherente con tus objetivos, tu sector y tu presupuesto.',
    ],
];

$process = [
    ['step' => 1, 'title' => 'Auditoría', 'description' => 'Analizamos tu situación actual, tu competencia y tu mercado.'],
    ['step' => 2, 'title' => 'Estrategia', 'description' => 'Definimos los canales, objetivos y KPIs más adecuados para tu negocio.'],
    ['step' => 3, 'title' => 'Ejecución', 'description' => 'Implementamos las acciones con rigor y atención al detalle.'],
    ['step' => 4, 'title' => 'Medición', 'description' => 'Monitorizamos los resultados en tiempo real y ajustamos la estrategia.'],
    ['step' => 5, 'title' => 'Optimización', 'description' => 'Mejoramos continuamente para maximizar el retorno de tu inversión.'],
];

$portfolio = [
    ['image' => '/assets/img/services/marketing_digital/seo.png', 'title' => 'Posicionamiento SEO', 'description' => 'Incremento del tráfico orgánico para empresa de servicios B2B.'],
    ['image' => '/assets/img/services/marketing_digital/sem.jpg', 'title' => 'Campaña Google Ads', 'description' => 'Reducción del coste por lead en un 40% para ecommerce.'],
    ['image' => '/assets/img/services/marketing_digital/social_media.jpg', 'title' => 'Social Media', 'description' => 'Crecimiento de comunidad y engagement para marca lifestyle.'],
];

?>

<main class="marketing-digital-page">

    <!-- HERO -->
    <section class="hero">
        <div class="container">

            <div class="hero__content">
                <span class="hero__tag"><?= $hero['tag'] ?></span>
                <h1><?= $hero['title'] ?></h1>
                <p><?= $hero['description'] ?></p>
                <div class="hero__actions">
                    <a href="<?= $hero['cta_primary']['url'] ?>" class="btn btn-primary">
                        <?= $hero['cta_primary']['label'] ?>
                    </a>
                    <a href="<?= $hero['cta_secondary']['url'] ?>" class="btn btn-secondary">
                        <?= $hero['cta_secondary']['label'] ?>
                    </a>
                </div>
            </div>

            <div class="hero__visual">
                <img src="<?= $hero['image'] ?>" alt="<?= $hero['alt'] ?>">
            </div>

        </div>
    </section>

    <!-- SERVICES -->
    <section class="services">
        <div class="container">

            <div class="services__header">
                <span class="section-tag">Qué hacemos</span>
                <h2>Marketing digital para cada objetivo</h2>
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
            <h2>Un proceso estratégico orientado a resultados</h2>

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
            <h2>Algunos proyectos de marketing</h2>

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
                <h2>¿Listo para hacer crecer tu negocio?</h2>
                <p>Cuéntanos tus objetivos y diseñamos una estrategia digital a tu medida.</p>
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
.marketing-digital-page {
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
</style>