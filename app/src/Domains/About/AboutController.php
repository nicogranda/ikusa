<?php
declare(strict_types=1);

namespace App\Domains\About;

require_once __DIR__ . '/../Components/ComponentModel.php';

use App\Domains\Components\ComponentModel;
use mysqli;
use InvalidArgumentException;

final class AboutController
{
    private ComponentModel $model;

    public function __construct(mysqli $db)
    {
        $this->model = new ComponentModel($db);
    }

    public function render(string $section, string $language): void
    {
        $views = [
            'about-features' => 'FeatureGrid.php',
            'about-places' => 'Places.php',
            'about-cta' => 'CTA.php',
        ];
        if (!isset($views[$section])) {
            throw new InvalidArgumentException('Sección de About no válida.');
        }
        $items = $this->model->findByNameAndLanguage($section, $language);
        if ($items === []) {
            return;
        }
        $heading = null;
        $cards = [];
        foreach ($items as $item) {
            if ($item['type'] === 'heading') {
                $heading = $item;
            } else {
                $cards[] = $item;
            }
        }
        $escape = static fn ($value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $imageUrl = static function ($image): string {
            $image = (string) ($image ?? '');
            if (!preg_match('~^(?:assets/)?img/[a-zA-Z0-9_./-]+\.(?:png|jpe?g|webp|avif)$~i', $image) || str_contains($image, '..')) {
                return '';
            }
            return function_exists('asset_url') ? asset_url($image) : '/assets/' . preg_replace('~^assets/~', '', $image);
        };
        require __DIR__ . '/Views/' . $views[$section];
    }
}
