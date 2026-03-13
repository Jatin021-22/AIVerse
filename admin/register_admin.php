<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $is_protected = isset($_POST['is_protected']) ? 1 : 0;

    // === Validations ===
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "❗ Username and password are required.";
        header("Location: manage_admin.php");
        exit;
    }

    if (strlen($password) < 6) {
        $_SESSION['error'] = "🔐 Password must be at least 6 characters.";
        header("Location: manage_admin.php");
        exit;
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "📧 Invalid email format.";
        header("Location: manage_admin.php");
        exit;
    }

    // === Check for duplicate username ===
    $check = mysqli_prepare($conn, "SELECT id FROM admin WHERE username = ?");
    mysqli_stmt_bind_param($check, "s", $username);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        $_SESSION['error'] = "⚠️ Username already exists.";
        header("Location: manage_admin.php");
        exit;
    }

    // === Register New Admin ===
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO admin (username, password, email, is_protected) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssi", $username, $hashed, $email, $is_protected);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "✅ Admin registered successfully!";
        header("Location: manage_admin.php");

    } else {
        $_SESSION['error'] = "❌ Error occurred while registering admin.";
        header("Location: manage_admin.php");

    }
    exit;
}
?>
