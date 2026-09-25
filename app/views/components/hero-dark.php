<?php
/**
 * Component: hero-dark.php
 * Hero oscuro con cards — CSS Grid puro
 */
?>
<section class="hero-dark">
  <div class="hero-dark-container">

    <div class="hero-eyebrow">
      <span class="hero-eyebrow-line"></span>
      <span class="hero-eyebrow-text">RECONVERSIÓN DE TIENDAS ONLINE</span>
    </div>

    <div class="hero-top">
      <h1 class="hero-title">¿Tu tienda online no vende lo que debería?</h1>
      <div class="hero-cta-block">
        <a href="#contacto" class="hero-cta">Diagnóstico gratuito de tu tienda</a>
        <a href="#reconversion" class="hero-link">Ver cómo funciona la reconversión</a>
      </div>
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

  </div>
</section>

<style>
.hero-dark {
  --hero-brand: var(--color-brand, #F15A24);
  background: #0B0F19;
  padding: 6rem 0 4rem;
}
.hero-dark-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

.hero-eyebrow { display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem; }
.hero-eyebrow-line { width: 24px; height: 1px; background: var(--hero-brand); }
.hero-eyebrow-text {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-size: 0.75rem; letter-spacing: 0.15em; color: var(--hero-brand);
}

.hero-top {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 2rem;
  flex-wrap: wrap;
  margin-bottom: 1.5rem;
}
.hero-title {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-weight: 700;
  font-size: clamp(1.9rem, 4vw, 3rem);
  color: #fff;
  line-height: 1.15;
  margin: 0;
  flex: 1 1 500px;
  max-width: 700px;
}
.hero-cta-block { text-align: right; flex: 0 0 auto; }
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
  white-space: nowrap;
}
.hero-cta:hover { filter: brightness(0.9); color: #fff; }
.hero-link {
  display: block;
  margin-top: 0.75rem;
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-size: 0.95rem;
  color: rgba(255,255,255,0.7);
  text-decoration: underline;
}
.hero-link:hover { color: #fff; }

.hero-text {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-size: 1.1rem;
  color: rgba(255,255,255,0.55);
  max-width: 780px;
  margin: 0 0 3rem;
}
.hero-text strong { color: rgba(255,255,255,0.85); font-weight: 600; }

.hero-cards {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1rem;
}
@media (max-width: 992px) {
  .hero-cards { grid-template-columns: repeat(2, 1fr); }
  .hero-cta-block { text-align: left; }
}
@media (max-width: 560px) {
  .hero-cards { grid-template-columns: 1fr; }
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
</style>