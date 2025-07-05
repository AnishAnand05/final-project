<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'doctor') {
  header("Location:login.php");
  exit();
}

$appointment_id = $_POST['appointment_id'];
$status = $_POST['action'];

$stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $appointment_id);
$stmt->execute();

header("Location: doctorsdashboard.php");
exit();