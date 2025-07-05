<?php
session_start();
session_unset();
session_destroy();
// Optionally, unset the "Remember Me" cookie as well:
setcookie("user_id", "", time() - 3600, "/");

header("Location: index.php");
exit;
?>