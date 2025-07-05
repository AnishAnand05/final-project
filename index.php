
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>HealthCheckUp - Online Doctor Appointment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="">
  <style>
    /* style section  */
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f4f8;
    }

    header {
      background-color: #1e88e5;
      color: white;
      padding: 20px;
      text-align: center;
    }
    header img{
      width:90px;
      border-radius:7px;
    }

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
      /* background:  #1565c0;; */
      text-decoration: none;
    }
    .dropdown-content a:hover {
      background:rgb(79, 147, 224);;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }
      .hero {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 60px 20px;
      }

      .hero h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
        color: #333;
      }

      .hero p {
        font-size: 1.2rem;
        max-width: 600px;
        color: #666;
      }

      .hero button {
        margin-top: 20px;
        padding: 12px 24px;
        font-size: 1rem;
        background-color: #43a047;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }

      .hero button:hover {
        background-color: #388e3c;
      }

      @media (max-width: 600px) {
        .hero h1 {
          font-size: 2rem;
        }
      }
      html {
      scroll-behavior: smooth;
      }
  </style>
</head>
<body>


<header>
  <img src="logo.png" alt="Logo">
  <h1>HealthCheckUp</h1>
  <p>Your Trusted Online Doctor Appointment Platform</p>
</header>

<nav class="navbar">
  <div class="nav-left">
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="gallary.php">Gallary</a>
    <a href="#contact">Contact</a>
    <a href="#services">Services</a>
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


<section class="hero">
  <h1>Book Appointments Anytime, Anywhere</h1>
  <p>Connect with experienced doctors in just a few clicks. HealthMate offers fast, secure, and hassle-free healthcare access—right from your device.</p>
  <!-- <a href="register.php"><button>Get Started</button></a> -->
</section>
       <!-- feedback section  (user se lenge iska algo remaining h) -->
<section style="background-color:#ffffff; padding:50px 20px; text-align:center;">
 
  <h2>What Our Users Say</h2>
  <div style="max-width:900px; margin:auto; display:flex; flex-wrap:wrap; justify-content:center; gap:30px; margin-top:30px;">
    
    <div style="flex:1 1 260px; background:#f4f4f4; padding:20px; border-radius:8px;">
      <p>“Booking my doctor’s appointment took less than 2 minutes! Clean UI, helpful reminders, and no phone calls—perfect!”</p>
      <p style="font-weight:bold;">— Neha P., Patient</p>
    </div>
    
    <div style="flex:1 1 260px; background:#f4f4f4; padding:20px; border-radius:8px;">
      <p>“The platform makes it easy to view and manage appointments. It's fast, intuitive, and secure.”</p>
      <p style="font-weight:bold;">— Dr. Raj Sharma</p>
    </div>
    
    <div style="flex:1 1 260px; background:#f4f4f4; padding:20px; border-radius:8px;">
      <p>“HealthMate impressed us with its simplicity and reliability. Great tool for clinics on a budget!”</p>
      <p style="font-weight:bold;">— Admin, Sunrise Clinic</p>
    </div>

  </div>
</section>
<section style="background-color:#e3f2fd; padding:50px 20px; text-align:center;">
  <h2 id ="services">Our Services</h2>
  <div style="max-width:800px; margin:auto; display:flex; flex-wrap:wrap; justify-content:center; gap:40px; margin-top:30px;">
    
    <div style="flex:1 1 200px;">
      <h3>🔎 Search Doctors</h3>
      <p>Browse specialists based on name, specialty, or location.</p>
    </div>
    
    <div style="flex:1 1 200px;">
      <h3>📅 Book Appointments</h3>
      <p>Choose a time slot and book directly—no paperwork involved.</p>
    </div>
    <div style="flex:1 1 200px;">
      <h3>📲 Responsive Access</h3>
      <p>Schedule or manage appointments from mobile, tablet, or desktop.</p>
    </div>
    <div style="flex:1 1 200px;">
      <h3>🔐 Secure Login</h3>
      <p>Role-based authentication ensures only verified access to your data.</p>
    </div>
  </div>
</section>
<section style="background:#f1f8e9; padding:40px 20px; text-align:center;">
  <h2 id ='contact'>Contact Us</h2>
  <p>Got questions, feedback, or support requests? We’d love to hear from you!</p>
  <p><strong>Email:</strong> support@healthcheckup.com</p>
  <p><strong>Phone:</strong> +91-7488172885</p>
  <p><strong>Hours:</strong> Mon–Fri, 10am–6pm IST</p>
</section>
<!-- <button onclick="scrollToTop()" id="topBtn" title="Go to top">⬆</button> -->

</body>
</html>
<?php
// session_start();

 


