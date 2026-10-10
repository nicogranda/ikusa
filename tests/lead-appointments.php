<?php
require dirname(__DIR__).'/vendor/autoload.php';
require dirname(__DIR__).'/app/src/Domains/Appointments/Calendar/bootstrap.php';
use App\Domains\Appointments\Calendar\Domain\BookingSchedule;
use App\Domains\Appointments\Calendar\Domain\EventRepository;
use App\Domains\Appointments\Calendar\Application\LeadBookingService;
function verify(bool $ok,string $message):void { if (!$ok) throw new RuntimeException($message); }
$day = new DateTimeImmutable(BookingSchedule::minimumDate(),new DateTimeZone('Europe/Madrid'));
$event = fn($start,$end,$extra=[])=>array_replace(['start'=>['dateTime'=>$day->format('Y-m-d').'T'.$start.':00+02:00'],'end'=>['dateTime'=>$day->format('Y-m-d').'T'.$end.':00+02:00']],$extra);
$free = BookingSchedule::available($day,[$event('15:15','15:45')]);
verify(!in_array('15:00',$free) && !in_array('15:30',$free) && in_array('16:00',$free),'Partial overlaps');
verify(in_array('15:30',BookingSchedule::available($day,[$event('15:00','15:30')])),'End boundary free');
$allDay=['start'=>['date'=>$day->format('Y-m-d')],'end'=>['date'=>$day->modify('+1 day')->format('Y-m-d')]];
verify(BookingSchedule::available($day,[$allDay])===[],'Full day unavailable');
verify(count(BookingSchedule::available($day,[$event('09:00','19:00')]))===0,'All slots booked');
verify(count(BookingSchedule::available($day,[$event('09:00','19:00',['transparency'=>'transparent']),$event('09:00','19:00',['status'=>'cancelled'])]))===count(BookingSchedule::HOURS),'Ignore free/cancelled events');
$repo=new class implements EventRepository {
 public array $events=[]; public array $created=[];
 public function list(string $from,string $to):array { return $this->events; }
 public function get(string $id):array { return []; }
 public function create(array $payload):array { $this->created[]=$payload; return ['id'=>$payload['id']]; }
 public function update(string $id,array $payload):array { return []; }
 public function delete(string $id):void {}
};
$service=new LeadBookingService($repo);
$data=['name'=>'Lead Test','phone'=>'+34 612345678','email'=>'lead@example.com','service'=>'web','privacy'=>'1','appointment_date'=>$day->format('Y-m-d'),'appointment_time'=>'15:00'];
verify($service->book($data,'request-one')['created'],'Create lead booking');
verify(str_contains($repo->created[0]['description'],'lead@example.com') && str_contains($repo->created[0]['description'],'Diseño y desarrollo web'),'Lead data saved in event');
verify($repo->created[0]['id']===hash('sha256','request-one'),'Stable id prevents duplicate events');
$repo->events=[$allDay];
try { $service->book($data,'request-two'); throw new RuntimeException('Occupied slot was booked'); } catch (DomainException $e) {}
verify(count($repo->created)===1,'Recheck before insertion blocks occupied slot');
$data['privacy']='';
try { $service->book($data,'request-three'); throw new RuntimeException('Privacy was not validated'); } catch (InvalidArgumentException $e) {}
$saturday = $day;
while ($saturday->format('N') !== '6') $saturday=$saturday->modify('+1 day');
verify(BookingSchedule::available($saturday,[])===[],'Saturday blocked');
verify(BookingSchedule::available($saturday->modify('+1 day'),[])===[],'Sunday blocked');
try { BookingSchedule::date($saturday->format('Y-m-d')); throw new RuntimeException('Weekend accepted'); } catch (InvalidArgumentException $e) {}
verify(App\Domains\Appointments\Calendar\Domain\SpanishHolidays::forYear(2026)['2026-04-03']==='Viernes Santo','2026 Good Friday');
verify(App\Domains\Appointments\Calendar\Domain\SpanishHolidays::forYear(2027)['2027-03-26']==='Viernes Santo','2027 Good Friday');
verify(!BookingSchedule::isWorkingDay(new DateTimeImmutable('2026-12-25')),'Christmas closed');
verify(BookingSchedule::minimumDate(new DateTimeImmutable('2026-10-09',new DateTimeZone('Europe/Madrid')))==='2026-10-14','Lead time skips weekend and national holiday');
verify(!in_array('09:00',BookingSchedule::HOURS) && !in_array('13:30',BookingSchedule::HOURS),'Ecommjuice mornings blocked');
$repo->events=[]; $data['privacy']='1'; $data['appointment_time']='09:30';
try { $service->book($data,'blocked-morning'); throw new RuntimeException('Morning booked'); } catch (InvalidArgumentException $e) {}
verify(count($repo->created)===1,'Blocked morning never inserted');
echo "OK: full days, partial overlaps, boundaries, transparent/cancelled events, lead creation, privacy and recheck before insertion\n";
