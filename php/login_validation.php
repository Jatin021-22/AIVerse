<?php
session_start();
include 'db.php'; // Ensure this connects to your database properly

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username']);
    $password = $_POST['password'];

    // Prepare SQL to check username OR email
    $stmt = $conn->prepare("SELECT * FROM registration WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check password
        if (password_verify($password, $user['password'])) {
            // ✅ Set session
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email']    = $user['email'];
            $_SESSION['logged_in'] = true;

            // ✅ Log active session
            $ip = $_SERVER['REMOTE_ADDR'];
            $login_time = date("Y-m-d H:i:s");

            $logStmt = $conn->prepare("INSERT INTO active_sessions (username, email, ip_address, login_time) VALUES (?, ?, ?, ?)");
            $logStmt->bind_param("ssss", $user['username'], $user['email'], $ip, $login_time);
            $logStmt->execute();
            $logStmt->close();

            // ✅ Redirect to homepage
            header("Location: index.php");
            exit();
        } else {
            // ❌ Set error in session instead of alert
            $_SESSION['login_error'] = "Username or password is incorrect";
            header("Location: login.php");
            exit();
        }
    } else {
        // ❌ User not found
        $_SESSION['login_error'] = "Username or password is incorrect";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
