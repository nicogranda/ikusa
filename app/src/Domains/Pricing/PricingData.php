<?php

declare(strict_types=1);

namespace App\Domains\Pricing;

final class PricingData
{
    /**
     * Devuelve los datos del pricing de un servicio.
     *
     * Uso:
     * PricingData::get('seo');
     * PricingData::get('diseno-web');
     */
    public static function get(string $service = 'seo'): array
    {
        $service = strtolower(trim($service));

        $aliases = [
            'seo-donostia'             => 'seo',
            'posicionamiento-seo'      => 'seo',
            'diseno-web-donostia'      => 'diseno-web',
            'desarrollo-web'           => 'diseno-web',
            'desarrollo-web-donostia'  => 'diseno-web',
            'web-design'               => 'diseno-web',
        ];

        $service = $aliases[$service] ?? $service;

        return match ($service) {
            'diseno-web' => self::webDesign(),
            'seo'        => self::seo(),
            default      => self::seo(),
        };
    }

    /**
     * PRICING SEO
     *
     * Conserva los servicios y precios del pricing actual.
     */
    private static function seo(): array
    {
        return [
            'service' => 'seo',

            'eyebrow' => 'PRECIOS',

            'title' => 'Servicios de SEO y marketing digital',

            'intro' => 'Elige el servicio que necesita tu negocio. Te ayudamos a mejorar tu visibilidad, atraer clientes y desarrollar tu presencia digital.',

            'plans' => [

                [
                    'title' => 'Diagnóstico Web',

                    'description' => 'Una primera revisión de tu presencia digital para detectar problemas y oportunidades.',

                    'amount' => 'Gratis',
                    'currency' => '',
                    'period' => '',

                    'featured' => false,
                    'badge' => '',

                    'features' => [
                        'Análisis rápido de tu presencia digital',
                        'Detección de problemas críticos',
                        'Recomendaciones prioritarias',
                        'Reunión sin compromiso',
                    ],

                    'details' => [],

                    'note' => 'Una primera valoración para conocer tu situación y determinar las acciones prioritarias.',

                    'button' => 'Solicitar diagnóstico',

                    'service' => 'seo',
                    'plan' => 'diagnostico-web',
                ],

                [
                    'title' => 'SEO Profesional',

                    'description' => 'Posicionamiento SEO mensual para mejorar la visibilidad de tu negocio en Google y atraer búsquedas con intención comercial.',

                    'amount' => 'Desde 445',
                    'currency' => '€',
                    'period' => '/mes',

                    'featured' => true,
                    'badge' => 'POPULAR',

                    'features' => [
                        'Auditoría SEO inicial de 53 módulos',
                        'Optimización técnica y on-page continua',
                        'Seguimiento de palabras clave y oportunidades',
                        'Optimización y creación de contenidos SEO',
                        'SEO local y Google Maps cuando aplica',
                    ],

                    'details' => [
                        'Enlazado interno y mejora de páginas estratégicas',
                        'Seguimiento con Search Console y Analytics',
                        'Dashboard de resultados en tiempo real',
                    ],

                    'note' => 'El alcance se adapta al tamaño, competencia y necesidades de cada proyecto.',

                    'button' => 'Solicitar información',

                    'service' => 'seo',
                    'plan' => 'seo-profesional',
                ],

                [
                    'title' => 'Google Ads (SEM)',

                    'description' => 'Gestión de campañas de Google Ads para captar clientes mediante publicidad orientada a conversión.',

                    'amount' => 'Desde 440',
                    'currency' => '€',
                    'period' => '/mes',

                    'featured' => false,
                    'badge' => '',

                    'features' => [
                        'Configuración y gestión de campañas',
                        'Search, Shopping y Performance Max',
                        'Investigación de palabras clave',
                        'Optimización continua de campañas',
                        'Seguimiento real de conversiones',
                    ],

                    'details' => [
                        'Coordinación de estrategia SEO + SEM',
                    ],

                    'note' => 'La inversión publicitaria en Google Ads no está incluida.',

                    'button' => 'Solicitar información',

                    'service' => 'sem',
                    'plan' => 'google-ads',
                ],

                [
                    'title' => 'Redes Sociales',

                    'description' => 'Gestión mensual de redes sociales para mantener una presencia profesional y conectar con tu público.',

                    'amount' => 'Desde 486',
                    'currency' => '€',
                    'period' => '/mes',

                    'featured' => false,
                    'badge' => '',

                    'features' => [
                        'Instagram, Facebook y LinkedIn',
                        'Creatividades adaptadas a tu identidad visual',
                        'Calendario editorial mensual',
                        'Planificación de contenidos',
                        'Entre 2 y 5 publicaciones por semana',
                    ],

                    'details' => [
                        'Seguimiento de rendimiento',
                    ],

                    'note' => 'La frecuencia, las redes y el volumen de contenido se definen según cada marca.',

                    'button' => 'Solicitar información',

                    'service' => 'redes-sociales',
                    'plan' => 'gestion-redes-sociales',
                ],

                [
                    'title' => 'Mantenimiento WP',

                    'description' => 'Mantenimiento técnico de sitios WordPress para mantener tu web actualizada y funcionando correctamente.',

                    'amount' => 'Desde 50',
                    'currency' => '€',
                    'period' => '/mes',

                    'featured' => false,
                    'badge' => '',

                    'features' => [
                        'Actualizaciones de WordPress CORE',
                        'Actualización de plugins',
                        'Backup diario automático',
                        'Monitorización 24/7',
                        'Revisión de funcionamiento',
                    ],

                    'details' => [
                        'Soporte WooCommerce incluido',
                    ],

                    'note' => 'El precio depende del tamaño, complejidad y necesidades técnicas del sitio web.',

                    'button' => 'Solicitar información',

                    'service' => 'mantenimiento-web',
                    'plan' => 'mantenimiento-wp',
                ],

                [
                    'title' => 'Auditoría SEO',

                    'description' => 'Análisis del estado SEO de tu web para identificar problemas técnicos y oportunidades de posicionamiento.',

                    'amount' => '1.490',
                    'currency' => '€',
                    'period' => '/proyecto',

                    'featured' => false,
                    'badge' => '',

                    'features' => [
                        'Análisis completo de 53 módulos',
                        'Revisión técnica y on-page',
                        'Análisis de indexación y rastreo',
                        'Evaluación de contenidos',
                        'Informe técnico detallado',
                    ],

                    'details' => [
                        'Detección de oportunidades SEO',
                        'Plan de acción priorizado',
                        'Presentación ejecutiva incluida',
                    ],

                    'note' => 'La implementación posterior de las mejoras se presupuesta según el alcance.',

                    'button' => 'Solicitar auditoría',

                    'service' => 'seo',
                    'plan' => 'auditoria-seo',
                ],

            ],

            'infrastructure' => null,
        ];
    }

    /**
     * PRICING DISEÑO WEB
     */
    private static function webDesign(): array
    {
        return [
            'service' => 'diseno-web',

            'eyebrow' => 'DISEÑO Y DESARROLLO WEB',

            'title' => 'Una página web a la medida de tu negocio',

            'intro' => 'Desde una web corporativa hasta una plataforma a medida. Cuéntanos qué necesitas y prepararemos una propuesta adaptada a tu proyecto.',

            'plans' => [

                [
                    'title' => 'Web Corporativa',

                    'description' => 'Una web profesional para presentar tu negocio, mostrar tus servicios y facilitar el contacto con tus clientes.',

                    'amount' => 'Presupuesto a medida',
                    'currency' => '',
                    'period' => '',

                    'featured' => false,
                    'badge' => '',

                    'features' => [
                        'Diseño adaptado a tu identidad visual',
                        'Diseño responsive',
                        'Páginas esenciales de tu negocio',
                        'Formularios y llamadas a la acción',
                        'Optimización SEO técnica inicial',
                    ],

                    'details' => [
                        'Optimización inicial de velocidad e imágenes',
                        'Configuración de analítica cuando corresponda',
                        'Revisión y publicación de la web',
                    ],

                    'note' => 'El presupuesto depende del número de páginas, contenidos y funcionalidades.',

                    'button' => 'Solicitar presupuesto',

                    'service' => 'diseno-web',
                    'plan' => 'web-corporativa',
                ],

                [
                    'title' => 'Web Profesional',

                    'description' => 'Una web diseñada para presentar tus servicios, competir en tu sector y convertir visitas en oportunidades de negocio.',

                    'amount' => 'Presupuesto a medida',
                    'currency' => '',
                    'period' => '',

                    'featured' => true,
                    'badge' => 'MÁS SOLICITADO',

                    'features' => [
                        'Investigación inicial de palabras clave',
                        'Arquitectura web orientada a SEO y conversión',
                        'Diseño UX/UI personalizado en Figma',
                        'Páginas de servicios y secciones estratégicas',
                        'Formularios y elementos de captación',
                    ],

                    'details' => [
                        'Diseño adaptable a todos los dispositivos',
                        'Optimización técnica SEO inicial',
                        'Integración de Analytics y Search Console cuando corresponda',
                        'Pruebas de funcionamiento y lanzamiento',
                    ],

                    'note' => 'Los contenidos, el SEO mensual y las integraciones especiales se presupuestan según el alcance.',

                    'button' => 'Solicitar presupuesto',

                    'service' => 'diseno-web',
                    'plan' => 'web-profesional',
                ],

                [
                    'title' => 'Desarrollo a Medida',

                    'description' => 'Para proyectos que necesitan funcionalidades específicas, integraciones o una plataforma propia.',

                    'amount' => 'Presupuesto a medida',
                    'currency' => '',
                    'period' => '',

                    'featured' => false,
                    'badge' => '',

                    'features' => [
                        'Análisis de requisitos del proyecto',
                        'Diseño UX/UI adaptado a los usuarios',
                        'Arquitectura y desarrollo modular',
                        'Bases de datos y administración cuando se requieran',
                        'Integraciones con herramientas externas',
                    ],

                    'details' => [
                        'Formularios y flujos personalizados',
                        'Pruebas funcionales y de seguridad',
                        'Preparación para futuras ampliaciones',
                    ],

                    'note' => 'El alcance, los plazos y el mantenimiento se definen en una propuesta personalizada.',

                    'button' => 'Solicitar presupuesto',

                    'service' => 'diseno-web',
                    'plan' => 'desarrollo-a-medida',
                ],

            ],

            /*
             * Información adicional para mostrar debajo de las tarjetas.
             * No se afirma que dominio y hosting estén incluidos.
             */
            'infrastructure' => [

                'eyebrow' => 'DOMINIO Y HOSTING',

                'title' => 'Tu web, tu dominio y tu alojamiento',

                'description' => 'Te ayudamos a elegir y configurar los servicios necesarios para publicar tu página web. Antes de empezar, te indicamos cuáles están incluidos en la propuesta y cuáles tienen costes de renovación.',

                'items' => [

                    [
                        'icon' => 'fa-globe',
                        'title' => 'Dominio',
                        'description' => 'Te ayudamos a registrar un dominio nuevo o a conectar el que ya tienes.',
                        'note' => 'El registro y las renovaciones se detallan en el presupuesto.',
                    ],

                    [
                        'icon' => 'fa-server',
                        'title' => 'Hosting',
                        'description' => 'Te orientamos sobre el alojamiento adecuado para el tamaño y las necesidades técnicas de tu web.',
                        'note' => 'El alojamiento y su renovación se detallan en la propuesta.',
                    ],

                    [
                        'icon' => 'fa-screwdriver-wrench',
                        'title' => 'Configuración y lanzamiento',
                        'description' => 'Configuramos la conexión entre dominio y hosting, HTTPS y los ajustes necesarios para publicar tu web.',
                        'note' => 'El alcance de la configuración se define antes de comenzar.',
                    ],

                ],

                'footer' => '¿Ya tienes dominio y hosting? Podemos revisar tu configuración actual y valorar si es adecuada para la nueva web.',

            ],
        ];
    }
}