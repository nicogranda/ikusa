<?php
namespace App\Domains\About;

final class AboutController
{
    public function show(?array $components = null): void
    {
        $about = (new AboutModel())->content();
        $components ??= ['About/Hero.php', 'About/FeatureGrid.php', 'About/Team.php', 'About/Places.php', 'About/CTA.php'];
        include __DIR__ . '/Views/Show.php';
    }
}
