<?php
$page_data = [

    'hero' => [
        'bg_text'    => 'IRÚN',
        'tag'        => 'Agencia de Marketing Digital · Irún',
        'h1'         => 'Marketing digital para empresas en <em>Irún</em>',
        'sub'        => 'Diseño web, SEO y estrategia digital para negocios de Irún y Gipuzkoa. Resultados medibles, trato directo y sin humo.',
        'cta_text'   => 'Solicitar presupuesto gratuito',
        'cta_href'   => '/es/contacto',
        'ghost_text' => 'Ver servicios',
        'ghost_href' => '#servicios',
    ],

    'strip' => [
        'Diseño Web', 'SEO & Posicionamiento', 'Marketing Digital',
        'Estrategia de Marca', 'Email Marketing', 'Publicidad Online',
    ],

    'services' => [
        'label' => 'Lo que hacemos en Irún',
        'cards' => [
            ['num' => '01', 'name' => 'Diseño Web en Irún',    'desc' => 'Webs rápidas, a medida y orientadas a convertir visitas en clientes. Sin plantillas.'],
            ['num' => '02', 'name' => 'SEO en Irún',           'desc' => 'Aparece en Google cuando tus clientes buscan lo que ofreces en Irún y Gipuzkoa.'],
            ['num' => '03', 'name' => 'Redes Sociales',        'desc' => 'Gestión de Instagram, LinkedIn y Facebook orientada a captar clientes locales.'],
            ['num' => '04', 'name' => 'Publicidad Online',     'desc' => 'Campañas en Google Ads y Meta con presupuesto optimizado para el mercado local.'],
            ['num' => '05', 'name' => 'Email Marketing',       'desc' => 'Secuencias y newsletters que convierten suscriptores en clientes recurrentes.'],
            ['num' => '06', 'name' => 'Estrategia Digital',    'desc' => 'Plan de marketing a medida para tu sector y tu mercado en el País Vasco.'],
        ],
    ],

    'why' => [
        'h2'      => 'Una agencia en <em>Irún</em> que habla claro',
        'p1'      => 'No somos una gran agencia donde serás un número. En Ikusa cada proyecto en Irún recibe atención directa de las personas que toman las decisiones.',
        'p2'      => 'Trabajamos con empresas locales de Irún y Gipuzkoa que quieren clientes reales, no informes llenos de datos que nadie entiende.',
        'cta_text'=> 'Empieza hoy',
        'cta_href'=> '/es/contacto',
        'stats'   => [
            ['num' => '+10', 'label' => 'Años de experiencia en marketing digital'],
            ['num' => '50+', 'label' => 'Proyectos completados en el País Vasco'],
            ['num' => '3x',  'label' => 'Media de aumento de tráfico orgánico'],
            ['num' => '100%','label' => 'Proyectos entregados en plazo'],
        ],
    ],

    'process' => [
        'label' => 'Cómo trabajamos',
        'h2'    => 'Un proceso claro de principio a fin',
        'steps' => [
            ['title' => 'Diagnóstico',     'desc' => 'Analizamos tu situación actual: competencia local en Irún, presencia digital, objetivos y presupuesto.'],
            ['title' => 'Estrategia',      'desc' => 'Diseñamos un plan a medida para tu negocio en Irún. Sin soluciones genéricas.'],
            ['title' => 'Ejecución',       'desc' => 'Implementamos la estrategia: web, SEO, contenidos, campañas. Todo coordinado y con plazos claros.'],
            ['title' => 'Mejora continua', 'desc' => 'Medimos resultados cada mes y ajustamos. El marketing no es un sprint, es una carrera.'],
        ],
    ],

    'cta' => [
        'h2'  => '¿Tu empresa es de Irún? Hablemos.',
        'sub' => 'Cuéntanos qué necesitas y te preparamos una propuesta gratuita en 48 horas.',
        'btn' => 'Contactar ahora',
        'href'=> '/es/contacto',
    ],

];
?>
<link rel="stylesheet" href="/assets/css/landings.css">

<?php $h  = $page_data['hero'];    include __DIR__ . '/components/hero.php'; ?>
<?php $items = $page_data['strip']; include __DIR__ . '/components/strip.php'; ?>
<section class="irun-contexto">
    <div class="irun-contexto__wrap">
        <p class="irun-contexto__label">SOBRE IRÚN</p>
        <h2 class="irun-contexto__titulo">Marketing digital para empresas de Irún</h2>
        <p class="irun-contexto__texto">
            Irún tiene un tejido empresarial poco habitual para su tamaño: es frontera
            con Francia, nudo logístico del corredor Bidasoa, con polígonos industriales
            consolidados a la vez que un centro comercial y de hostelería activo tanto
            para el vecino como para el cliente de paso franco-vasco. Trabajar el
            marketing digital de un negocio aquí no es lo mismo que hacerlo en una
            ciudad sin esa mezcla de industria, comercio transfronterizo y actividad
            local diaria.
        </p>
        <p class="irun-contexto__texto">
            Trabajamos con cualquier empresa legalmente constituida en Irún o su área
            de influencia, sea cual sea su sector: comercio, hostelería, servicios
            profesionales, industria o negocio online. No partimos de una plantilla de
            "SEO local" pensada para otra ciudad — el plan se adapta a si tu cliente te
            busca en Google diez veces al día o si tu venta se decide una vez al año,
            a si compites solo en Irún o también con el lado francés de la frontera, y
            a qué presupuesto tiene sentido para tu tamaño de negocio.
        </p>
        <p class="irun-contexto__texto">
            Diagnóstico gratuito, sin permanencia obligada y sin informes que nadie lee:
            lo que importa es si aparece tu negocio cuando alguien en Irún busca lo que
            ofreces.
        </p>
    </div>
</section>

<style>
    .irun-contexto { padding: 4rem 0; }
.irun-contexto__wrap { max-width: 720px; margin: 0 auto; padding: 0 1.5rem; }
.irun-contexto__label { font-size: 12px; letter-spacing: 0.08em; text-transform: uppercase; color: #d9541f; margin-bottom: 12px; }
.irun-contexto__titulo { font-family: var(--font-heading, serif); font-size: 28px; font-weight: 500; margin-bottom: 20px; }
.irun-contexto__texto { font-size: 16px; line-height: 1.7; color: #55534e; margin-bottom: 16px; }
</style>
<?php $sv = $page_data['services']; include __DIR__ . '/components/services.php'; ?>
<?php $w  = $page_data['why'];     include __DIR__ . '/components/why.php'; ?>
<?php $pr = $page_data['process']; include __DIR__ . '/components/process.php'; ?>
<?php $c  = $page_data['cta'];     include __DIR__ . '/components/cta.php'; ?>

<?php
$clientes = [
    ['nombre' => 'Avalón Estetic',      'archivo' => 'avalon_estetic.png'],
    ['nombre' => 'BB Specialty Coffee', 'archivo' => 'bbkafe.png'],
    ['nombre' => 'Porlamar',            'archivo' => 'porlamar.png'],
    ['nombre' => 'Petit Café',          'archivo' => 'petit_cafe.png'],
];
$rutaLogos = dirname(__DIR__, 3) . '/public_html/assets/img/clients/';
?>
<section class="clientes-confian">
    <p class="clientes-confian__label">Confían en nosotros</p>
    <div class="clientes-confian__grid">
        <?php foreach ($clientes as $c): ?>
            <?php $existeLogo = file_exists($rutaLogos . $c['archivo']); ?>
            <div class="clientes-confian__item">
                <?php if ($existeLogo): ?>
                    <img src="/assets/img/clients/<?php echo $c['archivo']; ?>"
                         alt="Logo de <?php echo $c['nombre']; ?>"
                         loading="lazy">
                <?php else: ?>
                    <span class="clientes-confian__nombre"><?php echo $c['nombre']; ?></span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<style>
    .clientes-confian { text-align: center; padding: 2rem 0; margin: 0 auto; width: 60%; }
.clientes-confian__label { font-size: 13px; opacity: 0.6; margin-bottom: 12px; }
.clientes-confian__grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px; }
.clientes-confian__item { background: rgba(255,255,255,0.05); border-radius: 12px; padding: 1rem; display: flex; align-items: center; justify-content: center; min-height: 60px; }
.clientes-confian__item img { max-height: 150px; max-width: 100%; filter: grayscale(100%); opacity: 0.85; }
.clientes-confian__item img:hover { filter: none; opacity: 1; }
.clientes-confian__nombre { font-weight: 500; font-size: 14px; }
</style>
<script>
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.15 });
    document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));
</script>
