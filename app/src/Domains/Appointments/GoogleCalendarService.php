<?php

namespace App\Domains\Appointments;

class GoogleCalendarService
{
    private \Google_Service_Calendar $service;
    private string $calendarId;
    private \DateTimeZone $timezone;

    public function __construct()
    {
        require_once __DIR__ . '/Calendar/bootstrap.php';
        $this->calendarId = trim($_ENV['GOOGLE_CALENDAR_ID'] ?? '') ?: 'primary';
        $this->timezone = new \DateTimeZone('Europe/Madrid');
        $client = (new \App\Domains\Appointments\Calendar\Infrastructure\GoogleConnection())->authorizedClient();
        $this->service = new \Google_Service_Calendar($client);
    }

    public function isAvailable(
        string $date,
        string $startTime,
        string $endTime
    ): bool {
        [$start, $end] = $this->getDateRange(
            $date,
            $startTime,
            $endTime
        );

        $events = $this->service->events->listEvents(
            $this->calendarId,
            [
                'timeMin' => $start->format(\DateTimeInterface::RFC3339),
                'timeMax' => $end->format(\DateTimeInterface::RFC3339),
                'singleEvents' => true,
                'maxResults' => 250,
                'showDeleted' => false
            ]
        );

        foreach ($events->getItems() as $event) {
            if ($event->getStatus() === 'cancelled') {
                continue;
            }

            if ($event->getTransparency() === 'transparent') {
                continue;
            }

            return false;
        }

        return true;
    }

    public function createEvent(
        string $date,
        string $startTime,
        string $endTime,
        string $summary,
        string $description = ''
    ): string {
        [$start, $end] = $this->getDateRange(
            $date,
            $startTime,
            $endTime
        );

        if (!$this->isAvailable($date, $startTime, $endTime)) {
            throw new \RuntimeException(
                'El horario ya está ocupado en Google Calendar.'
            );
        }

        $event = new \Google_Service_Calendar_Event([
            'summary' => $summary,
            'description' => $description,
            'start' => [
                'dateTime' => $start->format(\DateTimeInterface::RFC3339),
                'timeZone' => 'Europe/Madrid'
            ],
            'end' => [
                'dateTime' => $end->format(\DateTimeInterface::RFC3339),
                'timeZone' => 'Europe/Madrid'
            ]
        ]);

        $createdEvent = $this->service->events->insert(
            $this->calendarId,
            $event
        );

        $eventId = (string) $createdEvent->getId();

        if ($eventId === '') {
            throw new \RuntimeException(
                'Google Calendar no devolvió el ID del evento.'
            );
        }

        return $eventId;
    }

    public function listEvents(string $from, string $to): array
    {
        return (new \App\Domains\Appointments\Calendar\Application\CalendarService(
            new \App\Domains\Appointments\Calendar\Infrastructure\GoogleEventRepository($this->service)
        ))->list($from, $to);
    }

    public function updateEvent(string $eventId, string $date, string $startTime, string $endTime, string $summary, string $description = ''): void
    {
        [$start, $end] = $this->getDateRange($date, $startTime, $endTime);
        (new \App\Domains\Appointments\Calendar\Application\CalendarService(
            new \App\Domains\Appointments\Calendar\Infrastructure\GoogleEventRepository($this->service)
        ))->update($eventId, [
            'summary' => $summary, 'description' => $description,
            'start' => $start->format('Y-m-d\\TH:i'), 'end' => $end->format('Y-m-d\\TH:i')
        ]);
    }

    public function deleteEvent(string $eventId): void
    {
        if (trim($eventId) === '') {
            throw new \InvalidArgumentException(
                'El ID del evento está vacío.'
            );
        }

        $this->service->events->delete(
            $this->calendarId,
            $eventId
        );
    }

    private function getDateRange(
        string $date,
        string $startTime,
        string $endTime
    ): array {
        $start = \DateTimeImmutable::createFromFormat(
            '!Y-m-d H:i:s',
            $date . ' ' . $this->normalizeTime($startTime),
            $this->timezone
        );

        $end = \DateTimeImmutable::createFromFormat(
            '!Y-m-d H:i:s',
            $date . ' ' . $this->normalizeTime($endTime),
            $this->timezone
        );

        if (!$start || !$end || $start->format('Y-m-d H:i:s') !== $date . ' ' . $this->normalizeTime($startTime) || $end->format('Y-m-d H:i:s') !== $date . ' ' . $this->normalizeTime($endTime) || $end <= $start) {
            throw new \InvalidArgumentException(
                'La fecha o el horario de la cita no son válidos.'
            );
        }

        return [$start, $end];
    }

    private function normalizeTime(string $time): string
    {
        return strlen($time) === 5 ? $time . ':00' : $time;
    }
}
