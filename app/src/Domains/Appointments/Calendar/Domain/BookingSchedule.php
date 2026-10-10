<?php
namespace App\Domains\Appointments\Calendar\Domain;
final class BookingSchedule
{
    public const BLOCKED_MORNINGS = ['09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30'];
    public const HOURS = ['15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30'];
    public static function minimumDate(?\DateTimeImmutable $now = null): string
    {
        $day = ($now ?? new \DateTimeImmutable('now', new \DateTimeZone('Europe/Madrid')))->setTime(0,0);
        while (!self::isWorkingDay($day)) $day = $day->modify('+1 day');
        for ($added = 0; $added < 2;) { $day = $day->modify('+1 day'); if (self::isWorkingDay($day)) $added++; }
        return $day->format('Y-m-d');
    }
    public static function date(string $value): \DateTimeImmutable
    {
        $date = \DateTimeImmutable::createFromFormat('!Y-m-d', $value, new \DateTimeZone('Europe/Madrid'));
        if (!$date || $date->format('Y-m-d') !== $value || $value < self::minimumDate() || $date > new \DateTimeImmutable('+1 year', new \DateTimeZone('Europe/Madrid'))) throw new \InvalidArgumentException('Selecciona una fecha válida con al menos dos días laborables de antelación.');
        if (!self::isWorkingDay($date)) throw new \InvalidArgumentException('Las citas solo están disponibles de lunes a viernes, excepto festivos nacionales.');
        return $date;
    }
    public static function isWorkingDay(\DateTimeImmutable $date): bool
    {
        return (int)$date->format('N') <= 5 && SpanishHolidays::name($date) === null;
    }
    public static function available(\DateTimeImmutable $date, array $events): array
    {
        if (!self::isWorkingDay($date)) return [];
        $free = [];
        foreach (self::HOURS as $hour) {
            $start = $date->setTime((int)substr($hour,0,2),(int)substr($hour,3,2));
            $end = $start->modify('+30 minutes');
            $busy = false;
            foreach ($events as $event) {
                if (($event['status'] ?? '') === 'cancelled' || ($event['transparency'] ?? '') === 'transparent') continue;
                $a = $event['start']['dateTime'] ?? $event['start']['date'] ?? null;
                $b = $event['end']['dateTime'] ?? $event['end']['date'] ?? null;
                if (!$a || !$b) throw new \RuntimeException('No se pudo verificar la disponibilidad.');
                $zone = new \DateTimeZone('Europe/Madrid');
                if (new \DateTimeImmutable($a,$zone) < $end && new \DateTimeImmutable($b,$zone) > $start) { $busy = true; break; }
            }
            if (!$busy) $free[] = $hour;
        }
        return $free;
    }
}
