<?php
require_once "config.php";
require_once "functions.php";
require_login();
$user = $_SESSION['user'];

// Fetch doctors
$result = $conn->query("SELECT * FROM users WHERE role='doctor'");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Manage Doctors | HMS</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="dashboard-body">
  <div class="sidebar">
    <h3>Admin Menu</h3>
    <a href="dashboard_admin.php">Dashboard</a>
    <a href="manage_doctors.php">Manage Doctors</a>
    <a href="manage_patients.php">Manage Patients</a>
    <a href="appointments.php">Appointments</a>
    <a href="logout.php" class="btn">Logout</a>
  </div>
  <div class="main-content">
    <h1>Manage Doctors</h1>
    <table border="1" cellpadding="8">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
      </tr>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['mobile']) ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>
