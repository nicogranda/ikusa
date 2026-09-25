<?php

namespace App\Domains\GeographicSEO;

final class GeographicSeoModel
{
    public function getGipuzkoaData(): array
    {
        $sectors = [
            'tourism' => 'Turismo y alojamiento',
            'gastronomy' => 'Restaurantes y gastronomía',
            'beaches' => 'Playas y actividades costeras',
            'industry' => 'Industria y fabricación',
            'logistics' => 'Logística y transporte',
            'commerce' => 'Comercio local',
            'health' => 'Clínicas y salud privada',
            'professional' => 'Servicios profesionales',
            'construction' => 'Construcción y reformas',
            'automotive' => 'Automoción',
        ];

        // Selección editorial inicial.
        // Los textos son editables y NO pretenden ser
        // un estudio estadístico de la economía municipal.
        $municipalities = [

            'donostia-san-sebastian' => $this->municipality(
                'Donostia (San Sebastián)',
                '20069',
                ['tourism', 'gastronomy', 'health', 'professional'],
                '/es/seo-donostia'
            ),

            'irun' => $this->municipality(
                'Irun',
                '20045',
                ['logistics', 'commerce', 'industry', 'professional'],
                '/es/seo-irun'
            ),

            'errenteria' => $this->municipality(
                'Errenteria',
                '20067',
                ['commerce', 'industry', 'construction']
            ),

            'eibar' => $this->municipality(
                'Eibar',
                '20030',
                ['industry', 'automotive', 'commerce']
            ),

            'zarautz' => $this->municipality(
                'Zarautz',
                '20079',
                ['tourism', 'beaches', 'gastronomy', 'commerce']
            ),

            'hondarribia' => $this->municipality(
                'Hondarribia',
                '20036',
                ['tourism', 'beaches', 'gastronomy']
            ),

            'hernani' => $this->municipality(
                'Hernani',
                '20040',
                ['industry', 'construction', 'commerce']
            ),

            'lasarte-oria' => $this->municipality(
                'Lasarte-Oria',
                '20902',
                ['commerce', 'professional', 'construction']
            ),

            'pasaia' => $this->municipality(
                'Pasaia',
                '20064',
                ['logistics', 'industry', 'gastronomy']
            ),

            'tolosa' => $this->municipality(
                'Tolosa',
                '20071',
                ['commerce', 'gastronomy', 'professional']
            ),

            'arrasate-mondragon' => $this->municipality(
                'Arrasate / Mondragón',
                '20055',
                ['industry', 'professional', 'commerce']
            ),

            'bergara' => $this->municipality(
                'Bergara',
                '20074',
                ['industry', 'commerce', 'professional']
            ),

            'andoain' => $this->municipality(
                'Andoain',
                '20009',
                ['industry', 'construction', 'commerce']
            ),

            'oñati' => $this->municipality(
                'Oñati',
                '20059',
                ['industry', 'tourism', 'professional']
            ),

            'azpeitia' => $this->municipality(
                'Azpeitia',
                '20018',
                ['industry', 'commerce', 'tourism']
            ),

            'azkoitia' => $this->municipality(
                'Azkoitia',
                '20017',
                ['industry', 'commerce', 'construction']
            ),

            'zumaia' => $this->municipality(
                'Zumaia',
                '20081',
                ['tourism', 'beaches', 'gastronomy', 'industry']
            ),

            'getaria' => $this->municipality(
                'Getaria',
                '20039',
                ['tourism', 'beaches', 'gastronomy']
            ),

            'ordizia' => $this->municipality(
                'Ordizia',
                '20076',
                ['commerce', 'gastronomy', 'professional']
            ),

            'beasain' => $this->municipality(
                'Beasain',
                '20019',
                ['industry', 'commerce', 'professional']
            ),

            'urretxu' => $this->municipality(
                'Urretxu',
                '20077',
                ['industry', 'commerce', 'construction']
            ),

            'zumarraga' => $this->municipality(
                'Zumarraga',
                '20080',
                ['industry', 'commerce', 'health']
            ),

            'deba' => $this->municipality(
                'Deba',
                '20029',
                ['tourism', 'beaches', 'gastronomy']
            ),

            'mutriku' => $this->municipality(
                'Mutriku',
                '20056',
                ['tourism', 'beaches', 'gastronomy']
            ),

            'orio' => $this->municipality(
                'Orio',
                '20061',
                ['tourism', 'beaches', 'gastronomy']
            ),
        ];

        foreach ($municipalities as $slug => &$municipality) {

            $municipality['slug'] = $slug;
            $municipality['sector_data'] = [];

            foreach ($municipality['sectors'] as $sectorKey) {

                $municipality['sector_data'][] = [
                    'key' => $sectorKey,
                    'title' => $sectors[$sectorKey],
                    'text' => $this->sectorText(
                        $municipality['name'],
                        $sectorKey
                    ),
                ];
            }
        }

        unset($municipality);

        return [
            'eyebrow' => 'AGENCIA SEO EN GIPUZKOA',

            'title' =>
                'SEO local en los municipios estratégicos de Gipuzkoa',

            'intro' =>
                'Selecciona un municipio para consultar sectores con potencial de búsqueda local. El mapa funciona como navegación; los H3 y H4 se renderizan también en HTML para que el contenido sea accesible y rastreable.',

            'municipalities' => $municipalities,
        ];
    }


    private function municipality(
        string $name,
        string $ine,
        array $sectors,
        ?string $url = null
    ): array {

        return [
            'name' => $name,
            'ine' => $ine,
            'sectors' => $sectors,
            'url' => $url,
        ];
    }


    private function sectorText(
        string $municipality,
        string $sector
    ): string {

        $templates = [

            'tourism' =>
                "En {$municipality}, una estrategia SEO para turismo debe conectar alojamiento, experiencias y búsquedas geolocalizadas con páginas útiles para el visitante.",

            'gastronomy' =>
                "Restaurantes y negocios gastronómicos de {$municipality} pueden trabajar búsquedas locales, Google Maps, carta, reservas y consultas vinculadas a la zona.",

            'beaches' =>
                "Las actividades vinculadas a costa y playa en {$municipality} pueden captar búsquedas estacionales y locales mediante contenidos específicos y presencia en mapas.",

            'industry' =>
                "Las empresas industriales de {$municipality} pueden orientar el SEO a servicios, capacidades técnicas, sectores atendidos y búsquedas B2B de alta intención.",

            'logistics' =>
                "Para logística y transporte en {$municipality}, el SEO puede trabajar rutas de servicio, especialidades, cobertura territorial y consultas B2B.",

            'commerce' =>
                "El comercio de {$municipality} puede reforzar su descubrimiento en Google mediante SEO local, fichas de negocio, categorías y páginas de servicio bien estructuradas.",

            'health' =>
                "Clínicas y centros privados de {$municipality} pueden estructurar servicios, especialidades y búsquedas locales cuidando la precisión del contenido y la confianza.",

            'professional' =>
                "Los servicios profesionales de {$municipality} pueden captar demanda con páginas orientadas a problemas concretos, especialidades y búsquedas locales de intención comercial.",

            'construction' =>
                "Construcción y reformas en {$municipality} pueden trabajar servicios específicos, áreas de cobertura, proyectos y consultas locales con intención de contratación.",

            'automotive' =>
                "El sector de automoción en {$municipality} puede organizar servicios, especialidades y búsquedas locales para mejorar su visibilidad orgánica y en mapas.",
        ];

        return $templates[$sector] ?? '';
    }
}