<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $patient_id = $_POST["patient_id"];
    $doctor_id = $_POST["doctor_id"];
    $date = $_POST["date"];
    $time = $_POST["time"];

    $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, doctor_id, date, time) VALUES (?,?,?,?)");
    $stmt->execute([$patient_id, $doctor_id, $date, $time]);
}

$patients = $pdo->query("SELECT * FROM patients")->fetchAll(PDO::FETCH_ASSOC);
$doctors = $pdo->query("SELECT * FROM doctors")->fetchAll(PDO::FETCH_ASSOC);
$appointments = $pdo->query("SELECT a.id, p.name as patient, d.name as doctor, a.date, a.time, a.status 
    FROM appointments a 
    JOIN patients p ON a.patient_id = p.id 
    JOIN doctors d ON a.doctor_id = d.id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<link rel="stylesheet" href="style.css">

    <title>Manage Appointments</title>
</head>
<body>
<script src="script.js"></script>

    <h2>Manage Appointments</h2>
    <form method="POST">
        <select name="patient_id" required>
            <option value="">Select Patient</option>
            <?php foreach ($patients as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="doctor_id" required>
            <option value="">Select Doctor</option>
            <?php foreach ($doctors as $d): ?>
                <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="date" name="date" required>
        <input type="time" name="time" required>
        <button type="submit">Add Appointment</button>
    </form>

    <h3>Appointment List</h3>
    <table border="1">
        <tr><th>ID</th><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th></tr>
        <?php foreach ($appointments as $a): ?>
            <tr>
                <td><?= $a["id"] ?></td>
                <td><?= htmlspecialchars($a["patient"]) ?></td>
                <td><?= htmlspecialchars($a["doctor"]) ?></td>
                <td><?= $a["date"] ?></td>
                <td><?= $a["time"] ?></td>
                <td><?= $a["status"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="admin_dashboard.php">Back</a></p>
</body>
</html>
