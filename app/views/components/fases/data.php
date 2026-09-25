<?php
/**
 * Datos centralizados para el componente "fases".
 * Añadir un nuevo tipo de fase = añadir una clave aquí (ej. 'branding').
 * Añadir un idioma nuevo a un tipo existente = añadir 'fr' => [...] dentro de ese tipo.
 */

$FASES_DATA = [

    'web' => [
        'es' => [
            'eyebrow'  => 'Nuestro proceso',
            'titulo'   => 'Las fases de una página web',
            'subtitulo'=> 'Para alcanzar un sitio web exitoso las cosas deben hacerse con el cuidado necesario y en el orden correspondiente — el orden de los factores sí altera el producto.',
            'pasos' => [
                ['numero'=>'01','icono'=>'ti-search','titulo'=>'Estudio del proyecto','desc'=>'Analizamos cuáles son tus objetivos, el público al que nos dirigimos y estudiamos a la competencia. A partir del estudio te presentamos un proyecto web y una estrategia de marketing digital ganadoras.'],
                ['numero'=>'02','icono'=>'ti-palette','titulo'=>'Diseño web','desc'=>'Nuestros diseñadores querrán conocer tus gustos y las referencias del sector. Te propondrán un diseño a medida de las principales páginas de tu futura web, que discutiremos, enmendaremos y aprobaremos.'],
                ['numero'=>'03','icono'=>'ti-code','titulo'=>'Programación','desc'=>'Nuestros programadores crean el código de la web para que responda al diseño planteado e incorpore todas las funcionalidades necesarias. Realizamos pruebas de calidad y seguridad.'],
                ['numero'=>'04','icono'=>'ti-chart-bar','titulo'=>'SEO','desc'=>'A partir de un estudio de palabras clave y una estrategia acordada, preparamos los fundamentos de la web para que sea rastreada por los buscadores y esté lista para posicionar.'],
                ['numero'=>'05','icono'=>'ti-rocket','titulo'=>'Seguimiento y mejora continua','desc'=>'La publicación de la web solo es el comienzo. Esta necesita atraer tráfico cualificado, darse a conocer y generar ventas a través del SEO y el SEM. Haremos seguimiento y mejoras constantes para crecer contigo.'],
            ],
        ],
        'en' => [
            'eyebrow'  => 'Our process',
            'titulo'   => 'The stages of a website',
            'subtitulo'=> 'A successful website has to be built with care and in the right order — the order really does change the outcome.',
            'pasos' => [
                ['numero'=>'01','icono'=>'ti-search','titulo'=>'Project research','desc'=>'We analyze your goals, your target audience, and your competitors. From this research we present a winning website project and digital marketing strategy.'],
                ['numero'=>'02','icono'=>'ti-palette','titulo'=>'Web design','desc'=>'Our designers get to know your taste and industry references, then propose a custom design for your site\'s main pages, which we\'ll discuss, refine, and approve together.'],
                ['numero'=>'03','icono'=>'ti-code','titulo'=>'Development','desc'=>'Our developers build the code so the site matches the approved design and includes every needed feature. We run quality and security testing throughout.'],
                ['numero'=>'04','icono'=>'ti-chart-bar','titulo'=>'SEO','desc'=>'Based on keyword research and an agreed strategy, we lay the foundations so the site can be crawled by search engines and is ready to rank.'],
                ['numero'=>'05','icono'=>'ti-rocket','titulo'=>'Ongoing tracking & improvement','desc'=>'Launching the site is just the start. It needs to attract qualified traffic, build visibility, and generate sales through SEO and SEM. We track results and keep improving as your business grows.'],
            ],
        ],
        'fr' => [
            'eyebrow'  => 'Notre processus',
            'titulo'   => 'Les étapes d\'un site web',
            'subtitulo'=> 'Pour réussir un site web, chaque chose doit être faite avec soin et dans le bon ordre — l\'ordre des facteurs change bel et bien le résultat.',
            'pasos' => [
                ['numero'=>'01','icono'=>'ti-search','titulo'=>'Étude du projet','desc'=>'Nous analysons vos objectifs, votre public cible et étudions la concurrence. Cette étude débouche sur un projet web et une stratégie de marketing digital gagnants.'],
                ['numero'=>'02','icono'=>'ti-palette','titulo'=>'Design web','desc'=>'Nos designers cherchent à connaître vos goûts et les références de votre secteur. Ils proposent un design sur mesure des principales pages de votre futur site, que nous discuterons et validerons ensemble.'],
                ['numero'=>'03','icono'=>'ti-code','titulo'=>'Développement','desc'=>'Nos développeurs créent le code du site pour qu\'il corresponde au design validé et intègre toutes les fonctionnalités nécessaires. Nous effectuons des tests de qualité et de sécurité.'],
                ['numero'=>'04','icono'=>'ti-chart-bar','titulo'=>'SEO','desc'=>'À partir d\'une étude de mots-clés et d\'une stratégie convenue, nous préparons les fondations du site pour qu\'il soit exploré par les moteurs de recherche et prêt à se positionner.'],
                ['numero'=>'05','icono'=>'ti-rocket','titulo'=>'Suivi et amélioration continue','desc'=>'La mise en ligne du site n\'est que le début. Il doit attirer du trafic qualifié, se faire connaître et générer des ventes grâce au SEO et au SEA. Nous assurons un suivi et des améliorations constantes pour grandir avec vous.'],
            ],
        ],
    ],

    'seo' => [
        'es' => [
            'eyebrow'  => 'Nuestro proceso',
            'titulo'   => 'Cómo trabajamos el SEO',
            'subtitulo'=> 'Posicionar en Google no es magia, es método. Este es el proceso que seguimos para que tu web suba y se mantenga arriba.',
            'pasos' => [
                ['numero'=>'01','icono'=>'ti-search','titulo'=>'Auditoría SEO','desc'=>'Analizamos la estructura técnica, los errores de indexación, la velocidad de carga y los contenidos duplicados. Con ese diagnóstico sabemos exactamente dónde atacar para que cada acción tenga impacto real.'],
                ['numero'=>'02','icono'=>'ti-key','titulo'=>'Investigación y estrategia de keywords','desc'=>'Identificamos qué busca realmente tu cliente y con qué intención, para elegir los términos que tiene sentido perseguir según tu mercado, ya sea local, nacional o internacional.'],
                ['numero'=>'03','icono'=>'ti-settings','titulo'=>'Optimización on-page y técnica','desc'=>'Trabajamos la arquitectura de URLs, los metadatos, los datos estructurados, la velocidad y la compatibilidad móvil — todo lo que Google evalúa por debajo de la superficie.'],
                ['numero'=>'04','icono'=>'ti-file-text','titulo'=>'Contenido y autoridad','desc'=>'Creamos páginas de servicio y landings orientadas a intención comercial real, y reforzamos la autoridad de tu web con enlazado interno y externo.'],
                ['numero'=>'05','icono'=>'ti-chart-line','titulo'=>'Monitorización y mejora continua','desc'=>'Hacemos seguimiento de posiciones, tráfico y conversiones, y ajustamos la estrategia mes a mes. El SEO no termina nunca, se itera.'],
            ],
        ],
        'en' => [
            'eyebrow'  => 'Our process',
            'titulo'   => 'How we approach SEO',
            'subtitulo'=> 'Ranking on Google isn\'t magic, it\'s method. This is the process we follow to get your site up — and keep it there.',
            'pasos' => [
                ['numero'=>'01','icono'=>'ti-search','titulo'=>'SEO audit','desc'=>'We analyze your site\'s technical structure, indexing errors, load speed, and duplicate content. That diagnosis tells us exactly where to focus so every action has real impact.'],
                ['numero'=>'02','icono'=>'ti-key','titulo'=>'Keyword research & strategy','desc'=>'We identify what your customers are actually searching for and with what intent, then choose the terms worth targeting for your market — local, national, or international.'],
                ['numero'=>'03','icono'=>'ti-settings','titulo'=>'On-page & technical optimization','desc'=>'We work on URL structure, metadata, structured data, speed, and mobile compatibility — everything Google evaluates beneath the surface.'],
                ['numero'=>'04','icono'=>'ti-file-text','titulo'=>'Content & authority','desc'=>'We build service pages and landing pages aimed at real commercial intent, and strengthen your site\'s authority through internal and external linking.'],
                ['numero'=>'05','icono'=>'ti-chart-line','titulo'=>'Monitoring & continuous improvement','desc'=>'We track rankings, traffic, and conversions, adjusting the strategy month by month. SEO never really finishes — it\'s an ongoing loop.'],
            ],
        ],
        'fr' => [
            'eyebrow'  => 'Notre processus',
            'titulo'   => 'Notre méthode SEO',
            'subtitulo'=> 'Se positionner sur Google n\'est pas de la magie, c\'est une méthode. Voici le processus que nous suivons pour faire monter votre site — et l\'y maintenir.',
            'pasos' => [
                ['numero'=>'01','icono'=>'ti-search','titulo'=>'Audit SEO','desc'=>'Nous analysons la structure technique, les erreurs d\'indexation, la vitesse de chargement et le contenu dupliqué. Ce diagnostic nous indique précisément où agir pour un impact réel.'],
                ['numero'=>'02','icono'=>'ti-key','titulo'=>'Recherche et stratégie de mots-clés','desc'=>'Nous identifions ce que vos clients recherchent réellement et avec quelle intention, afin de choisir les termes pertinents selon votre marché — local, national ou international.'],
                ['numero'=>'03','icono'=>'ti-settings','titulo'=>'Optimisation on-page et technique','desc'=>'Nous travaillons l\'architecture des URLs, les métadonnées, les données structurées, la vitesse et la compatibilité mobile — tout ce que Google évalue sous la surface.'],
                ['numero'=>'04','icono'=>'ti-file-text','titulo'=>'Contenu et autorité','desc'=>'Nous créons des pages de service et des landing pages orientées vers une réelle intention commerciale, et renforçons l\'autorité de votre site par le maillage interne et externe.'],
                ['numero'=>'05','icono'=>'ti-chart-line','titulo'=>'Suivi et amélioration continue','desc'=>'Nous suivons le positionnement, le trafic et les conversions, et ajustons la stratégie mois après mois. Le SEO ne s\'arrête jamais, il s\'affine en continu.'],
            ],
        ],
    ],

    'diseno-grafico' => [
        'es' => [
            'eyebrow'  => 'Cómo trabajamos',
            'titulo'   => 'Un proceso creativo claro y colaborativo',
            'subtitulo'=> 'Cada proyecto de diseño sigue el mismo camino, pensado para que el resultado final sea exactamente el que necesitas.',
            'pasos' => [
                ['numero'=>'01','icono'=>'ti-clipboard-text','titulo'=>'Briefing','desc'=>'Entendemos tu marca, tu sector y tus objetivos. Analizamos referencias, competencia y el mensaje que quieres transmitir para partir con una base sólida.'],
                ['numero'=>'02','icono'=>'ti-bulb','titulo'=>'Concepto','desc'=>'Desarrollamos la dirección creativa y las primeras propuestas visuales, explorando distintos caminos hasta encontrar el que mejor representa tu marca.'],
                ['numero'=>'03','icono'=>'ti-palette','titulo'=>'Diseño','desc'=>'Creamos las piezas finales con atención al detalle, coherencia visual y aplicación correcta de tipografías, colores y composición.'],
                ['numero'=>'04','icono'=>'ti-adjustments','titulo'=>'Revisión','desc'=>'Ajustamos el diseño contigo hasta que el resultado sea exactamente el que necesitas, cuidando cada detalle antes de la entrega.'],
                ['numero'=>'05','icono'=>'ti-package','titulo'=>'Entrega','desc'=>'Preparamos los archivos listos para imprenta y uso digital, en todos los formatos que necesites para tus distintos canales.'],
            ],
        ],
        'en' => [
            'eyebrow'  => 'How we work',
            'titulo'   => 'A clear, collaborative creative process',
            'subtitulo'=> 'Every design project follows the same path, built to make sure the final result is exactly what you need.',
            'pasos' => [
                ['numero'=>'01','icono'=>'ti-clipboard-text','titulo'=>'Briefing','desc'=>'We get to know your brand, your industry, and your goals. We look at references, competitors, and the message you want to convey to start on solid ground.'],
                ['numero'=>'02','icono'=>'ti-bulb','titulo'=>'Concept','desc'=>'We develop the creative direction and first visual proposals, exploring different paths until we find the one that best represents your brand.'],
                ['numero'=>'03','icono'=>'ti-palette','titulo'=>'Design','desc'=>'We create the final assets with attention to detail, visual consistency, and correct use of typography, color, and composition.'],
                ['numero'=>'04','icono'=>'ti-adjustments','titulo'=>'Review','desc'=>'We refine the design together with you until the result is exactly what you need, polishing every detail before delivery.'],
                ['numero'=>'05','icono'=>'ti-package','titulo'=>'Delivery','desc'=>'We prepare print-ready and digital files, in every format you need across your different channels.'],
            ],
        ],
        'fr' => [
            'eyebrow'  => 'Notre méthode',
            'titulo'   => 'Un processus créatif clair et collaboratif',
            'subtitulo'=> 'Chaque projet de design suit le même chemin, pensé pour que le résultat final soit exactement celui dont vous avez besoin.',
            'pasos' => [
                ['numero'=>'01','icono'=>'ti-clipboard-text','titulo'=>'Briefing','desc'=>'Nous cherchons à comprendre votre marque, votre secteur et vos objectifs. Nous étudions les références, la concurrence et le message que vous souhaitez transmettre pour partir sur des bases solides.'],
                ['numero'=>'02','icono'=>'ti-bulb','titulo'=>'Concept','desc'=>'Nous développons la direction créative et les premières propositions visuelles, en explorant plusieurs pistes jusqu\'à trouver celle qui représente le mieux votre marque.'],
                ['numero'=>'03','icono'=>'ti-palette','titulo'=>'Design','desc'=>'Nous créons les éléments finaux avec un souci du détail, une cohérence visuelle et une application soignée des typographies, couleurs et compositions.'],
                ['numero'=>'04','icono'=>'ti-adjustments','titulo'=>'Révision','desc'=>'Nous ajustons le design avec vous jusqu\'à ce que le résultat soit exactement celui dont vous avez besoin, en soignant chaque détail avant la livraison.'],
                ['numero'=>'05','icono'=>'ti-package','titulo'=>'Livraison','desc'=>'Nous préparons les fichiers prêts pour l\'impression et le numérique, dans tous les formats nécessaires à vos différents canaux.'],
            ],
        ],
    ],

];
