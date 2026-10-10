<?php
namespace App\Domains\Appointments;

use App\Domains\Patients\Patient;
use App\Domains\Appointments\GoogleCalendarService;

class AppointmentController
{
    private \mysqli $db;
    private Appointment $appointmentModel;
    private Patient $patientModel;

    public function __construct(\mysqli $db)
    {
        $this->db = $db;
        $this->appointmentModel = new Appointment($db);
        $this->patientModel = new Patient($db);
    }

    /* =========================================================
       SHOW — FORMULARIO
    ========================================================= */

    public function show(string $lang = 'es'): void
    {
        $language = $lang;
        $selectedTreatment = filter_input(INPUT_GET, 'treatment_id', FILTER_VALIDATE_INT) ?: null;
        $errors = [];
        $success = false;

        // Mantiene disponible la variable que utiliza Show.php.
        // Sustituiremos esta consulta por el método público real
        // del dominio Treatments cuando lo tengamos identificado.
        $stmt = $this->db->prepare("
            SELECT t.id, tt.name
            FROM treatments t
            INNER JOIN treatment_translations tt ON tt.treatment_id = t.id
            WHERE tt.language = ?
            ORDER BY tt.name ASC
        ");
        $stmt->bind_param('s', $lang);
        $stmt->execute();
        $treatments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        require __DIR__ . '/Views/Show.php';
    }

    /* =========================================================
       AVAILABILITY — HORARIOS
    ========================================================= */

    public function availability(string $lang = 'es'): void
    {
        $language = $lang;
        $fecha = trim((string) ($_GET['fecha'] ?? ''));
        $tratamiento = filter_input(INPUT_GET, 'tratamiento', FILTER_VALIDATE_INT) ?: 0;

        require __DIR__ . '/Views/Components/Availability.php';
    }

    /* =========================================================
       CREATE — PACIENTE + CITA
    ========================================================= */


public function create(string $lang = 'es'): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        header('Allow: POST');
        exit('Método no permitido.');
    }

    $name = trim((string) ($_POST['name'] ?? ''));
    $phone = trim((string) ($_POST['phone'] ?? ''));
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $treatmentId = filter_var($_POST['treatment_id'] ?? null, FILTER_VALIDATE_INT);
    $date = trim((string) ($_POST['appointment_date'] ?? $_POST['date'] ?? ''));
    $time = trim((string) ($_POST['appointment_time'] ?? ''));
    $accepted = !empty($_POST['privacy']);

    $dateObject = \DateTimeImmutable::createFromFormat('!Y-m-d', $date);
    $timeObject = \DateTimeImmutable::createFromFormat('!H:i', $time);

    if (
        $name === '' ||
        $phone === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        !$treatmentId ||
        !$dateObject ||
        $dateObject->format('Y-m-d') !== $date ||
        !$timeObject ||
        $timeObject->format('H:i') !== $time ||
        !$accepted
    ) {
        $this->confirmation($lang, [
            'created' => false,
            'email_sent' => false,
            'message' => 'Revisa tus datos, el tratamiento, la fecha, la hora y la aceptación de la política de privacidad.'
        ]);
        return;
    }

    $timezone = new \DateTimeZone('Europe/Madrid');
    $appointmentStart = \DateTimeImmutable::createFromFormat(
        '!Y-m-d H:i',
        $date . ' ' . $time,
        $timezone
    );

    if (!$appointmentStart || $appointmentStart <= new \DateTimeImmutable('now', $timezone)) {
        $this->confirmation($lang, [
            'created' => false,
            'email_sent' => false,
            'message' => 'Selecciona una fecha y una hora futuras.'
        ]);
        return;
    }

    $startTime = $appointmentStart->format('H:i:s');
    $endTime = $appointmentStart->modify('+30 minutes')->format('H:i:s');

    $calendar = null;
    $eventId = null;
    $committed = false;

    try {
        // Primero comprobamos Google Calendar. Si no funciona,
        // no creamos una cita nueva en MySQL.
        $calendar = new GoogleCalendarService();

        if (!$calendar->isAvailable($date, $startTime, $endTime)) {
            $this->confirmation($lang, [
                'created' => false,
                'email_sent' => false,
                'message' => 'Ese horario está ocupado en Google Calendar. Selecciona otra hora.'
            ]);
            return;
        }

        $this->db->begin_transaction();

        $patientId = $this->patientModel->findOrCreate([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'accepted' => $accepted
        ]);

        if (!$this->appointmentModel->isAvailable($date, $startTime, $endTime)) {
            $this->db->rollback();

            $this->confirmation($lang, [
                'created' => false,
                'email_sent' => false,
                'message' => 'Ese horario ya está ocupado. Selecciona otra hora.'
            ]);
            return;
        }

        $appointmentId = $this->appointmentModel->create([
            'patient_id' => $patientId,
            'treatment_id' => (int) $treatmentId,
            'appointment_date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
            'notes' => null,
            'google_event_id' => null
        ]);

        if ($appointmentId <= 0) {
            throw new \RuntimeException('No se obtuvo el ID de la cita.');
        }

        // El evento se crea con el horario real de Madrid,
        // sin restar una hora manualmente.
        $eventId = $calendar->createEvent(
            $date,
            $startTime,
            $endTime,
            'Solicitud de cita #' . $appointmentId . ' - ' . $name,
            'Tratamiento ID: ' . (int) $treatmentId .
            "\nPaciente: " . $name .
            "\nTeléfono: " . $phone .
            "\nCorreo: " . $email .
            "\nEstado: Pendiente de confirmación"
        );

        if (!$this->appointmentModel->updateGoogleEventId($appointmentId, $eventId)) {
            throw new \RuntimeException('No se pudo vincular el evento con la cita.');
        }

        $this->db->commit();
        $committed = true;

        $this->confirmation($lang, [
            'created' => true,
            'email_sent' => false,
            'treatment_name' => '',
            'date' => $date,
            'time' => $time,
            'message' => 'Solicitud registrada correctamente. Número de cita: ' .
                $appointmentId . '. Pendiente de confirmación por la clínica.'
        ]);

    } catch (\Throwable $e) {
        error_log('Appointment create / Google Calendar: ' . $e->getMessage());

        if (!$committed) {
            try {
                $this->db->rollback();
            } catch (\Throwable $rollbackError) {
                error_log('Appointment rollback: ' . $rollbackError->getMessage());
            }

            // Si Google creó el evento, pero MySQL falló después,
            // intentamos retirar el evento para evitar una cita huérfana.
            if ($eventId !== null && $calendar !== null) {
                try {
                    $calendar->deleteEvent($eventId);
                } catch (\Throwable $calendarError) {
                    error_log(
                        'No se pudo eliminar el evento de Google ' .
                        $eventId . ': ' . $calendarError->getMessage()
                    );
                }
            }
        }

        http_response_code(500);

        $this->confirmation($lang, [
            'created' => false,
            'email_sent' => false,
            'message' => 'No se pudo registrar la cita en Google Calendar. Contacta con la clínica antes de volver a intentarlo.'
        ]);
    }
}

    /* =========================================================
       CONFIRMATION — RESULTADO DENTRO DEL MODAL
    ========================================================= */

    private function confirmation(string $lang, array $appointmentResult): void
    {
        $language = $lang;
        require __DIR__ . '/Views/Confirmation.php';
    }
}