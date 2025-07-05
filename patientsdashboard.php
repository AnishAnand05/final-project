<?php
session_start();
include 'db.php';

// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'patient') {
//   header("Location: ../login.php");
//   exit();
// }

$patient_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
  SELECT a.*, d.name AS doctor_name, d.specialization
  FROM appointments a
  JOIN doctors d ON a.doctor_id = d.doctor_id
  WHERE a.patient_id = ?
  ORDER BY appointment_date ASC, appointment_time ASC
");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Patient Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> 👋</h2>
    <a href="patientsbook.php"><button>📅 Book New Appointment</button></a>
    <br>
    <br>
    <a href="index.php"><button>Home</button></a>
    <h3>Your Appointments</h3>
    <?php if ($result->num_rows > 0): ?>
      <table>
        <tr><th>Doctor</th><th>Specialization</th><th>Date</th><th>Time</th><th>Status</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['doctor_name']) ?></td>
          <td><?= htmlspecialchars($row['specialization']) ?></td>
          <td><?= $row['appointment_date'] ?></td>
          <td><?= $row['appointment_time'] ?></td>
          <td><?= $row['status'] ?></td>
        </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p>No appointments yet. Book one!</p>
    <?php endif; ?>
  </div>
</body>
</html>