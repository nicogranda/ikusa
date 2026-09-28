<?php
declare(strict_types=1);

namespace App\Domains\Components;

use mysqli;
use InvalidArgumentException;

final class ComponentController
{
    private ComponentModel $model;

    public function __construct(mysqli $db)
    {
        $this->model = new ComponentModel($db);
    }

    public function render(string $name, string $language = 'es'): void
    {
        if (!preg_match('/^[a-z][a-z0-9_-]{0,79}$/', $name)) {
            throw new InvalidArgumentException('Nombre de grupo inválido.');
        }
        if (!preg_match('/^[a-z]{2}$/', $language)) {
            throw new InvalidArgumentException('Idioma inválido.');
        }
        $items = $this->model->findByNameAndLanguage($name, $language);
        if (!$items) {
            return;
        }
        require __DIR__ . '/Views/Show.php';
    }
}
