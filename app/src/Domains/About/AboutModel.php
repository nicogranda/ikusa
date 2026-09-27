<?php
namespace App\Domains\About;

final class AboutModel
{
    public function content(): array
    {
        return require __DIR__ . '/aboutData.php';
    }
}
