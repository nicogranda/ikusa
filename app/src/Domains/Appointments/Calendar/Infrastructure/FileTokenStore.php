<?php
namespace App\Domains\Appointments\Calendar\Infrastructure;
use App\Domains\Appointments\Calendar\Domain\TokenStore;
final class FileTokenStore implements TokenStore
{
    public function __construct(private string $path) {}
    public function read(): array
    {
        if (!is_file($this->path)) return [];
        $data = json_decode(file_get_contents($this->path), true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($data)) throw new \RuntimeException('Almacén de tokens inválido.');
        return $data;
    }
    public function write(array $token): void
    {
        $directory = dirname($this->path);
        if (!is_dir($directory) && !mkdir($directory, 0700, true)) throw new \RuntimeException('No se pudo crear el almacén de tokens.');
        $temporary = tempnam($directory, 'token-');
        if ($temporary === false) throw new \RuntimeException('No se pudo guardar la conexión.');
        try {
            chmod($temporary, 0600);
            if (file_put_contents($temporary, json_encode($token, JSON_THROW_ON_ERROR), LOCK_EX) === false || !rename($temporary, $this->path)) {
                throw new \RuntimeException('No se pudo guardar la conexión.');
            }
        } finally { if (is_file($temporary)) unlink($temporary); }
    }
    public function lock(): mixed
    {
        $directory = dirname($this->path);
        if (!is_dir($directory) && !mkdir($directory, 0700, true)) throw new \RuntimeException('No se pudo crear el almacén.');
        $handle = fopen($this->path . '.lock', 'c');
        if (!$handle || !flock($handle, LOCK_EX)) throw new \RuntimeException('No se pudo bloquear la conexión.');
        chmod($this->path . '.lock', 0600);
        return $handle;
    }
}
