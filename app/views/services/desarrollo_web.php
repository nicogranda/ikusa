<?php

$hero = [
    'tag' => 'Desarrollo Web',
    'title' => 'Desarrollo Web y Aplicaciones a Medida',
    'description' => 'Creamos soluciones digitales potentes, escalables y optimizadas para convertir visitantes en clientes y hacer crecer tu negocio.',
    'cta_primary' => [
        'label' => 'Cuéntanos tu proyecto',
        'url' => '/es/contacto'
    ],
    'cta_secondary' => [
        'label' => 'Ver proyectos',
        'url' => '#portfolio'
    ],
    'image' => '/assets/img/services/web_development.png',
    'alt' => 'Desarrollo web profesional'
];

$benefits = [
    ['title' => 'Sitios Web Corporativos', 'description' => 'Diseñados para transmitir confianza y captar oportunidades.'],
    ['title' => 'Tiendas Online', 'description' => 'Ecommerce preparados para vender y posicionar.'],
    ['title' => 'Aplicaciones Web', 'description' => 'Herramientas personalizadas para optimizar procesos.'],
    ['title' => 'Desarrollo a Medida', 'description' => 'Laravel, React, PHP y arquitecturas escalables.'],
];

$process = [
    ['step' => 1, 'title' => 'Descubrimiento', 'description' => 'Analizamos objetivos y necesidades.'],
    ['step' => 2, 'title' => 'Planificación', 'description' => 'Diseñamos la arquitectura del proyecto.'],
    ['step' => 3, 'title' => 'Desarrollo', 'description' => 'Programación limpia, segura y escalable.'],
    ['step' => 4, 'title' => 'Lanzamiento', 'description' => 'Optimización y puesta en producción.'],
    ['step' => 5, 'title' => 'Crecimiento', 'description' => 'Medición y mejora continua.'],
];

$portfolio = [
    ['image' => '/assets/img/projects/bidmycar.png', 'title' => 'BidMyCar', 'description' => 'Marketplace de subastas.'],
    ['image' => '/assets/img/projects/porlamar.png', 'title' => 'Porlamar', 'description' => 'Catering corporativo.'],
    ['image' => '/assets/img/projects/avalon_estetic.png', 'title' => 'Avalon Estetic', 'description' => 'Clínica estética.'],
    ['image' => '/assets/img/projects/maleta_chic.png', 'title' => 'Maleta Chic', 'description' => 'Ecommerce internacional.'],
    ['image' => '/assets/img/projects/borjas_design.png', 'title' => 'Borjas Design', 'description' => 'Tienda online.'],
];

$stack = [
    '/assets/img/stack/laravel.svg',
    '/assets/img/stack/react.svg',
    '/assets/img/stack/php.svg',
    '/assets/img/stack/mysql.svg',
    '/assets/img/stack/javascript.svg',
];

?>

<main class="web-development-page">

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

    <!-- BENEFITS -->
    <section class="benefits">
        <div class="container">

            <?php foreach ($benefits as $b): ?>
                <div class="benefit">
                    <h3><?= $b['title'] ?></h3>
                    <p><?= $b['description'] ?></p>
                </div>
            <?php endforeach; ?>

        </div>
    </section>

    <!-- PROCESS -->
    <section class="process">

        <div class="container">

            <span class="section-tag">Cómo trabajamos</span>

            <h2>Un proceso claro para resultados reales</h2>

            <div class="steps">

                <?php foreach ($process as $p): ?>
                    <article class="step">

                        <div class="step__icon">
                            <?= $p['step'] ?>
                        </div>

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

            <h2>Algunos casos de éxito</h2>

            <div class="portfolio-grid">

                <?php foreach ($portfolio as $p): ?>
                    <article>
                        <img src="<?= $p['image'] ?>" alt="<?= $p['title'] ?>">
                        <h3><?= $p['title'] ?></h3>
                        <p><?= $p['description'] ?></p>
                    </article>
                <?php endforeach; ?>

            </div>

        </div>

    </section>

    <!-- STACK -->
    <section class="stack">

        <div class="container">

            <h2>Tecnologías que utilizamos</h2>

            <div class="logos">

                <?php foreach ($stack as $s): ?>
                    <img src="<?= $s ?>" alt="tech">
                <?php endforeach; ?>

            </div>

        </div>

    </section>


    <!-- CTA -->
    <section class="cta">

        <div class="container">

            <div class="cta__content">

                <h2>¿Tienes un proyecto en mente?</h2>

                <p>
                    Hablemos de cómo podemos ayudarte a construir
                    una solución digital rentable y escalable.
                </p>

            </div>

            <div class="cta__actions">

                <a href="/es/contacto" class="btn btn-primary">
                    Cuéntanos tu proyecto
                </a>

            </div>

        </div>

    </section>

</main>

<style>
    /* =========================
   BASE
========================= */

.web-development-page {
  font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
  color: #111;
}

.container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
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
  padding: 100px 0;
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
   BENEFITS
========================= */

.benefits {
  padding: 70px 0;
}

.benefits .container {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 28px;
}

.benefit {
  padding: 20px;
  border-radius: 12px;
  background: #fff;
  border: 1px solid #eee;
  transition: 0.2s;
}

.benefit:hover {
  transform: translateY(-4px);
}

.benefit h3 {
  font-size: 16px;
  margin-bottom: 6px;
}

.benefit p {
  font-size: 13px;
  color: #666;
  line-height: 1.5;
}

/* =========================
   PROCESS (MEJORADO)
========================= */

.process {
  background: #F5F5F2;
  padding: 90px 0;
  text-align: center;
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

.process h2 {
  font-size: 38px;
  font-weight: 800;
  margin-bottom: 50px;
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
}

.portfolio h2 {
  font-size: 38px;
  font-weight: 800;
  margin-bottom: 30px;
}

.portfolio-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 18px;
}

.portfolio-grid article {
  border-radius: 12px;
  overflow: hidden;
}

.portfolio-grid img {
  width: 100%;
  aspect-ratio: 4/3;
  object-fit: cover;
  border-radius: 10px;
}

.portfolio-grid h3 {
  font-size: 14px;
  margin-top: 8px;
}

.portfolio-grid p {
  font-size: 12px;
  color: #777;
}

/* =========================
   STACK
========================= */

.stack {
  background: #F5F5F2;
  padding: 80px 0;
}

.stack .container {
  display: grid;
  grid-template-columns: 300px 1fr;
  gap: 60px;
  align-items: center;
}

.stack h2 {
  font-size: 32px;
  font-weight: 800;
}

.logos {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
  align-items: center;
}

.logos img {
  height: 38px;
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
}

.cta p {
  color: #aaa;
  margin-top: 10px;
}
</style>