<?php
require_once __DIR__ . '/functions.php';
require_login();

$user = current_user();
if ($user['role'] !== 'admin') {
    die("Access denied");
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=appointments.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID','Patient','Doctor','Date','Time','Status','Created']);

$sql = "SELECT a.id, up.name as patient, ud.name as doctor, a.appointment_date, a.appointment_time, a.status, a.created_at
        FROM appointments a
        JOIN patients p ON a.patient_id = p.id
        JOIN users up ON p.user_id = up.id
        JOIN doctors d ON a.doctor_id = d.id
        JOIN users ud ON d.user_id = ud.id
        ORDER BY a.appointment_date DESC, a.appointment_time DESC";
$res = $conn->query($sql);
while ($r = $res->fetch_assoc()) {
    fputcsv($output, [$r['id'], $r['patient'], $r['doctor'], $r['appointment_date'], $r['appointment_time'], $r['status'], $r['created_at']]);
}
fclose($output);
exit;
