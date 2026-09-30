<?php
// Vista específica: un único main y H1, sin componentes ajenos al servicio.
$h = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$url = static fn (string $path): string => function_exists('route_url') ? route_url($path) : '/' . $path;
$css = function_exists('asset_url') ? asset_url('css/industrial-marketing.css') : '/assets/css/industrial-marketing.css';
$gears = function_exists('asset_url') ? asset_url('img/services/industrial-marketing/industrial-gears.svg') : '/assets/img/services/industrial-marketing/industrial-gears.svg';
$services = [
    ['01', 'Estrategia de marketing B2B', 'Definimos a qué empresas dirigirte, qué problemas resuelves y qué argumentos necesita cada decisor. Priorizamos mercados, productos y canales.', 'Cliente ideal · Propuesta de valor · Plan de acción'],
    ['02', 'SEO industrial', 'Organizamos tu presencia en Google alrededor de productos, procesos y aplicaciones. Trabajamos búsquedas técnicas con intención de encontrar un proveedor.', 'Arquitectura web · SEO técnico · Contenido especializado'],
    ['03', 'Webs y catálogos técnicos', 'Convertimos tu web en una herramienta comercial: fichas claras, documentación accesible y solicitudes de presupuesto con la información necesaria.', 'Diseño web · Fichas de producto · Formularios B2B'],
    ['04', 'Contenido que explica tu capacidad', 'Damos forma a tus conocimientos con páginas de aplicación, casos documentados y materiales que ayudan a comparar soluciones y tomar decisiones.', 'Casos de aplicación · Catálogos · Dossiers comerciales'],
    ['05', 'Campañas de captación', 'Planteamos campañas en buscadores y LinkedIn según tu público y presupuesto. Cada acción lleva a una página coherente con el producto y la necesidad.', 'Google Ads · LinkedIn · Landing pages'],
    ['06', 'Medición y mejora comercial', 'Conectamos consultas y objetivos de negocio para saber qué acciones atraen contactos relevantes. Revisamos el encaje de los leads con tu equipo.', 'Analítica · Calidad del contacto · Seguimiento'],
];
$steps = [
    ['Entender', 'Revisamos tu oferta, tu web y cómo compra tu cliente. Identificamos prioridades junto a tu equipo técnico y comercial.'],
    ['Construir', 'Ordenamos mensajes, catálogo y páginas. Preparamos los contenidos y los puntos de contacto para cada necesidad.'],
    ['Activar', 'Ponemos en marcha los canales acordados, con un recorrido claro desde la búsqueda hasta la solicitud.'],
    ['Mejorar', 'Analizamos consultas, calidad y evolución. Ajustamos contenidos y campañas según los datos y el feedback comercial.'],
];
?>
<link rel="stylesheet" href="<?= $h($css) ?>">
<main class="industrial-page">
    <div class="im-first-screen">
    <section class="im-hero" aria-labelledby="im-title">
        <div class="im-container im-hero-grid">
            <div>
                <p class="im-eyebrow">Ikusa / Marketing industrial B2B</p>
                <h1 id="im-title"><?= $h($content['h1']) ?></h1>
                <p class="im-lead"><?= $h($content['excerpt']) ?></p>
                <div class="im-actions">
                    <a class="im-button" href="<?= $h($url('es/contacto')) ?>">Hablemos de tu empresa <span aria-hidden="true">↗</span></a>
                    <a class="im-text-link" href="#im-services">Explora los servicios ↓</a>
                </div>
                <p class="im-hero-note">Desde Gipuzkoa, para empresas industriales de toda España.</p>
            </div>
            <aside class="im-blueprint" aria-label="Del conocimiento técnico a la oportunidad comercial">
                <div class="im-blueprint-top"><span>CAPACIDAD → OPORTUNIDAD</span><img class="im-gears" src="<?= $h($gears) ?>" alt="" width="72" height="60" aria-hidden="true"></div>
                <p class="im-blueprint-title">Tu conocimiento.<br>Su próxima solución.</p>
                <ol class="im-flow">
                    <li><span>01 / VISIBILIDAD</span><strong>Te encuentran</strong><p>Por el producto o proceso que necesitan.</p></li>
                    <li><span>02 / CONFIANZA</span><strong>Entienden tu valor</strong><p>Información técnica que facilita la decisión.</p></li>
                    <li><span>03 / CONTACTO</span><strong>Inician una conversación</strong><p>Una consulta con contexto para tu equipo.</p></li>
                </ol>
                <p class="im-blueprint-bottom">SEO + WEB + CONTENIDO + CAPTACIÓN</p>
            </aside>
        </div>
    </section>
    <div class="im-strip"><div class="im-container"><span>Fabricantes</span><span>Ingenierías</span><span>Proveedores industriales</span><span>Empresas de manufactura</span></div></div>
    </div>
    <section class="im-section im-container im-intro" aria-labelledby="im-challenge">
        <div><p class="im-eyebrow">El reto industrial</p><h2 id="im-challenge">Una buena solución necesita una buena forma de llegar al mercado.</h2></div>
        <div><p>El marketing industrial conecta empresas que ofrecen soluciones técnicas con empresas que las necesitan. La compra suele requerir comparaciones, documentación y la aprobación de varios responsables.</p><p>Por eso tu presencia digital debe responder a las preguntas de ingeniería, compras y dirección: qué haces, para qué aplicaciones, con qué capacidades y cómo empezar a trabajar contigo.</p><p class="im-callout">Convertimos esa información en una experiencia clara, desde la primera búsqueda hasta la solicitud de presupuesto.</p></div>
    </section>
    <section class="im-section im-services" id="im-services" aria-labelledby="im-services-title">
        <div class="im-container"><p class="im-eyebrow">Qué podemos hacer por tu empresa</p><h2 id="im-services-title">Marketing industrial con todas las piezas conectadas.</h2><p class="im-section-lead">Un plan según tu punto de partida. Priorizamos las acciones que necesita tu negocio y construimos sobre ellas.</p>
            <div class="im-service-grid">
                <?php foreach ($services as [$number, $title, $description, $details]): ?>
                <article class="im-card"><span class="im-number"><?= $h($number) ?></span><h3><?= $h($title) ?></h3><p><?= $h($description) ?></p><p class="im-card-details"><?= $h($details) ?></p></article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section class="im-section im-container" aria-labelledby="im-buyers">
        <div class="im-intro"><div><p class="im-eyebrow">Cada decisor necesita una respuesta</p><h2 id="im-buyers">Habla el idioma de quien te va a comprar.</h2></div><p class="im-section-lead">Trabajamos con tu equipo para comunicar información técnica precisa. Tú conoces el producto; nosotros ordenamos el mensaje y el recorrido digital.</p></div>
        <div class="im-buyer-grid">
            <article><span class="im-label">Ingeniería</span><h3>¿Resuelve nuestra necesidad?</h3><p>Especificaciones, materiales, tolerancias, compatibilidades y ejemplos de aplicación.</p></article>
            <article><span class="im-label">Compras</span><h3>¿Podemos contar con vosotros?</h3><p>Capacidad de suministro, documentación y un canal ágil para consultar condiciones y plazos.</p></article>
            <article><span class="im-label">Dirección</span><h3>¿Es una decisión sólida?</h3><p>Una propuesta de valor clara, experiencia documentada y argumentos para valorar la inversión.</p></article>
        </div>
    </section>
    <section class="im-section im-process" aria-labelledby="im-process-title"><div class="im-container"><p class="im-eyebrow">Cómo trabajamos</p><h2 id="im-process-title">De conocer tu industria a activar tu captación.</h2><ol class="im-step-grid">
        <?php foreach ($steps as $i => [$title, $description]): ?><li><span class="im-number">0<?= $i + 1 ?></span><h3><?= $h($title) ?></h3><p><?= $h($description) ?></p></li><?php endforeach; ?>
    </ol></div></section>
    <section class="im-section im-container im-intro" aria-labelledby="im-results"><div><p class="im-eyebrow">Qué medimos</p><h2 id="im-results">Más claridad sobre lo que genera oportunidades.</h2><p class="im-section-lead">Acordamos los indicadores antes de comenzar y revisamos su evolución con tu equipo comercial.</p></div><div class="im-measures"><article><h3>Visibilidad relevante</h3><p>Búsquedas y visitas relacionadas con tus productos, aplicaciones y mercados objetivo.</p></article><article><h3>Consultas con contexto</h3><p>Solicitudes que incluyen una necesidad concreta y datos útiles para preparar una respuesta.</p></article><article><h3>Avance comercial</h3><p>Contactos cualificados, presupuestos y evolución de las oportunidades cuando disponemos de esos datos.</p></article></div></section>
    <section class="im-section im-faq" aria-labelledby="im-faq-title"><div class="im-container im-intro"><div><p class="im-eyebrow">Antes de empezar</p><h2 id="im-faq-title">Preguntas sobre marketing industrial.</h2></div><div>
        <?php foreach ($content['faqs'] as $faq): ?><details><summary><?= $h($faq['question']) ?></summary><p><?= $h($faq['answer']) ?></p></details><?php endforeach; ?>
    </div></div></section>
    <section class="im-section im-container"><div class="im-cta"><p class="im-eyebrow">El siguiente paso</p><h2>Tu capacidad industrial merece ser vista.</h2><p>Cuéntanos qué fabricas, a quién quieres llegar y qué necesitas mejorar. Empezamos por entender tu negocio y definir el siguiente paso.</p><a class="im-button" href="<?= $h($url('es/contacto')) ?>">Cuéntanos tu proyecto <span aria-hidden="true">↗</span></a></div></section>
</main>
