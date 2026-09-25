<div class="hero">
  <img class="hero__bg" src="https://ikusa.net/assets/img/isis_marcial.jpg" alt="Isis Marcial - Ikusa">
  <div class="hero__overlay"></div>
  <div class="hero__content">
    <p class="hero__eyebrow">
      Más que diseño, resultados
    </p>
    <h2 class="hero__title">
      ¿Por qué elegir <span>Ikusa</span> para tu proyecto web?
    </h2>
    <p class="hero__text">
      Combinamos diseño, tecnología y estrategia para crear webs que atraen, convierten y hacen crecer tu negocio.
    </p>
    <button class="hero__btn"><a href="/es/desarrollo-web">Conoce nuestros diseños</a></button>
  </div>
</div>
<style>
.hero {
  position: relative;
  width: 100%;
  overflow: hidden;
  font-family: var(--font-sans);
  line-height: 0; /* evita espacio fantasma bajo el img */
}
.hero__bg {
  display: block;
  width: 100%;
  height: auto;
}
/* degradado SOLO desde el 50% hacia la derecha */
.hero__overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to right,
    transparent 0%,
    rgba(0,0,0,0.85) 100%
  );
}
/* contenido en la mitad derecha */
.hero__content {
  position: absolute;
  inset: 0;
  z-index: 1;
  margin-left: 50%;
  width: 50%;
  padding: 80px 56px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 20px;
  box-sizing: border-box;
  line-height: normal; /* revertimos el line-height:0 del padre */
}
.hero__eyebrow {
  font-size: 12px;
  font-weight: 500;
  letter-spacing: 0.12em;
  color: #E8621A;
  text-transform: uppercase;
  margin: 0;
}
.hero__title {
  font-size: 36px;
  font-weight: 700;
  color: #fff;
  line-height: 1.2;
  margin: 0;
}
.hero__title span {
  color: #E8621A;
}
.hero__text {
  font-size: 16px;
  color: rgba(255,255,255,0.82);
  line-height: 1.7;
  margin: 0;
}
.hero__btn {
  margin-top: 12px;
  padding: 12px 28px;
  background: #E8621A;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  width: fit-content;
}
.hero__btn a {
  text-decoration: none;
  color: #fff;
}
/* ── Tablet ≤ 900px ───────────────────────────────────────── */
@media (max-width: 900px) {
  .hero__content {
    margin-left: 40%;
    width: 60%;
    padding: 60px 36px;
  }
  .hero__title {
    font-size: 28px;
  }
  .hero__text {
    font-size: 15px;
  }
}
/* ── Mobile ≤ 600px ───────────────────────────────────────── */
@media (max-width: 600px) {
  .hero__overlay {
    background: linear-gradient(
      to top,
      rgba(0,0,0,0.92) 50%,
      rgba(0,0,0,0.30) 100%
    );
  }
  .hero__content {
    margin-left: 0;
    width: 100%;
    height: auto;
    padding: 24px 24px 40px;
    justify-content: flex-end;
    top: auto;
    bottom: 0;
    left: 0;
    gap: 14px;
  }
  .hero__eyebrow {
    font-size: 11px;
  }
  .hero__title {
    font-size: 24px;
  }
  .hero__text {
    font-size: 14px;
  }
  .hero__btn {
    width: 100%;
    text-align: center;
    padding: 14px 20px;
  }
}
</style>