 <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --ink: #0d0d0c;
      --paper: #f5f2eb;
      --accent: #c8410a;
      --muted: #6b6860;
      --border: #d6d0c4;
      --white: #ffffff;
    }

    html { scroll-behavior: smooth; }

    body {
      background: var(--paper);
      color: var(--ink);
      font-family: 'DM Sans', sans-serif;
      font-weight: 400;
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* NAV */
    nav {
      position: fixed; top: 0; left: 0; right: 0;
      z-index: 100;
      display: flex; align-items: center; justify-content: space-between;
      padding: 1.25rem 3rem;
      background: var(--paper);
      border-bottom: 1px solid var(--border);
    }
    .nav-logo {
      font-family: 'DM Serif Display', serif;
      font-size: 1.4rem;
      color: var(--ink);
      text-decoration: none;
    }
    .nav-cta {
      background: var(--ink);
      color: var(--paper);
      padding: 0.55rem 1.4rem;
      border-radius: 100px;
      text-decoration: none;
      font-size: 0.875rem;
      font-weight: 500;
      transition: background 0.2s;
    }
    .nav-cta:hover { background: var(--accent); }

    /* HERO */
    .hero {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 8rem 3rem 4rem;
      position: relative;
      overflow: hidden;
    }
    .hero-bg-text {
      position: absolute;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      font-family: 'DM Serif Display', serif;
      font-size: clamp(8rem, 20vw, 18rem);
      color: transparent;
      -webkit-text-stroke: 1px var(--border);
      white-space: nowrap;
      pointer-events: none;
      user-select: none;
      opacity: 0.6;
    }
    .hero-tag {
      font-size: 0.8rem;
      font-weight: 500;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 1.5rem;
    }
    .hero h1 {
      font-family: 'DM Serif Display', serif;
      font-size: clamp(3rem, 7vw, 6rem);
      line-height: 1.05;
      max-width: 14ch;
      margin-bottom: 2rem;
    }
    .hero h1 em {
      font-style: italic;
      color: var(--accent);
    }
    .hero-sub {
      font-size: 1.125rem;
      color: var(--muted);
      max-width: 48ch;
      margin-bottom: 3rem;
    }
    .hero-actions {
      display: flex;
      align-items: center;
      gap: 1.5rem;
      flex-wrap: wrap;
    }
    .btn-primary {
      background: var(--accent);
      color: var(--white);
      padding: 0.9rem 2.2rem;
      border-radius: 100px;
      text-decoration: none;
      font-weight: 500;
      font-size: 1rem;
      transition: transform 0.15s, background 0.2s;
      display: inline-block;
    }
    .btn-primary:hover { transform: translateY(-2px); background: #a33408; }
    .btn-ghost {
      color: var(--ink);
      text-decoration: none;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      border-bottom: 1px solid var(--ink);
      padding-bottom: 2px;
      transition: color 0.2s;
    }
    .btn-ghost:hover { color: var(--accent); border-color: var(--accent); }

    .hero-scroll {
      margin-top: 4rem;
      font-size: 0.78rem;
      color: var(--muted);
      letter-spacing: 0.08em;
      text-transform: uppercase;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .hero-scroll::before {
      content: '';
      display: block;
      width: 2px;
      height: 36px;
      background: var(--border);
    }

    /* STRIP */
    .strip {
      background: var(--ink);
      color: var(--paper);
      padding: 1rem 3rem;
      display: flex;
      gap: 3rem;
      overflow: hidden;
      font-size: 0.85rem;
      font-weight: 300;
      letter-spacing: 0.04em;
    }
    .strip-inner {
      display: flex;
      gap: 3rem;
      animation: marquee 20s linear infinite;
      white-space: nowrap;
    }
    @keyframes marquee {
      0% { transform: translateX(0); }
      100% { transform: translateX(-50%); }
    }
    .strip-dot { color: var(--accent); }

    /* SERVICES */
    .services {
      padding: 6rem 3rem;
    }
    .section-label {
      font-size: 0.78rem;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      color: var(--muted);
      margin-bottom: 3rem;
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    .section-label::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border);
    }
    .services-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 1px;
      border: 1px solid var(--border);
    }
    .service-card {
      background: var(--white);
      padding: 2.5rem 2rem;
      transition: background 0.2s;
    }
    .service-card:hover { background: var(--ink); color: var(--paper); }
    .service-card:hover .service-num { color: var(--accent); }
    .service-card:hover .service-desc { color: #b0ada6; }
    .service-num {
      font-family: 'DM Serif Display', serif;
      font-size: 2.5rem;
      color: var(--border);
      line-height: 1;
      margin-bottom: 1.5rem;
      transition: color 0.2s;
    }
    .service-name {
      font-size: 1.1rem;
      font-weight: 500;
      margin-bottom: 0.75rem;
    }
    .service-desc {
      font-size: 0.9rem;
      color: var(--muted);
      line-height: 1.6;
      transition: color 0.2s;
    }

    /* WHY */
    .why {
      background: var(--ink);
      color: var(--paper);
      padding: 6rem 3rem;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      align-items: center;
    }
    .why h2 {
      font-family: 'DM Serif Display', serif;
      font-size: clamp(2.2rem, 4vw, 3.5rem);
      line-height: 1.15;
      margin-bottom: 2rem;
    }
    .why h2 em { font-style: italic; color: var(--accent); }
    .why p {
      color: #9b9890;
      line-height: 1.8;
      font-size: 1rem;
      margin-bottom: 1.5rem;
    }
    .stats {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
    }
    .stat-num {
      font-family: 'DM Serif Display', serif;
      font-size: 3.5rem;
      color: var(--accent);
      line-height: 1;
    }
    .stat-label {
      font-size: 0.85rem;
      color: #9b9890;
      margin-top: 0.5rem;
    }

    /* PROCESS */
    .process {
      padding: 6rem 3rem;
    }
    .process h2 {
      font-family: 'DM Serif Display', serif;
      font-size: clamp(2rem, 4vw, 3rem);
      margin-bottom: 3rem;
      max-width: 22ch;
    }
    .process-steps {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 2rem;
      counter-reset: steps;
    }
    .step {
      border-top: 2px solid var(--border);
      padding-top: 1.5rem;
      counter-increment: steps;
    }
    .step::before {
      content: '0' counter(steps);
      font-family: 'DM Serif Display', serif;
      font-size: 1.8rem;
      color: var(--accent);
      display: block;
      margin-bottom: 1rem;
    }
    .step h3 { font-size: 1rem; font-weight: 500; margin-bottom: 0.5rem; }
    .step p { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }

    /* CTA */
    .cta-section {
      background: var(--accent);
      color: var(--white);
      padding: 6rem 3rem;
      text-align: center;
    }
    .cta-section h2 {
      font-family: 'DM Serif Display', serif;
      font-size: clamp(2rem, 5vw, 4rem);
      margin-bottom: 1.5rem;
      line-height: 1.1;
    }
    .cta-section p {
      font-size: 1.1rem;
      opacity: 0.85;
      max-width: 50ch;
      margin: 0 auto 2.5rem;
    }
    .btn-white {
      background: var(--white);
      color: var(--accent);
      padding: 1rem 2.5rem;
      border-radius: 100px;
      text-decoration: none;
      font-weight: 500;
      font-size: 1rem;
      display: inline-block;
      transition: transform 0.15s;
    }
    .btn-white:hover { transform: translateY(-2px); }

    /* FOOTER */
    footer {
      background: var(--ink);
      color: #9b9890;
      padding: 2.5rem 3rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 0.85rem;
      flex-wrap: wrap;
      gap: 1rem;
    }
    footer a { color: #9b9890; text-decoration: none; }
    footer a:hover { color: var(--paper); }

    /* ANIMATIONS */
    .fade-up {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.7s, transform 0.7s;
    }
    .fade-up.visible {
      opacity: 1;
      transform: translateY(0);
    }

    @media (max-width: 768px) {
      nav { padding: 1rem 1.5rem; }
      .hero { padding: 7rem 1.5rem 3rem; }
      .services, .process, .cta-section { padding: 4rem 1.5rem; }
      .why { grid-template-columns: 1fr; padding: 4rem 1.5rem; }
      footer { padding: 2rem 1.5rem; flex-direction: column; }
      .strip { display: none; }
    }
  </style>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-text" aria-hidden="true">MARKETING</div>
  <p class="hero-tag">Agencia de Marketing · País Vasco</p>
  <h1>Marketing que mueve <em>negocios</em> de verdad</h1>
  <p class="hero-sub">En Ikusa combinamos estrategia, diseño y tecnología para que tu empresa consiga más clientes, más visibilidad y más ventas.</p>
  <div class="hero-actions">
    <a href="#contacto" class="btn-primary">Solicitar propuesta gratuita</a>
    <a href="#servicios" class="btn-ghost">Ver servicios →</a>
  </div>
  <div class="hero-scroll" aria-hidden="true">Descubrir más</div>
</section>

<!-- MARQUEE STRIP -->
<div class="strip" aria-hidden="true">
  <div class="strip-inner">
    <span>Diseño Web</span><span class="strip-dot">✦</span>
    <span>SEO & Posicionamiento</span><span class="strip-dot">✦</span>
    <span>Marketing Digital</span><span class="strip-dot">✦</span>
    <span>Estrategia de Marca</span><span class="strip-dot">✦</span>
    <span>Email Marketing</span><span class="strip-dot">✦</span>
    <span>Publicidad Online</span><span class="strip-dot">✦</span>
    <span>Diseño Web</span><span class="strip-dot">✦</span>
    <span>SEO & Posicionamiento</span><span class="strip-dot">✦</span>
    <span>Marketing Digital</span><span class="strip-dot">✦</span>
    <span>Estrategia de Marca</span><span class="strip-dot">✦</span>
    <span>Email Marketing</span><span class="strip-dot">✦</span>
    <span>Publicidad Online</span><span class="strip-dot">✦</span>
  </div>
</div>

<!-- SERVICES -->
<section class="services" id="servicios">
  <div class="section-label">Lo que hacemos</div>
  <div class="services-grid">
    <div class="service-card fade-up">
      <div class="service-num">01</div>
      <h2 class="service-name">Diseño Web</h2>
      <p class="service-desc">Webs rápidas, bonitas y que convierten visitas en clientes. Diseño a medida sin plantillas.</p>
    </div>
    <div class="service-card fade-up">
      <div class="service-num">02</div>
      <h2 class="service-name">SEO & Posicionamiento</h2>
      <p class="service-desc">Aparece en Google cuando tus clientes te buscan. Estrategia SEO local y nacional.</p>
    </div>
    <div class="service-card fade-up">
      <div class="service-num">03</div>
      <h2 class="service-name">Marketing de Contenidos</h2>
      <p class="service-desc">Blog, redes sociales y email marketing que generan confianza y atráen clientes recurrentes.</p>
    </div>
    <div class="service-card fade-up">
      <div class="service-num">04</div>
      <h2 class="service-name">Publicidad Online</h2>
      <p class="service-desc">Campañas en Google Ads y Meta que generan resultados medibles desde el primer día.</p>
    </div>
    <div class="service-card fade-up">
      <div class="service-num">05</div>
      <h2 class="service-name">Branding & Identidad</h2>
      <p class="service-desc">Logotipo, paleta de color, tipografía y guía de estilo para que tu marca sea reconocible.</p>
    </div>
    <div class="service-card fade-up">
      <div class="service-num">06</div>
      <h2 class="service-name">Estrategia Digital</h2>
      <p class="service-desc">Analizamos tu negocio y diseñamos un plan de marketing que tiene sentido para tu sector.</p>
    </div>
  </div>
</section>

<!-- WHY -->
<section class="why">
  <div>
    <h2>Una <em>agencia de marketing</em> que habla claro</h2>
    <p>No somos una gran agencia donde serás un número. En Ikusa cada proyecto recibe atención directa de las personas que toman las decisiones.</p>
    <p>Trabajamos con empresas locales, tiendas online y startups que quieren resultados reales, no informes llenos de datos que nadie entiende.</p>
    <a href="#contacto" class="btn-primary">Empieza hoy</a>
  </div>
  <div class="stats">
    <div>
      <div class="stat-num">+10</div>
      <div class="stat-label">Años de experiencia en marketing digital</div>
    </div>
    <div>
      <div class="stat-num">50+</div>
      <div class="stat-label">Proyectos completados en el País Vasco</div>
    </div>
    <div>
      <div class="stat-num">3x</div>
      <div class="stat-label">Media de aumento de tráfico orgánico</div>
    </div>
    <div>
      <div class="stat-num">100%</div>
      <div class="stat-label">Proyectos entregados en plazo</div>
    </div>
  </div>
</section>

<!-- PROCESS -->
<section class="process" id="proceso">
  <div class="section-label">Cómo trabajamos</div>
  <h2>Un proceso claro de principio a fin</h2>
  <div class="process-steps">
    <div class="step fade-up">
      <h3>Diagnóstico</h3>
      <p>Analizamos tu situación actual: competencia, presencia digital, objetivos y presupuesto disponible.</p>
    </div>
    <div class="step fade-up">
      <h3>Estrategia</h3>
      <p>Diseñamos un plan de marketing a medida. Sin soluciones genéricas, sin copiar lo que hace la competencia.</p>
    </div>
    <div class="step fade-up">
      <h3>Ejecución</h3>
      <p>Implementamos la estrategia: web, SEO, contenidos, campañas. Todo coordinado y con plazos claros.</p>
    </div>
    <div class="step fade-up">
      <h3>Mejora continua</h3>
      <p>Medimos resultados cada mes y ajustamos lo que sea necesario. El marketing no es un sprint, es una carrera.</p>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section" id="contacto">
  <h2>¿Hablamos de tu proyecto?</h2>
  <p>Cuéntanos qué necesitas y te preparamos una propuesta gratuita en 48 horas.</p>
  <a href="mailto:hola@ikusa.net" class="btn-white">Contactar ahora</a>
</section>

<script>
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: 0.15 });
  document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));
</script>
