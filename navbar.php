<?php
session_start(); // Make sure session is started wherever it's needed
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<nav class="navbar">
  <div class="nav-left">
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="gallary.php">Gallary</a>
    <a href="index.php">Contact</a>
    <a href="#services">Services</a>
  </div>
 </div>
    <div class="dropdown">
    <i class="fas fa-user-circle" style="font-size: 24px;"></i>
    <div class="dropdown-content">
    <?php if (isset($_SESSION['user_id'])): ?>
    <!-- COMMON for all logged-in users -->
    <a href="index.php">👤 <?php echo htmlspecialchars($_SESSION['name']); ?></a>

    <?php if ($_SESSION['role'] === 'admin'): ?>
      <a href="admindashboard.php">🛠️ Admin Dashboard</a>
    <?php elseif ($_SESSION['role'] === 'patient'): ?>
      <a href="patientsdashboard.php">📅 My Appointments</a>
      <a href="patientsbook.php">➕ Book New Appointment</a>
    <?php elseif ($_SESSION['role'] === 'doctor'): ?>
      <a href="doctorsdashboard.php">📅 Manage Appointments</a>
    <?php endif; ?>

    <a href="logout.php">🚪 Logout</a>

  <?php else: ?>
    <!-- GUEST (Not logged in) -->
    <a href="login.php">🔑 Login</a>
    <a href="register.php">📝 Register</a>
  <?php endif; ?>
</div>
</nav>
<style>
   .navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #1565c0;
    padding: 10px 20px;
   }

    .nav-left a{
      color: white;
      text-decoration: none;
      margin: 0 10px;
      font-size: 1rem;
    }


    .nav-left a:hover {
       color:rgb(240, 30, 15);
    }
    .dropdown {
    position: relative;
    display: inline-block;
    cursor: pointer;
    color: white;
    /* padding: 10px; */
    }

      .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #fff;
        min-width: 120px;
        box-shadow: 0px 4px 8px rgba(0,0,0,0.15);
        z-index: 1;
      }

    .dropdown-content a {
      color: #333;
      padding: 10px 16px;
      display: block;
      /* background:  #1565c0; */
      text-decoration: none;
    }
    .dropdown-content a:hover {
      background:rgb(79, 147, 224);;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }
</style>
