<?php

declare(strict_types=1);

namespace App\Domains\Pricing;

require_once __DIR__ . '/PricingData.php';

final class PricingController
{
    /**
     * Obtiene el pricing correspondiente a la página actual.
     *
     * Se puede llamar sin argumentos desde el componente genérico:
     * $pricing = PricingController::get();
     */
    public static function get(?string $service = null): array
    {
        $service = self::resolveService($service);

        return PricingData::get($service);
    }

    private static function resolveService(?string $service): string
    {
        if ($service !== null && trim($service) !== '') {
            return self::normalize($service);
        }

        /*
         * Primero buscamos la referencia de la página, si existe.
         * No modificamos ni dependemos de la estructura de la BD.
         */
        $page = $GLOBALS['page'] ?? null;

        if (is_array($page)) {
            foreach (['reference', 'slug'] as $field) {
                if (!empty($page[$field]) && is_string($page[$field])) {
                    $resolved = self::normalize($page[$field]);

                    if ($resolved !== 'unknown') {
                        return $resolved;
                    }
                }
            }
        } elseif (is_string($page)) {
            $resolved = self::normalize($page);

            if ($resolved !== 'unknown') {
                return $resolved;
            }
        }

        /*
         * Alternativa: identificar el servicio mediante la URL.
         * Ejemplos:
         * /es/seo-donostia
         * /es/diseno-web-donostia
         */
        $path = (string) parse_url(
            $_SERVER['REQUEST_URI'] ?? '/',
            PHP_URL_PATH
        );

        $segments = explode('/', trim($path, '/'));
        $slug = (string) end($segments);

        $resolved = self::normalize($slug);

        return $resolved === 'unknown' ? 'seo' : $resolved;
    }

    private static function normalize(string $value): string
    {
        $value = strtolower(trim($value, '/ '));

        $webDesign = [
            'diseno-web',
            'diseno-web-donostia',
            'desarrollo-web',
            'desarrollo-web-donostia',
            'web-design',
            'web-development',
        ];

        if (in_array($value, $webDesign, true)) {
            return 'diseno-web';
        }

        $seo = [
            'seo',
            'seo-donostia',
            'posicionamiento-seo',
            'agencia-seo',
        ];

        if (in_array($value, $seo, true)) {
            return 'seo';
        }

        return 'unknown';
    }
}