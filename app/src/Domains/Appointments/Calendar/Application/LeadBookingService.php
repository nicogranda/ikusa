<?php
namespace App\Domains\Appointments\Calendar\Application;
use App\Domains\Appointments\Calendar\Domain\BookingSchedule;
use App\Domains\Appointments\Calendar\Domain\Event;
use App\Domains\Appointments\Calendar\Domain\EventRepository;
final class LeadBookingService
{
    public const SERVICES = ['web'=>'Diseño y desarrollo web','design'=>'Diseño gráfico','marketing'=>'Marketing digital','other'=>'Otro / Quiero orientación'];
    public function __construct(private EventRepository $events) {}
    public function availability(string $value): array
    {
        $date = BookingSchedule::date($value);
        return BookingSchedule::available($date, $this->events->list($date->format(DATE_RFC3339),$date->modify('+1 day')->format(DATE_RFC3339)));
    }
    public function book(array $input, string $requestId): array
    {
        foreach (['name','phone','email','service','appointment_date','appointment_time'] as $key) {
            if (!is_string($input[$key] ?? null) || strlen($input[$key]) > 500) throw new \InvalidArgumentException('Revisa los datos de contacto y el horario.');
        }
        $name = trim($input['name']); $phone = trim($input['phone']); $email = trim($input['email']);
        if (mb_strlen($name) < 3 || strlen(preg_replace('/\D/','',$phone)) < 9 || !filter_var($email,FILTER_VALIDATE_EMAIL) || !isset(self::SERVICES[$input['service']]) || ($input['privacy'] ?? '') !== '1') throw new \InvalidArgumentException('Revisa tus datos y acepta la política de privacidad.');
        if (!in_array($input['appointment_time'],self::hours(),true)) throw new \InvalidArgumentException('Selecciona una hora válida.');
        $date = BookingSchedule::date($input['appointment_date']);
        if (!in_array($input['appointment_time'],$this->availability($input['appointment_date']),true)) throw new \DomainException('La fecha y la hora que elegiste ya no están disponibles. Selecciona otro horario.');
        $start = $date->setTime((int)substr($input['appointment_time'],0,2),(int)substr($input['appointment_time'],3,2));
        $payload = Event::payload(['summary'=>'Reunión Ikusa · '.$name, 'description'=>"Lead de Ikusa\nServicio: ".self::SERVICES[$input['service']]."\nNombre: $name\nTeléfono: $phone\nCorreo: $email\nPrivacidad: aceptada", 'start'=>$start->format('Y-m-d\TH:i'), 'end'=>$start->modify('+30 minutes')->format('Y-m-d\TH:i')]);
        $payload['id'] = hash('sha256',$requestId);
        $payload['extendedProperties'] = ['private'=>['ikusa_source'=>'lead_booking']];
        $event = $this->events->create($payload);
        if (empty($event['id'])) throw new \RuntimeException('No se pudo confirmar la cita.');
        return ['created'=>true,'date'=>$input['appointment_date'],'time'=>$input['appointment_time']];
    }
    private static function hours(): array { return BookingSchedule::HOURS; }
}
