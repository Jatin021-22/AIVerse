<?php
session_start();
include 'db.php'; // Make sure this connects correctly

// Get username from session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Remove session from active_sessions table
    $stmt = $conn->prepare("DELETE FROM active_sessions WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->close();
}

// Destroy session
session_unset();
session_destroy();

// Redirect to login page
header("Location: login.php");
exit();
?>
