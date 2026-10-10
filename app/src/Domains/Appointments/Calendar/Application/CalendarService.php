<?php
namespace App\Domains\Appointments\Calendar\Application;
use App\Domains\Appointments\Calendar\Domain\Event;
use App\Domains\Appointments\Calendar\Domain\EventRepository;
final class CalendarService
{
    public function __construct(private EventRepository $events) {}
    public function list(string $from, string $to): array
    {
        $zone = new \DateTimeZone('Europe/Madrid');
        $start = \DateTimeImmutable::createFromFormat('!Y-m-d', $from, $zone);
        $end = \DateTimeImmutable::createFromFormat('!Y-m-d', $to, $zone);
        if (!$start || !$end || $start->format('Y-m-d') !== $from || $end->format('Y-m-d') !== $to || $end <= $start || $start->diff($end)->days > 366) throw new \InvalidArgumentException('Selecciona un intervalo válido de hasta un año.');
        return $this->events->list($start->format(DATE_RFC3339), $end->format(DATE_RFC3339));
    }
    public function get(string $id): array { return $this->events->get($id); }
    public function create(array $input): array { return $this->events->create(Event::payload($input)); }
    public function update(string $id, array $input): array { return $this->events->update($id, Event::payload($input)); }
    public function delete(string $id): void { $this->events->delete($id); }
}
