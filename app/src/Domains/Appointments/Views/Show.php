
<?php
/**
 * AVALON ESTETIC
 * Appointments/Views/Show.php
 */

$lang = $lang ?? $language ?? 'es';
$appUrl = $appUrl ?? rtrim($_ENV['APP_URL'] ?? '', '/');
$localPreview = $localPreview ?? false;
$treatments = $treatments ?? [];
$selectedTreatment = $selectedTreatment ?? null;
$errors = $errors ?? [];
$success = $success ?? false;

$holidayDates = [];
if ($localPreview) {
    require_once __DIR__ . '/../Calendar/bootstrap.php';
    $calendarToday = new DateTimeImmutable('today', new DateTimeZone('Europe/Madrid'));
    foreach ([(int)$calendarToday->format('Y'), (int)$calendarToday->format('Y') + 1] as $year) {
        $holidayDates += \App\Domains\Appointments\Calendar\Domain\SpanishHolidays::forYear($year);
    }
}
$selectedName = '';
foreach ($treatments as $treatment) {
    if ((int) $treatment['id'] === (int) $selectedTreatment) {
        $selectedName = $treatment['name'] ?? $treatment['title'] ?? '';
        break;
    }
}

$e = static fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$appointmentCss = __DIR__ . '/../assets/css/appointment.css';
if (is_file($appointmentCss)) echo '<style>' . file_get_contents($appointmentCss) . '</style>';
?>

<style>
.appointments { padding: 16px 20px; }
.appointments__container { max-width: 650px; }
.appointments__treatment { margin: 0 0 16px; text-align: center; color: #333; font-size: 20px; font-weight: 600; line-height: 1.3; }
.appointments__form { gap: 12px; }
.appointments__field { gap: 5px; }
.appointments__field input { padding: 10px 12px; }
.appointments__field input[readonly] { background: #f8f8f8; cursor: default; }
.appointments__date-row { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 12px; align-items: end; }
.appointments__time-display { display: flex; align-items: center; min-height: 40px; padding: 10px 12px; border: 1px solid #ddd; border-radius: 3px; font-size: 13px; }
.appointments__time-display.is-empty { color: #999; }
.appointments__hours { padding: 9px 12px; border: 1px solid #8f734a; border-radius: 3px; background: #fff; color: #8f734a; font: inherit; font-size: 12px; cursor: pointer; }
.appointments__hours:disabled { border-color: #ddd; color: #999; cursor: not-allowed; }
.appointments__error { display: block; min-height: 0; color: #a33; font-size: 11px; line-height: 1.4; }
.appointments__error:empty { display: none; }
.appointments__field.is-invalid input, .appointments__field.is-invalid .appointments__time-display { border-color: #a33; }
.appointments__privacy { margin-top: 2px; }
.appointments__submit { margin-top: 2px; }
.appointments__button { padding: 12px 16px; }
@media (max-width: 480px) {
    .appointments { padding: 14px 15px; }
    .appointments__treatment { font-size: 18px; }
    .appointments__date-row { gap: 8px; }
    .appointments__hours { width: 100%; }
}
</style>

<section class="appointments">
    <div class="appointments__container">

        <?php if ($success): ?>
            <div class="appointments__success" role="status">
                <h2>Solicitud recibida</h2>
                <p>Hemos recibido tu solicitud de cita. Nos pondremos en contacto contigo para confirmarla.</p>
            </div>
        <?php else: ?>

            <h1 class="appointments__treatment"><?= $e($localPreview ? 'Hablemos de tu proyecto' : ($selectedName ?: 'Solicitar cita')) ?></h1>

            <form id="appointment-form" class="appointments__form" action="<?= $e($localPreview ? $appointmentEndpoint : $appUrl . '/' . $lang . '/citas/solicitar') ?>" method="POST" novalidate>
                <?php if ($localPreview): ?>
                <div class="appointments__field" data-field="service">
                    <label for="appointment-treatment">Servicio de interés</label>
                    <select id="appointment-treatment" name="service">
                        <option value="">Selecciona un servicio</option>
                        <option value="web">Diseño y desarrollo web</option>
                        <option value="design">Diseño gráfico</option>
                        <option value="marketing">Marketing digital</option>
                        <option value="other">Otro / Quiero orientación</option>
                    </select>
                    <span class="appointments__error" data-error="service"></span>
                </div>
                <?php else: ?>
                <input type="hidden" id="appointment-treatment" name="treatment_id" value="<?= (int) $selectedTreatment ?>">
                <?php endif; ?>
                <?php if ($localPreview): ?>
                <input type="hidden" name="csrf" value="<?= $e($_SESSION['lead_booking_csrf']) ?>">
                <input type="hidden" name="request_id" value="<?= $e($_SESSION['lead_booking_request']) ?>">
                <input type="text" name="website_fake" tabindex="-1" autocomplete="off" aria-hidden="true" style="display:none">
                <?php endif ?>
                <input type="hidden" id="appointment-time" name="appointment_time" value="">

                <div class="appointments__field" data-field="phone">
                    <label for="appointment-phone">Teléfono</label>
                    <input type="tel" id="appointment-phone" name="phone" autocomplete="tel" inputmode="tel">
                    <span class="appointments__error" data-error="phone"></span>
                </div>

                <div class="appointments__field" data-field="name">
                    <label for="appointment-name">Nombre y apellidos</label>
                    <input type="text" id="appointment-name" name="name" autocomplete="name">
                    <span class="appointments__error" data-error="name"></span>
                </div>

                <div class="appointments__field" data-field="email">
                    <label for="appointment-email">Correo electrónico</label>
                    <input type="email" id="appointment-email" name="email" autocomplete="email">
                    <span class="appointments__error" data-error="email"></span>
                </div>

                <div class="appointments__date-row">
                    <div class="appointments__field" data-field="date">
                        <label for="appointment-date">Fecha</label>
                        <input type="date" id="appointment-date" name="appointment_date" min="<?= $e((new DateTimeImmutable('today', new DateTimeZone('Europe/Madrid')))->format('Y-m-d')) ?>">
                        <?php if ($localPreview): ?><button type="button" id="appointment-open-calendar" class="appointments__date-picker" aria-haspopup="dialog">Elegir fecha</button><?php endif ?>
                        <span class="appointments__error" data-error="date"></span>
                    </div>

                    <div class="appointments__field" data-field="time">
                        <label>Hora</label>
                        <div id="appointment-time-display" class="appointments__time-display is-empty" aria-live="polite">Sin seleccionar</div>
                        <span class="appointments__error" data-error="time"></span>
                    </div>
                </div>

                <button type="button" id="appointment-open-hours" class="appointments__hours" disabled>Ver horarios disponibles</button>

                <div class="appointments__privacy" data-field="privacy">
                    <label>
                        <input type="checkbox" id="appointment-privacy" name="privacy" value="1">
                        <span>He leído y acepto la <a href="<?= $e($localPreview ? preg_replace('~/public_html/appointment\.php$~', '', $appointmentEndpoint) . '/es/legal/politica-de-proteccion-de-datos' : $appUrl . '/' . $lang . '/legal/politica-de-privacidad') ?>" target="_blank" rel="noopener noreferrer">política de privacidad</a>.</span>
                    </label>
                    <span class="appointments__error" data-error="privacy"></span>
                </div>

                <?php if ($errors): ?>
                    <div class="appointments__errors" role="alert">
                        <?php foreach ($errors as $error): ?><p><?= $e($error) ?></p><?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="appointments__submit">
                    <button type="submit" class="appointments__button" >Solicitar cita</button>
                    <?php if ($localPreview): ?><p>Reunión de 30 minutos · Horario de Madrid.</p><?php endif; ?>
                </div>
            </form>

        <?php endif; ?>

    </div>
</section>


<dialog id="booking-message" class="booking-dialog" aria-labelledby="booking-message-title"><h2 id="booking-message-title"></h2><p id="booking-message-text"></p><button type="button">Elegir otro horario</button></dialog>
<script>
(() => {
    const form = document.getElementById('appointment-form');
    if (!form) return;

    const treatment = document.getElementById('appointment-treatment');
    const phone = document.getElementById('appointment-phone');
    const name = document.getElementById('appointment-name');
    const email = document.getElementById('appointment-email');
    const date = document.getElementById('appointment-date');
    const time = document.getElementById('appointment-time');
    const timeDisplay = document.getElementById('appointment-time-display');
    const openHours = document.getElementById('appointment-open-hours');
    const privacy = document.getElementById('appointment-privacy');
    const isLeadForm = <?= json_encode($localPreview) ?>;
    const messageDialog = document.getElementById('booking-message');
    function showMessage(title, message, button = 'Elegir otro horario') {
        messageDialog.querySelector('h2').textContent = title;
        messageDialog.querySelector('p').textContent = message;
        messageDialog.querySelector('button').textContent = button;
        if (!messageDialog.open) messageDialog.showModal();
    }
    messageDialog.querySelector('button').addEventListener('click', () => messageDialog.close());
    let dateCheck = 0;
    let submitting = false;
    let submitted = false;
    async function getHours(selectedDate) {
        const url = baseUrl + '&fecha=' + encodeURIComponent(selectedDate);
        const response = await fetch(url, { credentials: 'same-origin', cache: 'no-store' });
        const data = await response.json();
        if (!response.ok) throw new Error(data.message || 'No podemos consultar los horarios ahora.');
        return data.hours;
    }
    function noHours() {
        clearTime();
        showMessage('No está disponible', 'No hay horas disponibles para la fecha que elegiste. Selecciona otro día.');
    }
    function displayHours(selectedDate, hours) {
        if (submitting || submitted) return;
        const panel = document.createElement('dialog');
        panel.id = 'appointment-availability-panel';
        panel.className = 'booking-dialog booking-hours';
        panel.setAttribute('aria-labelledby', 'booking-hours-title');
        const close = document.createElement('button'); close.type = 'button'; close.className = 'booking-hours__close'; close.setAttribute('aria-label', 'Cerrar horarios'); close.textContent = '×';
        close.addEventListener('click', () => panel.close()); panel.appendChild(close);
        const header = document.createElement('h2'); header.id = 'booking-hours-title'; header.textContent = 'Elige tu hora'; panel.appendChild(header);
        const subtitle = document.createElement('p');
        subtitle.textContent = parseDate(selectedDate).toLocaleDateString('es-ES', { weekday: 'long', day: 'numeric', month: 'long' }) + ' · Madrid · 30 minutos';
        panel.appendChild(subtitle);
        const legend = document.createElement('p'); legend.textContent = 'Verde manzana: ocupado · Ecommjuice · 09:00–14:00'; panel.appendChild(legend);
        const grid = document.createElement('div'); grid.className = 'availability__grid'; panel.appendChild(grid);
        const blockedMornings = <?= json_encode($localPreview ? \App\Domains\Appointments\Calendar\Domain\BookingSchedule::BLOCKED_MORNINGS : []) ?>;
        [...blockedMornings, ...hours].forEach(hour => {
            const button = document.createElement('button'); button.type = 'button'; button.className = 'availability__hour'; button.textContent = hour;
            const blocked = blockedMornings.includes(hour);
            button.classList.toggle('is-morning', blocked);
            button.disabled = blocked;
            if (blocked) { button.title = 'Ocupado · Ecommjuice'; button.setAttribute('aria-label', hour + ' · Ocupado · Ecommjuice'); }
            button.classList.toggle('is-selected', time.value === hour && date.value === selectedDate);
            button.addEventListener('click', () => {
                window.setAppointmentTime(selectedDate, hour);
                openHours.textContent = 'Cambiar horario';
                panel.close();
            });
            grid.appendChild(button);
        });
        const back = document.createElement('button'); back.type = 'button'; back.className = 'availability__back'; back.textContent = 'Volver al formulario'; panel.appendChild(back);
        back.addEventListener('click', () => panel.close());
        panel.addEventListener('close', () => { panel.remove(); openHours.focus(); }, { once: true });
        panel.addEventListener('click', event => {
            const rect = panel.getBoundingClientRect();
            if (event.target === panel && (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom)) panel.close();
        });
        document.body.appendChild(panel);
        panel.showModal();
    }

    const baseUrl = <?= json_encode($localPreview ? $appointmentEndpoint . '?availability=1' : $appUrl . '/' . $lang . '/citas/disponibilidad', JSON_UNESCAPED_SLASHES) ?>;
    const draftKey = <?= json_encode($localPreview ? 'ikusaAppointmentDraft' : 'avalonAppointmentDraft') ?>;
    const madridToday = <?= json_encode((new DateTimeImmutable('now', new DateTimeZone('Europe/Madrid')))->format('Y-m-d')) ?>;

    function parseDate(value) {
        const [year, month, day] = value.split('-').map(Number);
        return new Date(year, month - 1, day, 12);
    }

    function formatDate(value) {
        const year = value.getFullYear();
        const month = String(value.getMonth() + 1).padStart(2, '0');
        const day = String(value.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function addBusinessDays(start, days) {
        const result = parseDate(start);
        let added = 0;

        while (added < days) {
            result.setDate(result.getDate() + 1);
            if (result.getDay() !== 0 && result.getDay() !== 6) added++;
        }

        return formatDate(result);
    }

    function minimumAppointmentDate() {
        const today = parseDate(madridToday);
        const day = today.getDay();

        // Sábado y domingo toman el lunes como día de referencia.
        if (day === 6) today.setDate(today.getDate() + 2);
        if (day === 0) today.setDate(today.getDate() + 1);

        return addBusinessDays(formatDate(today), 2);
    }

    const holidays = <?= json_encode($holidayDates, JSON_UNESCAPED_UNICODE) ?>;
    const minimumDate = isLeadForm ? <?= json_encode($localPreview ? \App\Domains\Appointments\Calendar\Domain\BookingSchedule::minimumDate() : '') ?> : minimumAppointmentDate();
    const maximumDate = <?= json_encode((new DateTimeImmutable('today', new DateTimeZone('Europe/Madrid')))->modify('+1 year')->format('Y-m-d')) ?>;
    date.min = minimumDate;
    if (isLeadForm) date.max = maximumDate;
    function workingDate(value) {
        const day = parseDate(value).getDay();
        return day !== 0 && day !== 6 && !holidays[value];
    }
    if (isLeadForm) {
        date.type = 'hidden';
        const chooseDate = document.getElementById('appointment-open-calendar');
        function updateDateButton() { chooseDate.textContent = date.value ? parseDate(date.value).toLocaleDateString('es-ES') : 'Elegir fecha'; }
        date.addEventListener('change', updateDateButton);
        chooseDate.addEventListener('click', () => {
            if (submitted || submitting) return;
            const calendar = document.createElement('dialog');
            calendar.className = 'booking-dialog booking-calendar';
            calendar.setAttribute('aria-label', 'Elegir fecha de la reunión');
            let month = parseDate(date.value || minimumDate); month.setDate(1);
            function render() {
                calendar.replaceChildren();
                const nav = document.createElement('div'); nav.className = 'booking-calendar__nav';
                const heading = document.createElement('h2'); heading.textContent = month.toLocaleDateString('es-ES', {month:'long',year:'numeric'});
                [-1,1].forEach(direction => {
                    const button = document.createElement('button'); button.type = 'button'; button.textContent = direction < 0 ? '‹' : '›';
                    button.setAttribute('aria-label', direction < 0 ? 'Mes anterior' : 'Mes siguiente');
                    const nextMonth = new Date(month.getFullYear(),month.getMonth()+direction,1,12);
                    button.disabled = direction < 0 ? formatDate(nextMonth) < minimumDate.slice(0,7)+'-01' : formatDate(nextMonth) > maximumDate;
                    button.addEventListener('click', () => { month = nextMonth; render(); });
                    if (direction < 0) { nav.appendChild(button); nav.appendChild(heading); } else nav.appendChild(button);
                });
                calendar.appendChild(nav);
                const grid = document.createElement('div'); grid.className = 'booking-calendar__grid';
                ['L','M','X','J','V','S','D'].forEach(label => { const cell = document.createElement('span'); cell.textContent = label; grid.appendChild(cell); });
                for (let blank=0; blank<(month.getDay()+6)%7; blank++) grid.appendChild(document.createElement('span'));
                const days = new Date(month.getFullYear(),month.getMonth()+1,0).getDate();
                for (let day=1; day<=days; day++) {
                    const value = formatDate(new Date(month.getFullYear(),month.getMonth(),day,12));
                    const button = document.createElement('button'); button.type = 'button'; button.textContent = day;
                    button.className = 'booking-calendar__day';
                    button.disabled = value < minimumDate || value > maximumDate || !workingDate(value);
                    if (holidays[value]) { button.classList.add('is-holiday'); button.title = holidays[value]; }
                    button.setAttribute('aria-label', value + (holidays[value] ? ' · '+holidays[value] : !workingDate(value) ? ' · Fin de semana' : ''));
                    button.classList.toggle('is-selected', date.value === value);
                    button.addEventListener('click', () => { date.value=value; date.dispatchEvent(new Event('change')); calendar.close(); });
                    grid.appendChild(button);
                }
                calendar.appendChild(grid);
                const legend = document.createElement('p'); legend.className = 'booking-calendar__legend'; legend.textContent = 'Amarillo: festivo nacional · Fines de semana sin reservas'; calendar.appendChild(legend);
                const close = document.createElement('button'); close.type='button'; close.textContent='Volver al formulario'; close.addEventListener('click',()=>calendar.close()); calendar.appendChild(close);
            }
            calendar.addEventListener('close',()=> { calendar.remove(); chooseDate.focus(); },{once:true});
            document.body.appendChild(calendar); render(); calendar.showModal();
        });
        queueMicrotask(updateDateButton);
    }

    function error(field, message) {
        const wrapper = form.querySelector('[data-field="' + field + '"]');
        const messageBox = form.querySelector('[data-error="' + field + '"]');
        if (wrapper) wrapper.classList.toggle('is-invalid', Boolean(message));
        if (messageBox) messageBox.textContent = message;
    }

    function clearTime() {
        time.value = '';
        timeDisplay.textContent = 'Sin seleccionar';
        timeDisplay.classList.add('is-empty');
        error('time', '');
    }

    function validDate() {
        return Boolean(date.value && date.value >= minimumDate && (!isLeadForm || (date.value <= maximumDate && workingDate(date.value))));
    }

    function saveDraft() {
        sessionStorage.setItem(draftKey, JSON.stringify({
            treatment: treatment.value,
            phone: phone.value,
            name: name.value,
            email: email.value,
            date: date.value,
            time: time.value,
            privacy: privacy.checked
        }));
    }

    // Recupera el formulario después de seleccionar una hora.
    let draft = {};

    try {
        draft = JSON.parse(sessionStorage.getItem(draftKey) || '{}');
    } catch (_) {
        sessionStorage.removeItem(draftKey);
    }

    if ((isLeadForm && Array.from(treatment.options).some(option => option.value === draft.treatment)) || draft.treatment === treatment.value) {
        if (isLeadForm) treatment.value = draft.treatment;
        phone.value = draft.phone || '';
        name.value = draft.name || '';
        email.value = draft.email || '';
        privacy.checked = Boolean(draft.privacy);

        if (draft.date && draft.date >= minimumDate && (!isLeadForm || (draft.date <= maximumDate && workingDate(draft.date)))) {
            date.value = draft.date;

            if (/^\d{2}:\d{2}$/.test(draft.time || '') && (!isLeadForm || draft.time >= '15:00')) {
                time.value = draft.time;
                timeDisplay.textContent = draft.time;
                timeDisplay.classList.remove('is-empty');
            }
        }
    }

    openHours.disabled = !validDate() || !treatment.value;
    treatment.addEventListener('change', () => {
        clearTime();
        openHours.disabled = !validDate() || !treatment.value;
    });

    date.addEventListener('change', async () => {
        clearTime();
        openHours.disabled = !validDate() || !treatment.value;
        error('date', validDate() ? '' : 'Selecciona un día laborable, sin festivos, a partir del ' + minimumDate + '.');
        const current = ++dateCheck;
        if (isLeadForm && validDate()) {
            openHours.disabled = true;
            openHours.textContent = 'Consultando horarios…';
            try {
                const hours = await getHours(date.value);
                if (current !== dateCheck) return;
                if (!hours.length) noHours();
            } catch (err) {
                if (current === dateCheck) showMessage('No podemos consultar el calendario', err.message, 'Volver al formulario');
            } finally {
                if (current === dateCheck) { openHours.disabled = !validDate() || !treatment.value; openHours.textContent = 'Ver horarios disponibles'; }
            }
        }
    });

    // Conservamos esta función por compatibilidad con el componente anterior.
    window.setAppointmentTime = (selectedDate, selectedTime) => {
        if (submitting || submitted) return;
        if (selectedDate !== date.value || !/^\d{2}:\d{2}$/.test(selectedTime)) return;

        time.value = selectedTime;
        timeDisplay.textContent = selectedTime;
        timeDisplay.classList.remove('is-empty');
        error('time', '');
        saveDraft();
    };

   openHours.addEventListener('click', async () => {
    if (submitting || submitted) return;
    if (!validDate()) {
        error('date', 'Selecciona un día laborable, sin festivos, a partir del ' + minimumDate + '.');
        return;
    }

    if (!treatment.value) return;

    if (isLeadForm) {
        const selectedDate = date.value;
        openHours.disabled = true; openHours.textContent = 'Consultando horarios…';
        try {
            const hours = await getHours(selectedDate);
            if (date.value !== selectedDate) return;
            if (!hours.length) noHours(); else displayHours(selectedDate, hours);
        } catch (err) { showMessage('No podemos consultar el calendario', err.message, 'Volver al formulario'); }
        finally { openHours.disabled = !validDate() || !treatment.value; openHours.textContent = 'Ver horarios disponibles'; }
        return;
    }

    const url = baseUrl
        + (baseUrl.includes('?') ? '&' : '?') + 'fecha=' + encodeURIComponent(date.value)
        + '&tratamiento=' + encodeURIComponent(treatment.value);

    openHours.disabled = true;
    openHours.textContent = 'Consultando horarios…';

    try {
        const response = await fetch(url, { credentials: 'same-origin' });
        if (!response.ok) throw new Error('No se pudieron cargar los horarios.');

        const html = await response.text();
        const documentFromResponse = new DOMParser().parseFromString(html, 'text/html');
        const availability = documentFromResponse.querySelector('.availability');

        if (!availability) throw new Error('La respuesta no contiene la pantalla de horarios.');
        if (!availability.querySelector('.availability__hour:not(:disabled)')) { noHours(); openHours.disabled = false; openHours.textContent = 'Ver horarios disponibles'; return; }

        const panel = document.createElement('div');
        panel.id = 'appointment-availability-panel';
        panel.innerHTML = availability.outerHTML;

        form.hidden = true;
        document.querySelector('.appointments__treatment').hidden = true;
        form.parentElement.appendChild(panel);

        panel.querySelectorAll('.availability__hour:not(:disabled)').forEach(button => {
            button.addEventListener('click', () => {
                window.setAppointmentTime(date.value, button.dataset.hour);
                panel.remove();
                form.hidden = false;
                document.querySelector('.appointments__treatment').hidden = false;
                openHours.textContent = 'Cambiar horario';
                openHours.disabled = false;
            });
        });

        panel.querySelector('.availability__back')?.addEventListener('click', () => {
            panel.remove();
            form.hidden = false;
            document.querySelector('.appointments__treatment').hidden = false;
            openHours.textContent = 'Ver horarios disponibles';
            openHours.disabled = false;
        });

    } catch (err) {
        error('time', err.message);
        openHours.disabled = false;
        openHours.textContent = 'Ver horarios disponibles';
    }
});

    form.addEventListener('submit', async event => {
        if (isLeadForm) event.preventDefault();
        if (submitting || submitted) { event.preventDefault(); return; }
        let valid = Boolean(treatment.value);

        const checks = [
            ['phone', phone.value.trim().replace(/[^\d]/g, '').length >= 9, 'Introduce un teléfono válido.'],
            ['name', name.value.trim().length >= 3, 'Introduce tu nombre y apellidos.'],
            ['email', /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim()), 'Introduce un correo electrónico válido.'],
            ['date', validDate(), 'Selecciona un día laborable, sin festivos, a partir del ' + minimumDate + '.'],
            ['time', /^\d{2}:\d{2}$/.test(time.value), 'Selecciona una hora disponible.'],
            ['privacy', privacy.checked, 'Debes aceptar la política de privacidad.']
        ];

        checks.forEach(([field, passed, message]) => {
            error(field, passed ? '' : message);
            if (!passed) valid = false;
        });

        if (!valid) {
            event.preventDefault();
            form.querySelector('.is-invalid')?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            return;
        }

        saveDraft();
        if (!isLeadForm) return;
        submitting = true;
        const submitButton = form.querySelector('[type="submit"]');
        const payload = new FormData(form);
        const controls = Array.from(form.querySelectorAll('input, select, textarea, button'));
        const previousDisabled = controls.map(control => control.disabled);
        controls.forEach(control => { control.disabled = true; });
        form.setAttribute('aria-busy', 'true');
        submitButton.textContent = 'Reservando…';
        try {
            const response = await fetch(form.action, { method: 'POST', credentials: 'same-origin', body: payload });
            const data = await response.json();
            if (!response.ok) {
                if (data.unavailable) { clearTime(); showMessage('No está disponible', data.message); }
                else showMessage('No se pudo reservar la cita', data.message || 'Inténtalo de nuevo más tarde.', 'Volver al formulario');
                return;
            }
            sessionStorage.removeItem(draftKey);
            submitted = true;
            submitButton.textContent = 'Cita enviada';
            document.querySelector('.appointments__treatment').textContent = 'Cita registrada';
            const confirmation = document.createElement('p'); confirmation.setAttribute('role', 'status');
            confirmation.textContent = 'Hemos reservado tu reunión para el ' + data.date + ' a las ' + data.time + ' (hora de Madrid).';
            form.parentElement.appendChild(confirmation);
            const emailNotice = document.createElement('p');
            emailNotice.textContent = data.email_sent ? 'Te hemos enviado la confirmación por correo electrónico.' : 'Tu cita está registrada, pero no pudimos enviar el correo de confirmación. Si necesitas ayuda, contacta con Ikusa.';
            form.parentElement.appendChild(emailNotice);
        } catch (_) { showMessage('No se pudo confirmar la cita', 'Comprueba tu conexión e inténtalo de nuevo.', 'Volver al formulario'); }
        finally {
            submitting = false;
            form.removeAttribute('aria-busy');
            if (!submitted) {
                controls.forEach((control, index) => { control.disabled = previousDisabled[index]; });
                submitButton.textContent = 'Solicitar cita';
            }
        }
    });
})();
</script>
