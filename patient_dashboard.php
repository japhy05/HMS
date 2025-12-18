<?php
require_once "../functions.php";
require_login();
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Patient Dashboard | HMS</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="dashboard-body">
  <div class="sidebar">
    <img src="../uploads/profile_images/<?= $user['profile_image'] ?? 'default.png' ?>" class="profile-pic">
    <h3><?= htmlspecialchars($user['name']) ?></h3>
    <p>Patient</p>
    <a href="book_appointment.php">Book Appointment</a>
    <a href="appointments.php">My Appointments</a>
    <a href="../logout.php" class="btn">Logout</a>
  </div>
  <div class="main-content">
    <h1>Welcome, <?= htmlspecialchars($user['name']) ?>!</h1>
    <p>You can book and view your appointments.</p>
  </div>
</body>
</html>
