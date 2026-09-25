<?php
/**
 * Datos centralizados para el componente "comparison".
 * Mismo patrón que fases/data.php: un tipo (ej. 'seo') con un
 * array por idioma. Añadir un nuevo tipo de comparación (ej. 'web')
 * = añadir una clave nueva aquí.
 */

$COMPARISON_DATA = [

    'seo' => [
        'es' => [
            'titulo'    => '¿Qué diferencia a Ikusa de una agencia SEO convencional?',
            'subtitulo' => 'No todas las agencias trabajan igual. En Ikusa desarrollamos estrategias SEO personalizadas basadas en datos, análisis técnico y objetivos de negocio. Nuestro enfoque busca resultados sostenibles, no soluciones rápidas que desaparecen con el tiempo.',
            'col_competidor' => 'Agencia SEO convencional',
            'col_ikusa'      => 'Ikusa',
            'filas' => [
                ['aspecto'=>'Estrategia',       'competidor'=>'Plantillas genéricas para todos los clientes.',                              'ikusa'=>'Plan SEO personalizado según el sector, competencia y objetivos.'],
                ['aspecto'=>'Auditoría inicial','competidor'=>'Revisión superficial o inexistente.',                                        'ikusa'=>'Auditoría técnica completa con análisis de más de 150 factores SEO.'],
                ['aspecto'=>'SEO Técnico',      'competidor'=>'No suele incluirse.',                                                        'ikusa'=>'Optimización de velocidad, indexación, arquitectura, Core Web Vitals y rastreo.'],
                ['aspecto'=>'SEO Local',        'competidor'=>'Optimización básica.',                                                       'ikusa'=>'Google Business Profile, Google Maps, autoridad local y posicionamiento en Gipuzkoa.'],
                ['aspecto'=>'Contenido',        'competidor'=>'Textos genéricos.',                                                          'ikusa'=>'Contenido optimizado para intención de búsqueda y conversión.'],
                ['aspecto'=>'Seguimiento',      'competidor'=>'Sin informes o informes básicos.',                                           'ikusa'=>'Informes mensuales con evolución, tráfico, posiciones y acciones realizadas.'],
                ['aspecto'=>'Objetivo',         'competidor'=>'Aumentar visitas.',                                                          'ikusa'=>'Conseguir más clientes, contactos y oportunidades de negocio.'],
            ],
        ],
        'en' => [
            'titulo'    => 'What makes Ikusa different from a conventional SEO agency?',
            'subtitulo' => 'Not every agency works the same way. At Ikusa we build personalized SEO strategies based on data, technical analysis, and business goals. Our approach aims for sustainable results, not quick fixes that fade over time.',
            'col_competidor' => 'Conventional SEO agency',
            'col_ikusa'      => 'Ikusa',
            'filas' => [
                ['aspecto'=>'Strategy',       'competidor'=>'Generic templates for every client.',                        'ikusa'=>'Custom SEO plan based on industry, competition, and goals.'],
                ['aspecto'=>'Initial audit',  'competidor'=>'Superficial or nonexistent review.',                         'ikusa'=>'Full technical audit analyzing 150+ SEO factors.'],
                ['aspecto'=>'Technical SEO',  'competidor'=>'Not usually included.',                                      'ikusa'=>'Speed, indexing, architecture, Core Web Vitals, and crawling optimization.'],
                ['aspecto'=>'Local SEO',      'competidor'=>'Basic optimization.',                                        'ikusa'=>'Google Business Profile, Google Maps, local authority, and ranking in Gipuzkoa.'],
                ['aspecto'=>'Content',        'competidor'=>'Generic copy.',                                              'ikusa'=>'Content optimized for search intent and conversion.'],
                ['aspecto'=>'Tracking',       'competidor'=>'No reports or basic reports.',                               'ikusa'=>'Monthly reports covering progress, traffic, rankings, and actions taken.'],
                ['aspecto'=>'Goal',           'competidor'=>'Increase visits.',                                           'ikusa'=>'Win more clients, leads, and business opportunities.'],
            ],
        ],
        'fr' => [
            'titulo'    => "Qu'est-ce qui différencie Ikusa d'une agence SEO classique ?",
            'subtitulo' => "Toutes les agences ne travaillent pas de la même façon. Chez Ikusa, nous développons des stratégies SEO personnalisées basées sur les données, l'analyse technique et vos objectifs business. Notre approche vise des résultats durables, pas des solutions rapides qui disparaissent avec le temps.",
            'col_competidor' => 'Agence SEO classique',
            'col_ikusa'      => 'Ikusa',
            'filas' => [
                ['aspecto'=>'Stratégie',      'competidor'=>'Modèles génériques pour tous les clients.',                                   'ikusa'=>'Plan SEO personnalisé selon le secteur, la concurrence et les objectifs.'],
                ['aspecto'=>'Audit initial',  'competidor'=>'Revue superficielle ou inexistante.',                                         'ikusa'=>'Audit technique complet analysant plus de 150 facteurs SEO.'],
                ['aspecto'=>'SEO Technique',  'competidor'=>'Rarement inclus.',                                                            'ikusa'=>"Optimisation de la vitesse, de l'indexation, de l'architecture, des Core Web Vitals et de l'exploration."],
                ['aspecto'=>'SEO Local',      'competidor'=>'Optimisation basique.',                                                       'ikusa'=>'Google Business Profile, Google Maps, autorité locale et positionnement en Gipuzkoa.'],
                ['aspecto'=>'Contenu',        'competidor'=>'Textes génériques.',                                                          'ikusa'=>"Contenu optimisé pour l'intention de recherche et la conversion."],
                ['aspecto'=>'Suivi',          'competidor'=>'Sans rapports ou rapports basiques.',                                         'ikusa'=>'Rapports mensuels avec évolution, trafic, positions et actions réalisées.'],
                ['aspecto'=>'Objectif',       'competidor'=>'Augmenter les visites.',                                                      'ikusa'=>"Obtenir plus de clients, de contacts et d'opportunités commerciales."],
            ],
        ],
    ],

];
