<?php
// app/views/landings/marketing_digital_gipuzkoa.php

$page_data = [

    'hero' => [
        'bg_text'    => 'GIPUZKOA',
        'tag'        => 'Agencia de Marketing Digital · Gipuzkoa',
        'h1'         => 'Marketing digital para empresas en <em>Gipuzkoa</em>',
        'sub'        => 'Diseño web, SEO y estrategia digital para negocios de Gipuzkoa. Resultados medibles, trato directo y sin humo.',
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
        'label' => 'Lo que hacemos en Gipuzkoa',
        'cards' => [
            ['num' => '01', 'name' => 'Diseño Web en Gipuzkoa',   'desc' => 'Webs rápidas, a medida y orientadas a convertir visitas en clientes. Sin plantillas.'],
            ['num' => '02', 'name' => 'SEO en Gipuzkoa',          'desc' => 'Aparece en Google cuando tus clientes buscan lo que ofreces en Gipuzkoa y el País Vasco.'],
            ['num' => '03', 'name' => 'Redes Sociales',           'desc' => 'Gestión de Instagram, LinkedIn y Facebook orientada a captar clientes en Gipuzkoa.'],
            ['num' => '04', 'name' => 'Publicidad Online',        'desc' => 'Campañas en Google Ads y Meta con presupuesto optimizado para el mercado guipuzcoano.'],
            ['num' => '05', 'name' => 'Email Marketing',          'desc' => 'Secuencias y newsletters que convierten suscriptores en clientes recurrentes.'],
            ['num' => '06', 'name' => 'Estrategia Digital',       'desc' => 'Plan de marketing a medida para tu sector y tu mercado en Gipuzkoa.'],
        ],
    ],

    'why' => [
        'h2'       => 'Una agencia en <em>Gipuzkoa</em> que habla claro',
        'p1'       => 'No somos una gran agencia donde serás un número. En Ikusa cada proyecto en Gipuzkoa recibe atención directa de las personas que toman las decisiones.',
        'p2'       => 'Trabajamos con empresas de Gipuzkoa que quieren clientes reales, no informes llenos de datos que nadie entiende.',
        'cta_text' => 'Empieza hoy',
        'cta_href' => '/es/contacto',
        'stats'    => [
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
            ['title' => 'Diagnóstico',     'desc' => 'Analizamos tu situación actual: competencia en Gipuzkoa, presencia digital, objetivos y presupuesto.'],
            ['title' => 'Estrategia',      'desc' => 'Diseñamos un plan a medida para tu negocio en Gipuzkoa. Sin soluciones genéricas.'],
            ['title' => 'Ejecución',       'desc' => 'Implementamos la estrategia: web, SEO, contenidos, campañas. Todo coordinado y con plazos claros.'],
            ['title' => 'Mejora continua', 'desc' => 'Medimos resultados cada mes y ajustamos. El marketing no es un sprint, es una carrera.'],
        ],
    ],

    'cta' => [
        'h2'  => '¿Tu empresa es de Gipuzkoa? Hablemos.',
        'sub' => 'Cuéntanos qué necesitas y te preparamos una propuesta gratuita en 48 horas.',
        'btn' => 'Contactar ahora',
        'href'=> '/es/contacto',
    ],

];

$faqs = [

    [
        'question' => '¿Qué hace una agencia de marketing digital en Gipuzkoa?',
        'answer' => 'Una agencia de marketing digital ayuda a las empresas a captar más clientes mediante estrategias online. En Ikusa trabajamos el diseño web, SEO, Google Ads, redes sociales, automatización y estrategias digitales para aumentar la visibilidad y las ventas de negocios en Gipuzkoa.'
    ],

    [
        'question' => '¿Por qué contratar una agencia de marketing en lugar de hacerlo internamente?',
        'answer' => 'Porque contarás con un equipo especializado en diferentes áreas (SEO, publicidad, diseño web, analítica y automatización) sin asumir los costes de contratar varios perfiles. Además, tendrás acceso a herramientas profesionales y una estrategia enfocada en resultados.'
    ],

    [
        'question' => '¿Trabajáis solo con empresas de Gipuzkoa?',
        'answer' => 'No. Aunque estamos especializados en ayudar a empresas de Gipuzkoa y el País Vasco, trabajamos con negocios de toda España e incluso proyectos internacionales.'
    ],

    [
        'question' => '¿Qué servicios ofrece vuestra agencia de marketing?',
        'answer' => '<ul>
            <li>Diseño y desarrollo web</li>
            <li>Posicionamiento SEO</li>
            <li>Google Ads (SEM)</li>
            <li>Gestión de redes sociales</li>
            <li>Marketing de contenidos</li>
            <li>Email Marketing</li>
            <li>Automatización con IA</li>
            <li>Analítica y optimización de conversiones</li>
        </ul>'
    ],

    [
        'question' => '¿Cuánto cuesta contratar una agencia de marketing?',
        'answer' => 'Depende de los objetivos del proyecto, el nivel de competencia y los servicios necesarios. Tras una reunión inicial elaboramos un presupuesto personalizado, adaptado a las necesidades de cada empresa.'
    ],

    [
        'question' => '¿Cuánto tiempo tardan en verse resultados?',
        'answer' => '<strong>SEO:</strong> normalmente entre 3 y 6 meses para obtener resultados sólidos.<br>
        <strong>Google Ads:</strong> los resultados pueden empezar desde los primeros días.<br>
        <strong>Redes sociales:</strong> el crecimiento suele ser progresivo y requiere continuidad.'
    ],

    [
        'question' => '¿Podéis ayudar a una empresa que ya tiene página web?',
        'answer' => 'Sí. Podemos optimizar una web existente, mejorar su velocidad, el SEO, la experiencia de usuario y la tasa de conversión, sin necesidad de crear una nueva si no es necesario.'
    ],

    [
        'question' => '¿Trabajáis con pequeñas empresas y autónomos?',
        'answer' => 'Sí. Trabajamos con pymes, comercios, empresas industriales, despachos profesionales, clínicas, restaurantes y autónomos que quieren aumentar su presencia digital y generar más oportunidades de negocio.'
    ],

    [
        'question' => '¿Qué diferencia a Ikusa de otras agencias de marketing en Gipuzkoa?',
        'answer' => 'Nuestra filosofía está basada en tres pilares: estrategias personalizadas, orientación a resultados y generación de negocio, y una comunicación cercana y transparente. No buscamos únicamente aumentar visitas, sino convertirlas en clientes.'
    ],

    [
        'question' => '¿También gestionáis campañas de Google Ads?',
        'answer' => 'Sí. Creamos, optimizamos y analizamos campañas de Google Ads para captar clientes potenciales desde el primer día, maximizando el retorno de la inversión.'
    ],

    [
        'question' => '¿El SEO sigue siendo rentable?',
        'answer' => 'Sí. El SEO continúa siendo una de las estrategias con mejor retorno a medio y largo plazo porque genera tráfico cualificado sin depender exclusivamente de la publicidad de pago. Además, una buena estrategia SEO mejora la autoridad de la marca y reduce el coste de adquisición de clientes con el tiempo.'
    ],

    [
        'question' => '¿Realizáis auditorías de marketing digital?',
        'answer' => 'Sí. Analizamos tu web, posicionamiento, competencia, campañas publicitarias y presencia online para detectar oportunidades de mejora y definir una estrategia clara.'
    ],

    [
        'question' => '¿Cómo empezamos a trabajar juntos?',
        'answer' => '<ol>
            <li>Analizamos tu negocio y tus objetivos.</li>
            <li>Realizamos una auditoría inicial.</li>
            <li>Diseñamos una estrategia personalizada.</li>
            <li>Ejecutamos las acciones acordadas.</li>
            <li>Medimos resultados y optimizamos continuamente.</li>
        </ol>'
    ],

    [
        'question' => '¿Ofrecéis informes de resultados?',
        'answer' => 'Sí. Enviamos informes periódicos donde podrás conocer la evolución del SEO, campañas publicitarias, tráfico web, conversiones y las acciones realizadas para que siempre tengas una visión clara del rendimiento.'
    ],

    [
        'question' => '¿Cómo puedo solicitar un presupuesto?',
        'answer' => 'Solo tienes que contactar con nosotros mediante el formulario web, teléfono o correo electrónico. Estudiaremos tu proyecto sin compromiso y te prepararemos una propuesta adaptada a tus objetivos.'
    ],

    // FAQs SEO
    [
        'question' => '¿Cuál es la mejor agencia de marketing en Gipuzkoa?',
        'answer' => 'La mejor agencia será aquella que entienda tu negocio, defina una estrategia personalizada y pueda demostrar resultados. En Ikusa trabajamos con un enfoque orientado a negocio, priorizando el retorno de la inversión y el crecimiento sostenible.'
    ],

    [
        'question' => '¿Qué agencia de marketing trabaja con empresas industriales en Gipuzkoa?',
        'answer' => 'En Ikusa colaboramos con empresas industriales, pymes y negocios B2B desarrollando estrategias de SEO, publicidad online y automatización para generar oportunidades comerciales.'
    ],

    [
        'question' => '¿Cómo elegir una agencia de marketing digital?',
        'answer' => 'Es recomendable valorar su experiencia, casos de éxito, transparencia, metodología de trabajo y capacidad para medir resultados. Una buena agencia debe convertirse en un socio estratégico para tu empresa.'
    ],

    [
        'question' => '¿Es mejor SEO o Google Ads para mi empresa?',
        'answer' => 'Depende de tus objetivos. Google Ads permite obtener resultados inmediatos, mientras que el SEO genera tráfico estable y rentable a largo plazo. En muchos casos, la mejor estrategia consiste en combinar ambos canales.'
    ],

    [
        'question' => '¿Cómo conseguir más clientes en Gipuzkoa gracias al marketing digital?',
        'answer' => 'Mediante una estrategia que combine una web optimizada, posicionamiento SEO, campañas de Google Ads, contenidos de calidad y una correcta medición de resultados para convertir visitantes en clientes.'
    ]

];

?>
<link rel="stylesheet" href="/assets/css/landings.css">

<?php $h     = $page_data['hero'];    include __DIR__ . '/components/hero.php'; ?>
<?php $items = $page_data['strip'];   include __DIR__ . '/components/strip.php'; ?>
<?php $sv    = $page_data['services']; include __DIR__ . '/components/services.php'; ?>
<?php $w     = $page_data['why'];     include __DIR__ . '/components/why.php'; ?>
<?php $pr    = $page_data['process']; include __DIR__ . '/components/process.php'; ?>
 <?php include __DIR__ . "/../components/FAQ.php";  ?>
<?php $c     = $page_data['cta'];     include __DIR__ . '/components/cta.php'; ?>

<script>
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.15 });
    document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));
</script>
