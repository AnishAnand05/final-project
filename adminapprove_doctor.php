<?php
session_start();
include 'db.php';

// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//   header("Location: ../login.php");
//   exit();
// }

$id = $_POST['id'] ?? null;

if (!$id) {
  header("Location: admindashboard.php");
  exit();
}

// Handle Approve
if (isset($_POST['approve'])) {
  $stmt = $conn->prepare("SELECT * FROM pending_doctors WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $pending = $stmt->get_result()->fetch_assoc();

  if ($pending) {
    $insert = $conn->prepare("INSERT INTO doctors (name, email, password, specialization) VALUES (?, ?, ?, ?)");
    $insert->bind_param("ssss", $pending['name'], $pending['email'], $pending['password'], $pending['specialization']);
    $insert->execute();
  }
}

// For both approve & reject: delete from pending
$delete = $conn->prepare("DELETE FROM pending_doctors WHERE id = ?");
$delete->bind_param("i", $id);
$delete->execute();

header("Location: admindashboard.php");
exit();