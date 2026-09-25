<?php

namespace App\Domains\Services;

class ServicesController
{
    private string $lang;
    private string $viewsPath;
    private Service $serviceModel;

    public function __construct()
    {
        $this->lang       = $_GET['lang'] ?? 'es';
        $this->viewsPath  = __DIR__ . '/../../../views/services/';

        require_once __DIR__ . '/Service.php';
        $this->serviceModel = new Service($GLOBALS['db'], $this->lang);
    }

    public function index(): void
    {
        $services = $this->serviceModel->getAll();
        $lang     = $this->lang;
        include $this->viewsPath . 'index.php';
    }

    public function show(string $slug): void
    {
        $map = [
            'diseno-grafico'    => 'diseno_grafico',
            'desarrollo-web'    => 'desarrollo_web',
            'marketing-digital' => 'marketing_digital',
        ];

        $file = $map[$slug] ?? null;

        if (!$file || !file_exists($this->viewsPath . $file . '.php')) {
            $this->notFound();
            return;
        }

        $service         = $this->serviceModel->getBySlug($slug);
        $relatedServices = $this->serviceModel->getRelated($slug);
        $lang            = $this->lang;
        var_dump($service); die;

        include $this->viewsPath . $file . '.php';
    }

    private function notFound(): void
    {
        http_response_code(404);
        include __DIR__ . '/../../../views/404.php';
    }
}