<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
  header("Location: login.php");
  exit();
}

$doctor_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
  SELECT a.*, u.name AS patient_name
  FROM appointments a
  JOIN users u ON a.patient_id = u.id
  WHERE a.doctor_id = ?
  ORDER BY appointment_date ASC, appointment_time ASC
");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Doctor Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Welcome Dr. <?= htmlspecialchars($_SESSION['name']) ?></h2>
    <h3>Appointment Requests</h3>
    <table>
      <tr><th>Patient</th><th>Date</th><th>Time</th><th>Status</th><th>Action</th></tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['patient_name']) ?></td>
          <td><?= $row['appointment_date'] ?></td>
          <td><?= $row['appointment_time'] ?></td>
          <td><?= $row['status'] ?></td>
          <td>
            <?php if ($row['status'] === 'Pending'): ?>
              <form method="POST" action="update_status.php" style="display:inline;">
                <input type="hidden" name="appointment_id" value="<?= $row['id'] ?>">
                <button name="action" value="Accepted">✅ Accept</button>
                <button name="action" value="Rejected" style="background:#d32f2f; color:white;">❌ Reject</button>
              </form>
            <?php else: ?>
              <em>No action</em>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
      <a href="index.php"><button>Home</button></a>
    </table>
  </div>
</body>
</html>