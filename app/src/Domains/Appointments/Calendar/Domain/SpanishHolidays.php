<?php
namespace App\Domains\Appointments\Calendar\Domain;
final class SpanishHolidays
{
    // Festividades nacionales en su fecha propia; no incluye sustituciones autonómicas/locales.
    public static function forYear(int $year): array
    {
        $fixed = ['01-01'=>'Año Nuevo','01-06'=>'Reyes','05-01'=>'Fiesta del Trabajo','08-15'=>'Asunción','10-12'=>'Fiesta Nacional de España','11-01'=>'Todos los Santos','12-06'=>'Día de la Constitución','12-08'=>'Inmaculada Concepción','12-25'=>'Navidad'];
        $days = [];
        foreach ($fixed as $date=>$name) $days[$year.'-'.$date] = $name;
        // Computus gregoriano, independiente de extensiones PHP y del huso horario.
        $a=$year%19; $b=intdiv($year,100); $c=$year%100; $d=intdiv($b,4); $e=$b%4;
        $f=intdiv($b+8,25); $g=intdiv($b-$f+1,3); $h=(19*$a+$b-$d-$g+15)%30;
        $i=intdiv($c,4); $k=$c%4; $l=(32+2*$e+2*$i-$h-$k)%7; $m=intdiv($a+11*$h+22*$l,451);
        $month=intdiv($h+$l-7*$m+114,31); $day=($h+$l-7*$m+114)%31+1;
        $easter = new \DateTimeImmutable(sprintf('%04d-%02d-%02d',$year,$month,$day),new \DateTimeZone('Europe/Madrid'));
        $days[$easter->modify('-2 days')->format('Y-m-d')] = 'Viernes Santo';
        ksort($days);
        return $days;
    }
    public static function name(\DateTimeImmutable $date): ?string { return self::forYear((int)$date->format('Y'))[$date->format('Y-m-d')] ?? null; }
}
