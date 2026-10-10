<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Hablemos | Ikusa</title></head><body>
<?php require __DIR__ . '/Show.php'; ?>
<style>.appointments__button,.appointments__hours{background:#F15A24;border:1px solid #F15A24;color:white}.appointments__button:disabled{opacity:.55;cursor:default}.availability__grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}.availability__hour,.availability__back{padding:12px;border:1px solid #ddd;background:white;cursor:pointer}.availability__header{text-align:center;margin-bottom:20px}.availability__back{margin-top:20px}.booking-dialog{position:fixed;inset:0;margin:auto;box-sizing:border-box;max-height:calc(100dvh - 32px);overflow:auto;width:min(420px,calc(100% - 40px));border:0;border-radius:8px;padding:24px;color:#333;font-family:inherit}.booking-dialog::backdrop{background:rgba(0,0,0,.55)}.booking-dialog button{padding:10px 18px;background:#F15A24;color:white;border:0;cursor:pointer}.booking-dialog h2{font-size:21px}
.booking-hours { padding: 28px 24px 24px; }
.booking-hours h2 { margin: 0 32px 8px 0; }
.booking-hours > p { color: #666; font-size: 13px; line-height: 1.6; margin: 0 0 20px; }
.booking-hours .availability__hour { background: #fff; color: #333; border: 1px solid #ddd; border-radius: 6px; padding: 13px 8px; font: inherit; }
.booking-hours .availability__hour:hover, .booking-hours .availability__hour:focus-visible, .booking-hours .availability__hour.is-selected { background: #fff2eb; color: #d74614; border-color: #F15A24; }
.booking-hours .booking-hours__close { position: absolute; top: 10px; right: 12px; background: transparent; color: #333; font-size: 26px; padding: 2px 8px; }
.booking-hours .availability__back { width: 100%; margin-top: 20px; border-radius: 6px; }
.appointments__field input:disabled, .appointments__field select:disabled { opacity: .8; background: #f5f5f5; color: #555; cursor: default; }
@media(max-width:380px) { .booking-hours { padding: 24px 16px 16px; } .booking-hours .availability__grid { grid-template-columns: repeat(2,1fr); } }

.appointments__date-picker { width:100%; min-height:40px; padding:10px 12px; text-align:left; border:1px solid #ddd; border-radius:3px; background:white; color:#333; font:inherit; cursor:pointer; }
.booking-hours .availability__hour.is-morning { background:#c2ee83; border-color:#96cd48; color:#264315; }
.booking-hours .availability__hour.is-morning:disabled { background:#c2ee83; border-color:#96cd48; color:#264315; opacity:1; cursor:not-allowed; text-decoration:line-through; }
.booking-hours .availability__hour.is-selected { outline:2px solid #333; outline-offset:2px; }
.booking-calendar__nav { display:flex; align-items:center; justify-content:space-between; gap:10px; margin-bottom:16px; }
.booking-calendar__nav h2 { margin:0; font-size:18px; text-transform:capitalize; }
.booking-calendar__nav button { padding:5px 12px; font-size:24px; }
.booking-calendar__grid { display:grid; grid-template-columns:repeat(7,minmax(0,1fr)); gap:5px; text-align:center; }
.booking-calendar__grid > span { padding:6px 0; font-weight:600; }
.booking-calendar .booking-calendar__day { background:#f5f5f5; color:#333; border:1px solid #ddd; border-radius:5px; padding:10px 0; }
.booking-calendar .booking-calendar__day:disabled { color:#aaa; background:#fafafa; cursor:default; }
.booking-calendar .booking-calendar__day.is-holiday { background:#ffe27a; border-color:#e3c143; color:#705600; }
.booking-calendar .booking-calendar__day.is-selected { outline:2px solid #F15A24; }
.booking-calendar__legend { font-size:12px; color:#666; line-height:1.5; }
</style>
</body></html>
