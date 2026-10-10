<?php
namespace App\Domains\Appointments\Calendar\Domain;
interface TokenStore
{
    public function read(): array;
    public function write(array $token): void;
}
