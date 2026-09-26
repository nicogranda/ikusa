<?php

namespace App\Domains\Services;

class ServicesController
{
    private string $viewsPath;

    public function __construct()
    {
        $this->viewsPath = dirname(__DIR__, 3) . '/views/services/';
    }

    public function index(): void
    {
        $this->notFound();
    }

    public function show(string $slug): void
    {
        $views = [
            'diseno-grafico'    => 'diseno_grafico.php',
            'desarrollo-web'    => 'desarrollo_web.php',
            'marketing-digital' => 'marketing_digital.php',
        ];

        $file = $views[$slug] ?? null;

        if ($file === null || !is_file($this->viewsPath . $file)) {
            $this->notFound();
            return;
        }

        include $this->viewsPath . $file;
    }

    private function notFound(): void
    {
        http_response_code(404);
        include dirname(__DIR__, 3) . '/views/404.php';
    }
}
