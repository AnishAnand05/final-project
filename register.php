<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  $role = $_POST["role"];
  $specialization = $_POST["specialization"] ?? null;

  // Check for duplicates across users and pending_doctors
  $check = $conn->prepare("SELECT email FROM users WHERE email = ? UNION SELECT email FROM pending_doctors WHERE email = ?");
  $check->bind_param("ss", $email, $email);
  $check->execute();
  $check->store_result();

  if ($check->num_rows > 0) {
    $msg = "<p style='color:red; text-align:center;'>🚫 Email already exists or pending approval.</p>";
  } else {

    if ($role == "doctor") {
      $stmt = $conn->prepare("INSERT INTO pending_doctors (name, email, password, specialization) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $name, $email, $password, $specialization);
      $stmt->execute();
      $msg = "<p style='color:orange; text-align:center;'>✅ Doctor application submitted for admin approval.</p>";
    } else {
      $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $name, $email, $password, $role);
       $stmt->execute();
      $msg = "<p style='color:green; text-align:center;'>🎉 Registered successfully! Redirecting to login...</p>";
      header("refresh:3;url=login.php");
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register - Doctor Appointment</title>
  <link rel="stylesheet" href="style.css">
  <script>
    function toggleSpecialization(role) {
      const field = document.getElementById("specialization-field");
      field.style.display = role === "doctor" ? "block" : "none";
    }
  </script>
</head>
<body>
  <div class="container">
    <h2>Register</h2>
    <form method="POST">
      <input type="text" name="name" placeholder="Full Name" required><br><br>
      <input type="email" name="email" placeholder="Email" required><br><br>
      <input type="password" name="password" placeholder="Password" required><br><br>

      <select name="role" onchange="toggleSpecialization(this.value)" required>
        <option value="">Select Role</option>
        <!-- //////... -->
        <!-- <option value="admin">Admin</option> -->


        <option value="patient">Patient</option>
        <option value="doctor">Doctor</option>
      </select><br><br>

      <div id="specialization-field" style="display:none;">
        <input type="text" name="specialization" placeholder="Specialization"><br><br>
      </div>

      <button type="submit">Register</button>
      <p><a href="login.php">Already have an account? Login</a></p>
    </form>
    <?= $msg ?? '' ?>
  </div>
</body>
</html>
