<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];

    $stmt = $pdo->prepare("INSERT INTO patients (name, email, mobile, age, gender) VALUES (?,?,?,?,?)");
    $stmt->execute([$name, $email, $mobile, $age, $gender]);
}

$patients = $pdo->query("SELECT * FROM patients")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<link rel="stylesheet" href="style.css">

    <title>Manage Patients</title>
</head>
<body>
<script src="script.js"></script>

    <h2>Manage Patients</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Patient Name" required>
        <input type="email" name="email" placeholder="Email">
        <input type="text" name="mobile" placeholder="Mobile">
        <input type="number" name="age" placeholder="Age">
        <select name="gender">
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
        </select>
        <button type="submit">Add Patient</button>
    </form>

    <h3>Patient List</h3>
    <table border="1">
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Mobile</th><th>Age</th><th>Gender</th></tr>
        <?php foreach ($patients as $pat): ?>
            <tr>
                <td><?= $pat["id"] ?></td>
                <td><?= htmlspecialchars($pat["name"]) ?></td>
                <td><?= htmlspecialchars($pat["email"]) ?></td>
                <td><?= htmlspecialchars($pat["mobile"]) ?></td>
                <td><?= htmlspecialchars($pat["age"]) ?></td>
                <td><?= htmlspecialchars($pat["gender"]) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="admin_dashboard.php">Back</a></p>
</body>
</html>
