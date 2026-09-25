<?php
/**
 * Component: hero-dark.php
 * Hero oscuro con cards + tarjeta "proceso activo" flotando encima
 * Sustituye a hero-dark.php + process-status.php como componentes separados
 */
?>
<section class="hero-dark">
  <div class="hero-dark-container">

    <div class="hero-eyebrow">
      <span class="hero-eyebrow-line"></span>
      <span class="hero-eyebrow-text">RECONVERSIÓN DE TIENDAS ONLINE</span>
    </div>

    <div class="hero-top">
      <h2 class="hero-title">¿Tu tienda online no vende lo que debería?</h2>
    </div>

    <p class="hero-text">
      La reconvertimos: <strong>auditoría → rediseño que vende → SEO → visibilidad en Google y en ChatGPT.</strong>
      De web antigua que no convierte a tienda que capta clientes, con medición real de cada venta.
    </p>

    <div class="hero-cards">
      <div class="hero-dark-card">
        <h3 class="hero-dark-card-title">Auditoría SEO</h3>
        <p class="hero-dark-card-text">El diagnóstico: 53 módulos. Qué frena tus ventas y por qué.</p>
      </div>
      <div class="hero-dark-card">
        <h3 class="hero-dark-card-title">Consultor SEO</h3>
        <p class="hero-dark-card-text">Estrategia para posicionar tu tienda y que convierta.</p>
      </div>
      <div class="hero-dark-card">
        <h3 class="hero-dark-card-title">Rediseño que vende</h3>
        <p class="hero-dark-card-text">Una tienda pensada para vender, no solo para verse bien.</p>
      </div>
      <div class="hero-dark-card">
        <h3 class="hero-dark-card-title">Reconversión completa</h3>
        <p class="hero-dark-card-text">Todo junto, medido: de web antigua a máquina de captar.</p>
      </div>
    </div>

    <!-- Tarjeta flotante -->
    <div class="process-card">
      <div class="process-status">
        <span class="process-dot"></span>
        <span class="process-status-text">PROCESO ACTIVO</span>
      </div>

      <h3 class="process-title">Tu proyecto en marcha</h3>
      <p class="process-subtitle">Cada fase verificada antes de avanzar</p>

      <ul class="process-steps">
        <li class="process-step"><span class="process-check"><i class="fa-solid fa-check"></i></span><span>Análisis inicial completado</span></li>
        <li class="process-step"><span class="process-check"><i class="fa-solid fa-check"></i></span><span>Diseño aprobado por cliente</span></li>
        <li class="process-step"><span class="process-check"><i class="fa-solid fa-check"></i></span><span>Desarrollo y testing</span></li>
        <li class="process-step"><span class="process-check"><i class="fa-solid fa-check"></i></span><span>Lanzamiento y optimización</span></li>
        <li class="process-step"><span class="process-check"><i class="fa-solid fa-check"></i></span><span>Seguimiento mensual</span></li>
      </ul>

      <div class="process-bar"></div>
    </div>

    <div class="hero-cta-block">
      <a href="#contacto" class="hero-cta">Diagnóstico gratuito de tu tienda</a>
      <a href="#reconversion" class="hero-link">Ver cómo funciona la reconversión</a>
    </div>

  </div>
</section>

<style>
.hero-dark {
  --hero-brand: var(--color-brand, #F15A24);
  background: #0B0F19;
  padding: 6rem 0 4rem;
  position: relative;
  overflow: hidden;
}
.hero-dark-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  position: relative;
}

.hero-eyebrow { display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem; }
.hero-eyebrow-line { width: 24px; height: 1px; background: var(--hero-brand); }
.hero-eyebrow-text {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-size: 0.75rem; letter-spacing: 0.15em; color: var(--hero-brand);
}

.hero-title {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-weight: 700;
  font-size: clamp(1.9rem, 4vw, 3rem);
  color: #fff;
  line-height: 1.15;
  margin: 0 0 1.5rem;
  max-width: 650px; /* deja hueco a la derecha para la tarjeta flotante */
}

.hero-text {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-size: 1.1rem;
  color: rgba(255,255,255,0.55);
  max-width: 650px;
  margin: 0 0 3rem;
}
.hero-text strong { color: rgba(255,255,255,0.85); font-weight: 600; }

.hero-cards {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
  max-width: 650px; /* dos columnas, deja libre la derecha */
  margin-bottom: 2rem;
}

.hero-dark-card {
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 14px;
  padding: 1.5rem;
}
.hero-dark-card-title {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-weight: 600;
  font-size: 1.1rem;
  color: #fff;
  margin: 0 0 0.5rem;
}
.hero-dark-card-text {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-size: 0.9rem;
  color: rgba(255,255,255,0.5);
  margin: 0;
}

/* ── Tarjeta flotante ── */
.process-card {
  position: absolute;
  top: 0;
  right: 20px;
  width: 380px;
  background: #12172a;
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 20px;
  padding: 2rem 2.25rem 1.5rem;
  box-shadow: 0 20px 40px rgba(0,0,0,0.35);
}
.process-status { display: flex; align-items: center; gap: 8px; margin-bottom: 1rem; }
.process-status-text {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-size: 0.7rem;
  letter-spacing: 0.12em;
  color: rgba(255,255,255,0.5);
}
.process-dot {
  width: 8px; height: 8px; border-radius: 50%;
  background: var(--hero-brand);
  box-shadow: 0 0 0 4px rgba(241,90,36,0.15);
}
.process-title {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-weight: 600;
  font-size: 1.55rem;
  color: #fff;
  margin: 0 0 0.25rem;
}
.process-subtitle {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-size: 0.9rem;
  color: rgba(255,255,255,0.55);
  margin: 0 0 1.5rem;
}
.process-steps { list-style: none; margin: 0; padding: 0; }
.process-step {
  display: flex; align-items: center; gap: 0.9rem;
  padding: 0.55rem 0;
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-size: 0.95rem;
  color: #fff;
}
.process-check {
  flex: 0 0 26px; width: 26px; height: 26px; border-radius: 50%;
  background: rgba(255,255,255,0.08);
  display: flex; align-items: center; justify-content: center;
}
.process-check i { font-size: 0.7rem; color: var(--hero-brand); }
.process-bar {
  height: 3px; width: 100%;
  background: var(--hero-brand);
  margin-top: 1.25rem;
  border-radius: 999px;
  opacity: 0.9;
}

.hero-cta-block { margin-top: 1rem; }
.hero-cta {
  display: inline-block;
  background: var(--hero-brand);
  color: #fff;
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-weight: 600;
  font-size: 1.05rem;
  padding: 1rem 2rem;
  border-radius: 999px;
  text-decoration: none;
}
.hero-cta:hover { filter: brightness(0.9); color: #fff; }
.hero-link {
  display: inline-block;
  margin-left: 1.25rem;
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-size: 0.95rem;
  color: rgba(255,255,255,0.7);
  text-decoration: underline;
}
.hero-link:hover { color: #fff; }

/* En móvil/tablet la tarjeta absoluta rompe todo: la volvemos estática */
@media (max-width: 992px) {
  .process-card {
    position: static;
    width: 100%;
    margin-bottom: 2rem;
  }
  .hero-title, .hero-text, .hero-cards { max-width: 100%; }
  .hero-cards { grid-template-columns: 1fr; }
}
</style>