<?php

/**
 * =========================================================
 * SEO LANDING - IRUN
 * MVC + DDD
 * Ready to include
 * =========================================================
 */


$heroData = [
    'title' => 'Posicionamiento Web y SEO en',
    'highlight' => 'Irún',
    'description' => 'Cuando alguien en Irún busca en Google el servicio que tú ofreces, ¿aparece tu negocio? Si la respuesta es no, o si apareces en la página 3 o después, estás perdiendo clientes cada día frente a la competencia. En Ikusa somos agencia y consultor SEO con sede en Irún, Gipuzkoa, y llevamos más de 25 años trabajando para que las marcas de nuestros clientes sean visibles donde importa.',
    'image' => '/assets/img/heros/seo-irun.jpeg',


    'buttons' => [
        [
            'label' => 'Quiero aparecer en Google',
            'url' => 'es/contacto',
            'style' => 'primary',
            'icon' => 'arrow'
        ],
        [
            'label' => 'Hablemos de tu proyecto',
            'url' => 'es/contacto',
            'style' => 'outline',
            'icon' => 'chat'
        ]
    ],

    'trustBar' => [
        [
            'icon' => 'calendar',
            'text' => '+25 años de experiencia'
        ],
        [
            'icon' => 'location',
            'text' => 'Sede en Irún, Gipuzkoa'
        ],
        [
            'icon' => 'shield',
            'text' => 'Un cliente por sector'
        ],
        [
            'icon' => 'chart',
            'text' => 'Resultados medibles'
        ]
    ]
];

$title       = $heroData['title'];
$highlight   = $heroData['highlight'];
$description = $heroData['description'];
$image       = $heroData['image'];
$buttons     = $heroData['buttons'];



// Array de sectores con icono (Font Awesome), etiqueta y slug
$sectores = [
    [
        'icono' => 'fa-solid fa-utensils',
        'label' => 'Restaurantes',
        'slug'  => 'restaurantes',
    ],
    [
        'icono' => 'fa-solid fa-kit-medical',
        'label' => 'Clínicas',
        'slug'  => 'clinicas',
    ],
    [
        'icono' => 'fa-solid fa-scale-balanced',
        'label' => 'Abogados',
        'slug'  => 'abogados',
    ],
    [
        'icono' => 'fa-solid fa-cart-shopping',
        'label' => 'Tiendas Online',
        'slug'  => 'tiendas-online',
    ],
    [
        'icono' => 'fa-solid fa-wrench',
        'label' => 'Reformas',
        'slug'  => 'reformas',
    ],
    [
        'icono' => 'fa-solid fa-truck-ramp-box',
        'label' => 'Logística y Transporte',
        'slug'  => 'logistica-transporte',
    ],
    [
        'icono' => 'fa-solid fa-industry',
        'label' => 'Industria',
        'slug'  => 'industria',
    ],
    [
        'icono' => 'fa-solid fa-store',
        'label' => 'Servicios Locales',
        'slug'  => 'servicios-locales',
    ],
];

// Resultados

$seoResults = [
    'badge' => 'Resultados reales',
    'title' => 'Así crece tu negocio con una estrategia SEO efectiva',
    'description' => 'Datos reales de un proyecto gestionado por Ikusa. Más visibilidad, más clics y mejores posiciones en Google.',

    'image' => '/assets/img/landings/google-search-console-results.png',

    'stats' => [
        [
            'value' => '+1,04 mil',
            'title' => 'Clics orgánicos',
            'text'  => 'Más visitas cualificadas desde Google.',
            'icon'  => 'fa-solid fa-arrow-pointer'
        ],
        [
            'value' => '+154 mil',
            'title' => 'Impresiones',
            'text'  => 'Tu negocio aparece cada vez más en Google.',
            'icon'  => 'fa-solid fa-eye'
        ],
        [
            'value' => '0,7%',
            'title' => 'CTR medio',
            'text'  => 'Mayor interés de los usuarios.',
            'icon'  => 'fa-solid fa-chart-line'
        ],
        [
            'value' => '9,5',
            'title' => 'Posición media',
            'text'  => 'Más palabras clave en primera página.',
            'icon'  => 'fa-solid fa-trophy'
        ]
    ]
];



$successCases = [

    [
        "company" => "Porlamar",
        "sector" => "Servicio de Catering",
        "title" => "Más visibilidad para un servicio de catering",
        "description" => "Desarrollamos una estrategia de posicionamiento local orientada a captar eventos corporativos, bodas y celebraciones, optimizando la presencia en Google y mejorando la visibilidad para búsquedas relacionadas con catering.",
        "image" => "/assets/img/cases/porlamar.jpeg",
        "url" => "https://porlamar.eu"
    ],

    [
        "company" => "Petit Café",
        "sector" => "Cafetería",
        "title" => "SEO Local para una cafetería",
        "description" => "Optimizamos la presencia digital de Petit Café mediante SEO local, contenidos orientados a búsquedas de proximidad y mejoras técnicas para aumentar la visibilidad en Google Maps y atraer nuevos clientes.",
        "image" => "/assets/img/cases/petit-cafe.jpeg",
        "url" => "https://petitcafe.es"
    ],

    [
        "company" => "Avalón Estetic",
        "sector" => "Clínica Estética",
        "title" => "Posicionamiento para clínica estética",
        "description" => "Trabajamos la estrategia SEO de la clínica optimizando los servicios, el contenido y el posicionamiento local para mejorar la captación de pacientes desde Google.",
        "image" => "/assets/img/cases/avalon-estetic.webp",
        "url" => "https://avalonestetic.com"
    ]

];


/**
 * FAQ Component
 */

$faqs = [

    [
        "question" => "¿Cuánto tarda el SEO en Irún?",
        "answer" => "El SEO es una estrategia a medio y largo plazo. Normalmente los primeros resultados comienzan a apreciarse entre los 3 y 6 meses, aunque depende del estado inicial de la web, la competencia del sector y la autoridad del dominio. Al ser un mercado con menor competencia que Donostia o Bilbao, en Irún es habitual ver avances más rápidos."
    ],

    [
        "question" => "¿Por qué contratar una agencia SEO en Irún?",
        "answer" => "Una agencia SEO local conoce el mercado de Gipuzkoa y la Comarca del Bidasoa, la competencia y el comportamiento de búsqueda de los usuarios. Esto permite diseñar estrategias específicas para mejorar la visibilidad de empresas que quieren captar clientes en Irún, Hondarribia y alrededores."
    ],

    [
        "question" => "¿Qué incluye un servicio de posicionamiento SEO?",
        "answer" => "Nuestro servicio incluye auditoría SEO, investigación de palabras clave, optimización técnica, mejora del contenido, SEO local, optimización de Google Business Profile, enlazado interno, seguimiento de posiciones e informes periódicos."
    ],

    [
        "question" => "¿Es importante el SEO local en Irún?",
        "answer" => "Sí. Si tu empresa presta servicios en Irún o la Comarca del Bidasoa, el SEO local es fundamental para aparecer en Google Maps y en búsquedas como 'cerca de mí' o 'agencia SEO Irún'."
    ],

    [
        "question" => "¿Qué diferencia hay entre SEO y Google Ads?",
        "answer" => "Google Ads genera tráfico inmediato mientras exista inversión publicitaria. El SEO construye una presencia orgánica estable que puede seguir generando visitas y clientes durante años sin pagar por cada clic."
    ],

    [
        "question" => "¿Se puede posicionar una web nueva rápidamente?",
        "answer" => "Una web nueva puede empezar a indexarse en pocas semanas, pero alcanzar posiciones competitivas suele requerir varios meses de trabajo constante en contenido, optimización técnica y autoridad."
    ],

    [
        "question" => "¿Trabajáis SEO para empresas de la Comarca del Bidasoa?",
        "answer" => "Sí. Trabajamos con empresas de Irún, Hondarribia, Donostia, Errenteria y otras localidades de Gipuzkoa, adaptando cada estrategia al mercado local."
    ],

    [
        "question" => "¿Realizáis auditorías SEO?",
        "answer" => "Sí. Analizamos aspectos técnicos como indexación, velocidad, Core Web Vitals, arquitectura web, contenido duplicado, enlazado interno, experiencia de usuario y oportunidades de mejora para definir una estrategia priorizada."
    ],

    [
        "question" => "¿Qué es el SEO técnico?",
        "answer" => "El SEO técnico consiste en optimizar la estructura interna de la web para facilitar el rastreo e indexación por parte de Google. Incluye velocidad de carga, Core Web Vitals, sitemap, robots.txt, URLs, etiquetas canónicas y otros factores técnicos."
    ],

    [
        "question" => "¿Qué es Google Business Profile y por qué es importante?",
        "answer" => "Google Business Profile permite mostrar tu empresa en Google Maps y en los resultados locales. Una ficha bien optimizada mejora la visibilidad, aumenta las llamadas, las visitas y la confianza de los usuarios."
    ],

    [
        "question" => "¿Trabajáis posicionamiento en euskera y francés?",
        "answer" => "Sí. Al estar en la frontera con Francia, en Irún es habitual captar también búsquedas en francés además de castellano y euskera. Podemos optimizar contenidos en los tres idiomas según el perfil de cliente que quieras captar."
    ],

    [
        "question" => "¿Cómo elegís las palabras clave?",
        "answer" => "Analizamos el volumen de búsqueda, la competencia, la intención del usuario y las oportunidades de negocio para seleccionar las palabras clave con mayor potencial de conversión."
    ],

    [
        "question" => "¿El SEO sirve para cualquier tipo de empresa?",
        "answer" => "Sí. Trabajamos estrategias SEO para clínicas, restaurantes, abogados, comercios, empresas de logística e industria, despachos profesionales, hoteles, ecommerce y negocios de servicios."
    ],

    [
        "question" => "¿Cuánto cuesta una estrategia SEO?",
        "answer" => "El presupuesto depende del tamaño del proyecto, la competencia y los objetivos. Tras una auditoría inicial elaboramos una propuesta adaptada a las necesidades de cada empresa."
    ],

    [
        "question" => "¿Qué pasa si dejo de hacer SEO?",
        "answer" => "Las mejoras realizadas seguirán aportando valor, pero la competencia continuará optimizando sus páginas. Sin un mantenimiento periódico es habitual perder posiciones con el paso del tiempo."
    ],

    [
        "question" => "¿Cómo medís los resultados del SEO?",
        "answer" => "Realizamos un seguimiento de posiciones, tráfico orgánico, conversiones, visibilidad, rendimiento técnico y evolución de las palabras clave mediante herramientas profesionales."
    ],

    [
        "question" => "¿También optimizáis tiendas online?",
        "answer" => "Sí. Desarrollamos estrategias SEO específicas para ecommerce, optimizando categorías, fichas de producto, arquitectura web, filtros, velocidad de carga y experiencia de compra."
    ],

    [
        "question" => "¿Necesito cambiar mi página web para hacer SEO?",
        "answer" => "No siempre. Muchas mejoras pueden aplicarse sobre la web existente, aunque en algunos casos recomendamos optimizar la estructura, el contenido o el rendimiento para obtener mejores resultados."
    ],

    [
        "question" => "¿Ofrecéis informes periódicos?",
        "answer" => "Sí. Facilitamos informes donde mostramos la evolución del posicionamiento, el tráfico orgánico, las acciones realizadas y las siguientes mejoras planificadas."
    ],

    [
        "question" => "¿Por qué elegir Ikusa como agencia SEO en Irún?",
        "answer" => "Porque tenemos nuestra sede en Irún y desarrollamos estrategias personalizadas basadas en datos reales, optimización técnica, contenido de calidad y SEO local. Nuestro objetivo no es solo aumentar visitas, sino conseguir que esas visitas se conviertan en oportunidades de negocio."
    ]

];

if (!isset($faqs) || !is_array($faqs) || empty($faqs)) {
    return;
}


?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Inicio",
      "item": "https://ikusa.net/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "SEO Irún",
      "item": "https://ikusa.net/es/seo-irun"
    }
  ]
}
</script>

<?php include __DIR__.'/../components/hero.php';?>

<div class="container">
    <?php include __DIR__ . '/../components/feature_blocks.php'; ?>
</div>

<nav class="seo-toc">
  <div class="container">

    <a href="#seo-local">
      <i class="fa-solid fa-square"></i> SEO Local
    </a>

    <a href="#servicios">
      <i class="fa-solid fa-square"></i> Servicios
    </a>

    <a href="#sectores">
      <i class="fa-solid fa-square"></i> Sectores
    </a>

    <a href="#faq">
      <i class="fa-solid fa-square"></i> FAQ
    </a>

    <a href="#contacto">
      <i class="fa-solid fa-square"></i> Contacto
    </a>

  </div>
</nav>

<section id="seo-local" class="seo-section">

    <div class="container">

        <h2>
            Posicionamiento SEO local en Irún
        </h2>

        <p>
            Cuando alguien busca en <strong>Google</strong> un servicio en Irún,
            tu negocio debería aparecer antes que tu competencia.
            Si no estás en la primera página, estás perdiendo clientes cada día.
        </p>

        <p>
            En Ikusa trabajamos estrategias SEO enfocadas en búsquedas locales,
            Google Maps y tráfico con intención real de compra.
        </p>

    </div>

</section>

<section  class="seo-section">
    <div class="container">

    <h2>
        ¿Por qué el SEO en Irún es diferente?
    </h2>
    <p>
        Posicionarse en Irún tiene particularidades que una agencia genérica no contempla. Al ser una ciudad frontera con Francia y parte de la Comarca del Bidasoa junto a Hondarribia, el mercado local funciona de forma distinta al de otras ciudades de Gipuzkoa, y eso se nota directamente en cómo hay que trabajar el SEO.
        El idioma importa más de lo que parece. En Irún conviven búsquedas en castellano, euskera y francés, especialmente por el flujo de clientes del País Vasco francés. Si tu web solo está optimizada en castellano, estás ignorando un volumen real de clientes potenciales al otro lado de la frontera.
        Google Maps pesa mucho aquí. Para la mayoría de negocios físicos en Irún, aparecer en el mapa local es más valioso que aparecer en los resultados orgánicos genéricos. La competencia por el pack de 3 resultados de Google Maps requiere una estrategia específica de SEO local que va más allá del posicionamiento web tradicional.
        El tejido empresarial también es distinto. Irún tiene un peso industrial y logístico importante por su ubicación fronteriza, además de comercio y servicios en el centro y Hondarribia Kalea. Las búsquedas con intención local varían mucho según el sector, y una estrategia SEO bien hecha lo tiene en cuenta.
        Por eso en Ikusa no aplicamos plantillas. Cada estrategia parte del análisis real del mercado local de Irún y la Comarca del Bidasoa.
    </p>
    </div>
</section>

<section id="servicios" class="seo-section seo-gray">
  <div class="container">

    <h2 class="principal">
      ¿Qué hacemos para posicionarte en Google?
    </h2>

    <div class="seo-grid">

      <article class="seo-card">
    <h3>Auditoría SEO en Irún</h3>
    <p>
      Antes de posicionar tu negocio en Irún, hay que saber qué frena tu web.
          Analizamos la estructura técnica, los errores de indexación,
          la velocidad de carga, los contenidos duplicados y cómo te
          ve Google realmente. Con ese diagnóstico, sabemos exactamente
          dónde atacar para que cada acción tenga impacto real en tu
          posición, sin perder tiempo en lo que no mueve el ranking.
        </p>
      </article>

      <article class="seo-card">
        <h3>SEO Local</h3>
        <p>
          Posicionarse en Irún no es lo mismo que posicionarse
          en Madrid. La cercanía con Francia, la competencia con
          Hondarribia y el peso de Google Maps hacen que la estrategia
          local sea diferente. Optimizamos tu ficha de Google Business
          Profile, trabajamos las búsquedas en castellano, euskera y
          francés, y construimos autoridad local para que aparezcas
          cuando alguien en la Comarca del Bidasoa busca exactamente
          lo que tú ofreces.
        </p>
      </article>

      <article class="seo-card">
        <h3>SEO Técnico</h3>
        <p>
          Una web lenta o mal estructurada no posiciona, da igual
          lo bueno que sea el contenido. Mejoramos la velocidad de carga,
          el rastreo de bots, la arquitectura de URLs, los datos
          estructurados (schema), los errores de indexación y la
          compatibilidad móvil. Todo lo que Google evalúa por debajo
          de la superficie y que determina si tu web sube o se queda
          estancada en página 5.
        </p>
      </article>

      <article class="seo-card">
        <h3>Contenido SEO</h3>
        <p>
          El contenido que posiciona no es el que suena bien,
          es el que responde exactamente lo que tu cliente está
          buscando en Google. Creamos páginas de servicio, landings
          locales y textos optimizados orientados a búsquedas con
          intención comercial real: personas que ya quieren contratar,
          no solo informarse. Cada texto está pensado para convertir
          visita en consulta.
        </p>
      </article>

    </div>
  </div>
</section>
  <?php include __DIR__ . '/../components/sectores.php'; ?>

<section  class="seo-section">
    <div class="container">

    <h2> Posicionamiento Web en Irún para empresas que quieren vender más</h2>
    <div class="container">
</section>

<?php include __DIR__ . '/../components/seo_results.php';?>

<section class="seo-cta">

    <div class="container">

      <h2 style="font-weight:700; font-size:24px; line-height:1.5;">
            Descubre por qué no apareces en Google
        </h2>

        <p>
            Analizamos tu web y te mostramos los errores SEO
            que están haciendo que pierdas clientes.
        </p>

        <a href="#contacto" class="btn-primary">
            Quiero que analicéis mi web
        </a>

    </div>

</section>


<?php include __DIR__ . "/components/comparison.php"; ?>

<?php include __DIR__ . "/components/success-cases.php";?>

<section id="faq" class="seo-section seo-gray">

    <div class="container">
        <?php include __DIR__ . "/../components/FAQ.php";  ?>
    </div>

</section>

<section id="contacto" class="seo-contact">
    <?php   include __DIR__ . "/../components/form.php";?>
</section>

<style>
    .seo-section {
    padding: 80px 0;
}

.seo-gray {
    background: #f6f7f9;
}

.seo-section .container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Título principal */
.seo-section .principal {
    font-size: 32px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 50px;
    color: #111;
    letter-spacing: -0.5px;
}

/* Grid */
.seo-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 24px;
}

/* Card */
.seo-card {
    background: #fff;
    border: 1px solid #e9e9e9;
    border-radius: 14px;
    padding: 26px;
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
}

/* Hover suave */
.seo-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    border-color: var(--color-primary);
}

/* Línea superior decorativa */
.seo-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    height: 3px;
    width: 100%;
    background: linear-gradient(90deg, var(--color-primary), white);
}

/* Título card */
.seo-card h3 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #111;
}

/* Texto */
.seo-card p {
    font-size: 15px;
    line-height: 1.6;
    color: #555;
    margin: 0;
}

.seo-toc {
  width: 100%;
  border-bottom: 1px solid rgba(0,0,0,0.08);
  padding: 10px 0;
}

.seo-toc .container {
  display: flex;
  align-items: center;
  gap: 18px;
  flex-wrap: wrap;
}

.seo-toc a {
  display: flex;
  align-items: center;
  gap: 8px;

  text-decoration: none;
  color: #333;
  font-weight: 500;
  font-size: 14px;

  transition: color 0.2s ease;
}

.seo-toc a:hover {
  color: var(--color-primary);
}

.seo-toc i.fa-square {
  color: var(--color-primary);
  font-size: 8px; /* hace que funcione como bullet */
}

.seo-cta .container .btn-primary {
    margin: 20px 0;
}
/* Responsive */
@media (max-width: 768px) {
    .seo-grid {
        grid-template-columns: 1fr;
    }

    .seo-section .principal {
        font-size: 26px;
    }
}

.seo-section {
    padding: 80px 0;
}

.seo-section .container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Título */
.seo-section h2 {
    font-size: 30px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 40px;
    color: #111;
    letter-spacing: -0.5px;
}

/* Grid de tags */
.seo-tags {
    display: flex;
   
    justify-content: center;
    gap: 12px;
}

/* Tag / chip */
.seo-tags span {
    display: inline-flex;
    align-items: center;
    padding: 10px 16px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 500;
    color: var(--color-primary);
    background: rgba( var(--color-primary-rgb), 0.08 );
    border: 1px solid rgba( var(--color-primary-rgb), 0.25 );
    transition: all 0.2s ease;
    cursor: default;
    user-select: none;
}

/* Hover */
.seo-tags span:hover {
    background: var(--color-primary);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
}

/* Responsive */
@media (max-width: 768px) {
    .seo-section h2 {
        font-size: 24px;
    }

    .seo-tags span {
        font-size: 13px;
        padding: 9px 14px;
    }
}

</style>

