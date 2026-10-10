<?php
namespace App\Domains\Appointments\Calendar\Domain;
final class Event
{
    public static function payload(array $input): array
    {
        $summary = trim((string) ($input['summary'] ?? ''));
        if ($summary === '' || strlen($summary) > 500) throw new \InvalidArgumentException('Introduce un título de hasta 500 caracteres.');
        $zone = new \DateTimeZone('Europe/Madrid');
        $dates = [];
        foreach (['start', 'end'] as $key) {
            $value = $input[$key] ?? '';
            if (!is_string($value)) throw new \InvalidArgumentException('Fecha inválida.');
            $date = \DateTimeImmutable::createFromFormat('!Y-m-d\TH:i', $value, $zone);
            if (!$date || $date->format('Y-m-d\TH:i') !== $value) throw new \InvalidArgumentException('Fecha inválida.');
            $dates[$key] = $date;
        }
        if ($dates['end'] <= $dates['start']) throw new \InvalidArgumentException('El fin debe ser posterior al inicio.');
        return ['summary' => $summary, 'description' => (string) ($input['description'] ?? ''),
            'start' => ['dateTime' => $dates['start']->format(DATE_RFC3339), 'timeZone' => 'Europe/Madrid'],
            'end' => ['dateTime' => $dates['end']->format(DATE_RFC3339), 'timeZone' => 'Europe/Madrid']];
    }
}
