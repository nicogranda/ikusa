<?php
namespace App\Domains\Appointments;

class Appointment
{
    public function __construct(private \mysqli $db) {}

    public function create(array $data): int
    {
        $stmt = $this->db->prepare("INSERT INTO appointments (patient_id, treatment_id, appointment_date, start_time, end_time, status, notes, google_event_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $patientId = (int) $data['patient_id'];
        $treatmentId = (int) $data['treatment_id'];
        $date = (string) $data['appointment_date'];
        $start = (string) $data['start_time'];
        $end = (string) $data['end_time'];
        $status = (string) ($data['status'] ?? 'pending');
        $notes = $data['notes'] ?? null;
        $eventId = $data['google_event_id'] ?? null;

        try {
            $stmt->bind_param('iissssss', $patientId, $treatmentId, $date, $start, $end, $status, $notes, $eventId);
            $stmt->execute();
            return (int) $this->db->insert_id;
        } finally {
            $stmt->close();
        }
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM appointments WHERE id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result ?: null;
    }

    public function findByPatient(int $patientId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM appointments WHERE patient_id = ? ORDER BY appointment_date DESC, start_time DESC");
        $stmt->bind_param('i', $patientId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function findByDate(string $date): array
    {
        $stmt = $this->db->prepare("SELECT * FROM appointments WHERE appointment_date = ? AND status IN ('pending', 'confirmed') ORDER BY start_time");
        $stmt->bind_param('s', $date);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function isAvailable(string $date, string $start, string $end, ?int $excludeId = null): bool
    {
        $sql = "SELECT id FROM appointments WHERE appointment_date = ? AND status IN ('pending', 'confirmed') AND start_time < ? AND end_time > ?";
        if ($excludeId !== null) $sql .= " AND id <> ?";
        $sql .= " LIMIT 1";

        $stmt = $this->db->prepare($sql);
        if ($excludeId !== null) $stmt->bind_param('sssi', $date, $end, $start, $excludeId);
        else $stmt->bind_param('sss', $date, $end, $start);

        $stmt->execute();
        $occupied = $stmt->get_result()->fetch_assoc() !== null;
        $stmt->close();
        return !$occupied;
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("UPDATE appointments SET treatment_id = ?, appointment_date = ?, start_time = ?, end_time = ?, notes = ? WHERE id = ?");

        $treatmentId = (int) $data['treatment_id'];
        $date = (string) $data['appointment_date'];
        $start = (string) $data['start_time'];
        $end = (string) $data['end_time'];
        $notes = $data['notes'] ?? null;

        try {
            $stmt->bind_param('issssi', $treatmentId, $date, $start, $end, $notes, $id);
            return $stmt->execute();
        } finally {
            $stmt->close();
        }
    }

    public function updateStatus(int $id, string $status): bool
    {
        if (!in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'], true)) {
            throw new \InvalidArgumentException('Estado de cita no válido.');
        }

        $stmt = $this->db->prepare("UPDATE appointments SET status = ? WHERE id = ?");
        try {
            $stmt->bind_param('si', $status, $id);
            return $stmt->execute();
        } finally {
            $stmt->close();
        }
    }

    public function updateGoogleEventId(int $id, string $eventId): bool
    {
        $stmt = $this->db->prepare("UPDATE appointments SET google_event_id = ? WHERE id = ?");
        try {
            $stmt->bind_param('si', $eventId, $id);
            return $stmt->execute();
        } finally {
            $stmt->close();
        }
    }
}