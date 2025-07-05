<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $doctor_id = $_POST['doctor_id'];
  $date = $_POST['date'];
  $time = $_POST['time'];
  $patient_id = $_SESSION['user_id'];

  $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("iiss", $patient_id, $doctor_id, $date, $time);
  $stmt->execute();

  header("Location: patientsdashboard.php");
  exit();
}

// Fetch all approved doctors
$doctors = $conn->query("SELECT * FROM doctors ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Book Appointment</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <div class="container">
    <h2>Book Appointment</h2>
    <form method="POST">
      <label>Select Doctor:</label><br>
      <select name="doctor_id" required>
        <option value="">-- Choose --</option>
        <?php while ($row = $doctors->fetch_assoc()): ?>
          <option value="<?= $row['doctor_id'] ?>">
            <?= htmlspecialchars($row['name']) ?> (<?= $row['specialization'] ?>)
          </option>
        <?php endwhile; ?>
      </select><br><br>

      <label>Appointment Date:</label><br>
      <input type="date" name="date" required><br><br>

      <label>Time:</label><br>
      <input type="time" name="time" required><br><br>

      <button type="submit">Book</button>
    </form>
  </div>
</body>
</html>