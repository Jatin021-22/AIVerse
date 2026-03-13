<?php
session_start();
include 'db.php';

$id = intval($_POST['id']);
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'] ?? '';
$is_protected = isset($_POST['is_protected']) ? 1 : 0;

if ($password) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE admin SET username=?, email=?, password=?, is_protected=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssii", $username, $email, $hashed, $is_protected, $id);
} else {
    $query = "UPDATE admin SET username=?, email=?, is_protected=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssii", $username, $email, $is_protected, $id);
}

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['admin_username'] = $username;
    header("Location: manage_admin.php?msg=updated");
    exit;
} else {
    echo "❌ Failed to update profile.";
}
?>
