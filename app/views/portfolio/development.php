<!-- HTML snippet for multilingual development page -->
<div class="container">
    <button id="langSwitch" class="lang-btn" aria-label="Switch language">
        <span class="lang-text">Español</span>
    </button>

    <div id="content">
        <!-- English content by default -->
        <h1 class="Principal">Full Stack Web Development | CRM, ERP & E-Commerce Solutions</h1>
        <p>At Ikusa, I combine over 15 years of experience in <strong>frontend and backend development</strong> to deliver scalable and efficient web solutions. From building <strong>custom CRM and ERP systems</strong> to <strong>dynamic online stores</strong>, I specialize in creating software that drives business growth and improves user experience.</p>
    
        <h2>Frontend Development</h2>
        <ul>
          <li>Modern, responsive interfaces with <strong>React, Vue, HTML5, CSS3, and JavaScript (ES6+)</strong></li>
          <li>Focus on usability, accessibility, and performance</li>
        </ul>
    
        <h2>Backend Development</h2>
        <ul>
          <li>Robust <strong>PHP & Laravel applications</strong></li>
          <li>REST & SOAP API integrations</li>
          <li>Database design and optimization (MySQL & NoSQL)</li>
        </ul>
    
        <h2>CRM & ERP Solutions</h2>
        <ul>
          <li>Custom platforms to manage sales, inventory, and operations</li>
          <li>Automation of business processes and reporting</li>
        </ul>
    
        <h2>E-Commerce Development</h2>
        <ul>
          <li>Fully functional online stores with secure payment gateways</li>
          <li>Product management, promotions, and analytics integration</li>
        </ul>
    
        <p>Looking for a developer who can take your project from concept to launch? <strong>Let’s build something great together.</strong></p>
    </div>
</div>
<style>
    .lang-btn {
  --primary: #111827;
  --accent: #4f46e5;
  --hover: #3730a3;
  --text: #fff;

  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.6em 1.4em;
  margin-bottom: 1.5em;
  border: none;
  border-radius: 9999px;
  background: var(--accent);
  color: var(--text);
  font-family: 'Inter', system-ui, sans-serif;
  font-size: 0.95rem;
  font-weight: 500;
  cursor: pointer;
  overflow: hidden;
  transition: background 0.3s ease, transform 0.2s ease;
}

.lang-btn:hover {
  background: var(--hover);
  transform: translateY(-2px);
}

.lang-btn:active {
  transform: translateY(0);
}

.lang-btn::before {
  content: "";
  position: absolute;
  inset: 0;
  background: radial-gradient(circle at center, rgba(255,255,255,0.3), transparent 70%);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.lang-btn:hover::before {
  opacity: 1;
}

.lang-btn .lang-text {
  position: relative;
  z-index: 1;
  letter-spacing: 0.3px;
}

</style>

<script>
const contentDiv = document.getElementById('content');
const langSwitchBtn = document.getElementById('langSwitch');
const langText = langSwitchBtn.querySelector('.lang-text');

const englishContent = contentDiv.innerHTML;
const spanishContent = `
<h1 class="Principal">Desarrollo Web Full Stack | Soluciones CRM, ERP y Tiendas Online</h1>
<p>En Ikusa, combino más de 15 años de experiencia en <strong>desarrollo frontend y backend</strong> para ofrecer soluciones web escalables y eficientes. Desde construir <strong>sistemas CRM y ERP personalizados</strong> hasta <strong>tiendas online dinámicas</strong>, me especializo en crear software que impulsa el crecimiento del negocio y mejora la experiencia del usuario.</p>

<h2>Desarrollo Frontend</h2>
<ul>
  <li>Interfaces modernas y responsivas con <strong>React, Vue, HTML5, CSS3 y JavaScript (ES6+)</strong></li>
  <li>Enfoque en usabilidad, accesibilidad y rendimiento</li>
</ul>

<h2>Desarrollo Backend</h2>
<ul>
  <li>Aplicaciones robustas en <strong>PHP & Laravel</strong></li>
  <li>Integración de APIs REST & SOAP</li>
  <li>Diseño y optimización de bases de datos (MySQL & NoSQL)</li>
</ul>

<h2>Soluciones CRM & ERP</h2>
<ul>
  <li>Plataformas personalizadas para gestionar ventas, inventario y operaciones</li>
  <li>Automatización de procesos de negocio y generación de reportes</li>
</ul>

<h2>Desarrollo de Tiendas Online</h2>
<ul>
  <li>Tiendas online totalmente funcionales con pasarelas de pago seguras</li>
  <li>Gestión de productos, promociones e integración de analytics</li>
</ul>

<p>¿Buscas un desarrollador que pueda llevar tu proyecto desde la idea hasta el lanzamiento? <strong>Construyamos algo grandioso juntos.</strong></p>
`;

let currentLang = 'en';
langSwitchBtn.addEventListener('click', () => {
  if (currentLang === 'en') {
    contentDiv.innerHTML = spanishContent;
    langText.textContent = 'English';
    currentLang = 'es';
  } else {
    contentDiv.innerHTML = englishContent;
    langText.textContent = 'Español';
    currentLang = 'en';
  }
});
</script>
