<?php
namespace App\Domains\Appointments\Calendar\Domain;
interface EventRepository
{
    public function list(string $from, string $to): array;
    public function get(string $id): array;
    public function create(array $payload): array;
    public function update(string $id, array $payload): array;
    public function delete(string $id): void;
}
