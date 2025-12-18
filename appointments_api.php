<?php
// appointments_api.php
// Returns JSON events for FullCalendar. Role-aware: admin sees all, doctor sees own, patient sees own.

require_once __DIR__ . '/functions.php'; // functions.php loads config.php and session
header('Content-Type: application/json');

$user = current_user();
if (!$user) {
    echo json_encode([]); // not logged in -> empty
    exit;
}

$role = $user['role'] ?? '';

// Build SQL depending on role
if ($role === 'admin') {
    $sql = "SELECT a.id, a.appointment_date, a.appointment_time,
                   ud.name AS doctor_name, up.name AS patient_name
            FROM appointments a
            JOIN doctors d ON a.doctor_id = d.id
            JOIN users ud ON d.user_id = ud.id
            JOIN patients p ON a.patient_id = p.id
            JOIN users up ON p.user_id = up.id
            ORDER BY a.appointment_date, a.appointment_time";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $res = $stmt->get_result();
} elseif ($role === 'doctor') {
    // find doctor.id for this user
    $stmt0 = $conn->prepare("SELECT id FROM doctors WHERE user_id = ?");
    $stmt0->bind_param("i", $user['id']);
    $stmt0->execute();
    $docRow = $stmt0->get_result()->fetch_assoc();
    $doctor_id = $docRow['id'] ?? 0;

    $sql = "SELECT a.id, a.appointment_date, a.appointment_time,
                   ud.name AS doctor_name, up.name AS patient_name
            FROM appointments a
            JOIN doctors d ON a.doctor_id = d.id
            JOIN users ud ON d.user_id = ud.id
            JOIN patients p ON a.patient_id = p.id
            JOIN users up ON p.user_id = up.id
            WHERE a.doctor_id = ?
            ORDER BY a.appointment_date, a.appointment_time";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $res = $stmt->get_result();
} else { // patient
    // find patient.id for this user
    $stmt0 = $conn->prepare("SELECT id FROM patients WHERE user_id = ?");
    $stmt0->bind_param("i", $user['id']);
    $stmt0->execute();
    $patRow = $stmt0->get_result()->fetch_assoc();
    $patient_id = $patRow['id'] ?? 0;

    $sql = "SELECT a.id, a.appointment_date, a.appointment_time,
                   ud.name AS doctor_name, up.name AS patient_name
            FROM appointments a
            JOIN doctors d ON a.doctor_id = d.id
            JOIN users ud ON d.user_id = ud.id
            JOIN patients p ON a.patient_id = p.id
            JOIN users up ON p.user_id = up.id
            WHERE a.patient_id = ?
            ORDER BY a.appointment_date, a.appointment_time";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $res = $stmt->get_result();
}

// Build events array
$events = [];
while ($row = $res->fetch_assoc()) {
    // appointment_time may be stored as HH:MM:SS or HH:MM
    // ensure we produce HH:MM:SS for FullCalendar
    $time = $row['appointment_time'];
    if (strlen($time) === 5) $time .= ':00'; // "09:30" -> "09:30:00"

    $events[] = [
        'id'    => $row['id'],
        'title' => "Dr. {$row['doctor_name']} — {$row['patient_name']}",
        'start' => $row['appointment_date'] . 'T' . $time,
        'allDay'=> false,
        'extendedProps' => [
            'doctor'  => $row['doctor_name'],
            'patient' => $row['patient_name'],
        ],
        // optionally provide a details URL:
        'url' => "/HMS/appointments_details.php?id=" . $row['id'] // create if desired
    ];
}

echo json_encode($events);
