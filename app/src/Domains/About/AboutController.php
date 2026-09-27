<?php
namespace App\Domains\About;

final class AboutController
{
    public function show(): void
    {
        $about = (new AboutModel())->content();
        include __DIR__ . '/Views/Show.php';
    }
}
