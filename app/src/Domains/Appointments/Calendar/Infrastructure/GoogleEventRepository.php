<?php
namespace App\Domains\Appointments\Calendar\Infrastructure;
use App\Domains\Appointments\Calendar\Domain\EventRepository;
final class GoogleEventRepository implements EventRepository
{
    private \Google\Service\Calendar $service;
    private string $calendarId;
    public function __construct(?\Google\Service\Calendar $service = null)
    {
        $this->service = $service ?? new \Google\Service\Calendar((new GoogleConnection())->authorizedClient());
        $this->calendarId = trim($_ENV['GOOGLE_CALENDAR_ID'] ?? '') ?: 'primary';
    }
    public function list(string $from, string $to): array
    {
        $items = [];
        $options = ['timeMin' => $from, 'timeMax' => $to, 'singleEvents' => true, 'orderBy' => 'startTime', 'maxResults' => 250, 'showDeleted' => false];
        do {
            $page = $this->service->events->listEvents($this->calendarId, $options);
            foreach ($page->getItems() as $event) $items[] = $event->toSimpleObject();
            $options['pageToken'] = $page->getNextPageToken();
        } while ($options['pageToken']);
        return json_decode(json_encode($items, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
    }
    public function get(string $id): array { return $this->array($this->service->events->get($this->calendarId, $this->id($id))); }
    public function create(array $payload): array { return $this->array($this->service->events->insert($this->calendarId, new \Google\Service\Calendar\Event($payload))); }
    public function update(string $id, array $payload): array { return $this->array($this->service->events->patch($this->calendarId, $this->id($id), new \Google\Service\Calendar\Event($payload))); }
    public function delete(string $id): void { $this->service->events->delete($this->calendarId, $this->id($id)); }
    private function id(string $id): string
    {
        if ($id === '' || strlen($id) > 1024 || !preg_match('/^[a-zA-Z0-9_-]+$/D', $id)) throw new \InvalidArgumentException('ID de evento inválido.');
        return $id;
    }
    private function array(\Google\Service\Calendar\Event $event): array { return json_decode(json_encode($event->toSimpleObject(), JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR); }
}
