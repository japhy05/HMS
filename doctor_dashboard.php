<?php
require_once "../functions.php";
require_login();
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Doctor Dashboard | HMS</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="dashboard-body">
  <div class="sidebar">
    <img src="../uploads/profile_images/<?= $user['profile_image'] ?? 'default.png' ?>" class="profile-pic">
    <h3><?= htmlspecialchars($user['name']) ?></h3>
    <p>Doctor</p>
    <a href="patients.php">Patients</a>
    <a href="appointments.php">Appointments</a>
    <a href="../logout.php" class="btn">Logout</a>
  </div>
  <div class="main-content">
    <h1>Welcome, Dr. <?= htmlspecialchars($user['name']) ?>!</h1>
    <p>You can manage your patients and appointments.</p>
  </div>
</body>
</html>
