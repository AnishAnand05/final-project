<?php
session_start();
include 'db.php';

// 🚫 Block non-admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}

// Fetch pending doctors
$stmt = $conn->prepare("SELECT * FROM pending_doctors ORDER BY applied_on DESC");
$stmt->execute();
$result = $stmt->get_result();

?>
 
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">

    <h2>Pending Doctor Applications</h2>
   
    <?php if ($result->num_rows > 0): ?>
      <table>
        <tr><th>Name</th><th>Email</th><th>Specialization</th><th>Actions</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['specialization']) ?></td>
            <td>
              <form method="POST" action="approve_doctor.php" style="display:inline;">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button name="approve">✅ Approve</button>
              </form>
              <form method="POST" action="approve_doctor.php" style="display:inline;">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button name="reject" style="background:#d32f2f; color:white;">❌ Reject</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
           
      </table>
    <?php else: ?>
      <p>No pending applications at the moment.</p>
    <?php endif; ?>
     <a href="index.php"><button>Home</button></a>
  </div>
</body>
</html>