<?php
$host = "localhost:3307";
$user = "root"; // your DB username
$pass = "";     // your DB password
$dbname = "doctor_appointment";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}
?>