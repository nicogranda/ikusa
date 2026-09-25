<?php
/**
 * Component: trust.php
 * Sin dependencias de Bootstrap/lucide — CSS puro + Font Awesome
 */
?>
<section class="trust-section">
  <div class="trust-container">

    <div class="trust-eyebrow">
      <span class="trust-eyebrow-line"></span>
      <span class="trust-eyebrow-text">CONFIANZA</span>
    </div>

    <h2 class="trust-title">Tu tranquilidad no es negociable.</h2>

    <div class="trust-badges">
      <span class="trust-badge">RGPD</span>
      <span class="trust-badge">SSL</span>
      <span class="trust-badge">HTTPS</span>
      <span class="trust-badge">Backups</span>
      <span class="trust-badge">24/7</span>
    </div>

    <div class="trust-list">

      <div class="trust-item">
        <div class="trust-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <div>
          <h3 class="trust-item-title">Datos protegidos</h3>
          <p class="trust-item-text">Cumplimos estrictamente con el RGPD. Tus datos están seguros y encriptados.</p>
        </div>
      </div>

      <div class="trust-item">
        <div class="trust-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <div>
          <h3 class="trust-item-title">Backups automáticos</h3>
          <p class="trust-item-text">Copias de seguridad diarias automatizadas con restauración en el mismo día laborable.</p>
        </div>
      </div>

      <div class="trust-item">
        <div class="trust-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <div>
          <h3 class="trust-item-title">Monitorización continua</h3>
          <p class="trust-item-text">Vigilamos tu web con alertas continuas (Modular DS) para detectar y resolver incidencias en días laborables.</p>
        </div>
      </div>

      <div class="trust-item trust-item-last">
        <div class="trust-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <div>
          <h3 class="trust-item-title">Transparencia total</h3>
          <p class="trust-item-text">Acceso completo a métricas, informes y decisiones. Sin letra pequeña.</p>
        </div>
      </div>

    </div>

  </div>
</section>

<style>
.trust-section {
  background: #fff;
  padding: 5rem 0;
}
.trust-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 20px;
}
.trust-eyebrow {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 1rem;
}
.trust-eyebrow-line {
  width: 24px;
  height: 1px;
  background: #c4c4c4;
}
.trust-eyebrow-text {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-size: 0.75rem;
  letter-spacing: 0.15em;
  color: #9a9a9a;
}
.trust-title {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-weight: 600;
  font-size: clamp(1.9rem, 4vw, 2.8rem);
  color: #0B0F19;
  line-height: 1.15;
  max-width: 700px;
  margin: 0 0 2rem;
}
.trust-badges {
  display: flex;
  flex-wrap: wrap;
  gap: 0.6rem;
  margin-bottom: 3rem;
}
.trust-badge {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-size: 0.9rem;
  color: #333;
  border: 1px solid #e2e2e2;
  border-radius: 999px;
  padding: 0.5rem 1.25rem;
  background: #fff;
}
.trust-list {
  border-top: 1px solid #eee;
}
.trust-item {
  display: flex;
  align-items: flex-start;
  gap: 1.5rem;
  padding: 1.75rem 0;
  border-bottom: 1px solid #eee;
}
.trust-icon {
  flex: 0 0 48px;
  width: 48px;
  height: 48px;
  border-radius: 10px;
  background: color-mix(in srgb, var(--color-brand, #F15A24) 12%, #fff);
  display: flex;
  align-items: center;
  justify-content: center;
}
.trust-icon i {
  font-size: 1.15rem;
  color: var(--color-brand, #F15A24);
}
.trust-item-title {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-weight: 600;
  font-size: 1.35rem;
  color: #0B0F19;
  margin: 0 0 0.3rem;
}
.trust-item-text {
  font-family: var(--font-primary, 'Montserrat', sans-serif);
  font-size: 1rem;
  color: #6b7280;
  max-width: 720px;
  margin: 0;
}
@media (max-width: 600px) {
  .trust-title { font-size: 1.9rem; }
  .trust-item { gap: 1rem; }
}
</style>