<?php

namespace App\Domains\Reviews;

class ReviewsModel
{
    private string $apiKey;
    private string $placeId;
    private string $endpoint   = 'https://maps.googleapis.com/maps/api/place/details/json';
    private string $cacheFile;
    private int    $cacheTtl   = 315360000; // 10 años en segundos

    private array $config = [
        'fields'       => 'reviews,rating,user_ratings_total',
        'language'     => 'es',
        'reviews_sort' => 'most_relevant',
        'min_rating'   => 4,
        'max_reviews'  => 10,
    ];

    public function __construct()
    {
        $this->apiKey    = $_ENV['GOOGLE_PLACES_API_KEY'] ?? '';
        $this->placeId   = $_ENV['GOOGLE_PLACE_ID'] ?? '';
        $this->cacheFile = ROOT_PATH . '/petitcafe.es/storage/cache/google_reviews.json';
    }

   public function getReviews(): array
{
    // 1. Servir desde caché si existe y no ha expirado
    $cached = $this->loadCache();
    if ($cached !== null) {
        return $cached;
    }

    // API TEMPORALMENTE DESACTIVADA — descomentar cuando billing esté activo
    /*
    if (empty($this->apiKey) || empty($this->placeId)) {
        return $this->emptyResult('Credenciales de Google Places no configuradas.');
    }

    $response = $this->fetchFromApi($this->buildUrl());

    if ($response === null) {
        return $this->emptyResult('Error al conectar con la API de Google.');
    }

    if (($response['status'] ?? '') !== 'OK') {
        return $this->emptyResult('Respuesta inesperada: ' . ($response['status'] ?? 'UNKNOWN'));
    }

    $result = $response['result'] ?? [];

    $data = [
        'success'       => true,
        'error'         => null,
        'rating'        => (float) ($result['rating'] ?? 0),
        'total_ratings' => (int)   ($result['user_ratings_total'] ?? 0),
        'reviews'       => $this->parseReviews($result['reviews'] ?? []),
    ];

    $this->saveCache($data);

    return $data;
    */

    // TEMPORAL — JSON estático hasta activar billing
    return [
        'success'       => true,
        'error'         => null,
        'rating'        => 5.0,
        'total_ratings' => 125,
        'reviews'       => [
            ['author' => 'Sara Amini',           'avatar' => '', 'rating' => 5, 'text' => 'Aprecio un buen café, y la verdad es que puedo decir que Petit Café es de mis cafeterías preferidas en lo que a cafés se refiere.',                                              'time_ago' => 'Hace 8 horas'],
            ['author' => 'Ioane Galarza Arana',  'avatar' => '', 'rating' => 5, 'text' => 'Muy agradable y todo bien cuidado y de buena calidad.',                                                                                                                           'time_ago' => 'Hace una semana'],
            ['author' => 'Uxue Iruretagoyena',   'avatar' => '', 'rating' => 5, 'text' => 'Hace tiempo que no comía una tostada de salmón y aguacate tan rica. El trato entrañable, mila esker.',                                                                           'time_ago' => 'Hace una semana'],
            ['author' => 'A Bernhard',            'avatar' => '', 'rating' => 5, 'text' => 'True neighborhood joint with excellent coffee and treats. Acai bowl is generous portion. All great ingredients and overall an inviting atmosphere. We returned.',                'time_ago' => 'Hace 2 semanas'],
            ['author' => 'Paul Biehl',            'avatar' => '', 'rating' => 5, 'text' => 'The 5/5 experience for breakfast / brunch. Very friendly service, great coffee with oat milk options, and a sensational menu.',                                                 'time_ago' => 'Hace 2 semanas'],
            ['author' => 'Elsemieke Kuijpers',    'avatar' => '', 'rating' => 5, 'text' => 'Super nice very small little place with dedicated super friendly people that know how to make good coffee and really wonderful toast.',                                           'time_ago' => 'Hace 3 semanas'],
            ['author' => 'M Rowe',                'avatar' => '', 'rating' => 5, 'text' => 'Best coffee in San Sebastián! Lovely couple who own it.',                                                                                                                        'time_ago' => 'Hace un mes'],
            ['author' => 'Marcia Hüner',          'avatar' => '', 'rating' => 5, 'text' => 'If you want a cortado made with love - this is the place to be. Lovely barista, small place where you feel welcome and at home the second you come in.',                       'time_ago' => 'Hace un mes'],
            ['author' => 'Nisan İlçiz',           'avatar' => '', 'rating' => 5, 'text' => 'Fantastic little café in San Sebastián. Super friendly owners and seriously good single origin coffee. Easily one of the best I\'ve had here.',                                 'time_ago' => 'Hace un mes'],
            ['author' => 'Jake Ellington',        'avatar' => '', 'rating' => 5, 'text' => 'Incredible coffee. Best I found in the area. Super friendly staff. If you love good coffee this is your spot.',                                                                 'time_ago' => 'Hace un mes'],
        ],
    ];
}

    // ─── Caché ──────────────────────────────────────────────────────────────────

    private function loadCache(): ?array
    {
        if (!file_exists($this->cacheFile)) {
            return null;
        }

        $raw    = @file_get_contents($this->cacheFile);
        $cached = json_decode($raw, true);

        if (!isset($cached['expires_at'], $cached['data'])) {
            return null;
        }

        if (time() > $cached['expires_at']) {
            return null; // expirada — regenerar
        }

        return $cached['data'];
    }

    private function saveCache(array $data): void
    {
        $dir = dirname($this->cacheFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents(
            $this->cacheFile,
            json_encode([
                'expires_at' => time() + $this->cacheTtl,
                'cached_at'  => date('Y-m-d H:i:s'),
                'data'       => $data,
            ]),
            LOCK_EX
        );
    }

    // ─── API ────────────────────────────────────────────────────────────────────

    private function buildUrl(): string
    {
        return $this->endpoint . '?' . http_build_query([
            'place_id'     => $this->placeId,
            'fields'       => $this->config['fields'],
            'language'     => $this->config['language'],
            'reviews_sort' => $this->config['reviews_sort'],
            'key'          => $this->apiKey,
        ]);
    }

    private function fetchFromApi(string $url): ?array
    {
        $ctx = stream_context_create(['http' => [
            'timeout'       => 5,
            'ignore_errors' => true,
        ]]);

        $raw = @file_get_contents($url, false, $ctx);

        return $raw !== false ? json_decode($raw, true) : null;
    }

    private function parseReviews(array $raw): array
    {
        $min    = (int) $this->config['min_rating'];
        $max    = (int) $this->config['max_reviews'];
        $parsed = [];

        foreach ($raw as $review) {
            $rating = (int) ($review['rating'] ?? 0);

            if ($min > 0 && $rating < $min) {
                continue;
            }

            $parsed[] = [
                'author'    => $review['author_name'] ?? 'Anónimo',
                'avatar'    => $review['profile_photo_url'] ?? '',
                'rating'    => $rating,
                'text'      => $review['text'] ?? '',
                'time_ago'  => $review['relative_time_description'] ?? '',
                'timestamp' => (int) ($review['time'] ?? 0),
            ];

            if (count($parsed) >= $max) {
                break;
            }
        }

        return $parsed;
    }

    private function emptyResult(string $error): array
    {
        return [
            'success'       => false,
            'error'         => $error,
            'rating'        => 0,
            'total_ratings' => 0,
            'reviews'       => [],
        ];
    }
}