<?php
session_start();
require_once "config.php";
require_once "functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (login($email, $password, $role)) {
        header("Location: templates/{$role}.php");
        exit();
    } else {
        $error = "Invalid login credentials!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hospital Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Hospital Management System</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="doctor">Doctor</option>
            <option value="patient">Patient</option>
        </select><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
