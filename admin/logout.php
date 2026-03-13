<?php
session_start();
include 'db.php'; // Make sure this connects correctly

// Destroy session
session_unset();
session_destroy();

// Redirect to login page
header("Location: admin_login.php");
exit();
?>
