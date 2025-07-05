<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST["email"];
  $password = $_POST["password"];

  // 1. Check users table (for patients and admin)
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user["password"])) {
      $_SESSION["user_id"] = $user["id"];
      $_SESSION["role"] = $user["role"];
      $_SESSION["name"] = $user["name"];

      if ($user["role"] === "admin") {
        header("Location: admindashboard.php");
      } 
        //Admin k liye
        
            if ($user['role'] === 'admin') {
        $_SESSION['role'] = 'admin';
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        header("Location: admindashboard.php");
        exit();
        }
      
      else {
        header("Location: patientsdashboard.php");
      }
      exit();
    }
  }

  // 2. If not found, check doctors table
  $stmt = $conn->prepare("SELECT * FROM doctors WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($doctor = $result->fetch_assoc()) {
    if (password_verify($password, $doctor["password"])) {
      $_SESSION["user_id"] = $doctor["doctor_id"];
      $_SESSION["role"] = "doctor";
      $_SESSION["name"] = $doctor["name"];
      header("Location: doctorsdashboard.php");
      exit();
    }
  }

  $error = "Invalid email or password.";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Login</h2>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required><br><br>
      <input type="password" name="password" placeholder="Password" required><br><br>
      <button type="submit">Login</button>
      <p><a href="register.php">New here? Register now</a></p>
      <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </form>
  </div>
</body>
</html>