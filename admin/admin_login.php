<?php
session_start();
include 'db.php'; // 🔁 Your DB connection file

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $query = "SELECT * FROM admin WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $username;
                header("Location: index.php"); // Redirect to dashboard
                exit;
            } else {
                $error = "❌ Invalid password.";
            }
        } else {
            $error = "❌ Username not found.";
        }
    } else {
        $error = "Please enter both username and password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="icon" href="img/logo2.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <style>
        :root {
            --primary-light: #7dd3fc;
            --primary-medium: #0ea5e9;
            --primary-dark: #0369a1;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f9ff;
            overflow: hidden;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .liquid-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.4;
            animation: float 15s infinite ease-in-out;
        }

        .circle:nth-child(1) {
            background: var(--primary-light);
            width: 300px;
            height: 300px;
        }

        .circle:nth-child(2) {
            background: var(--primary-medium);
            width: 400px;
            height: 400px;
        }

        .circle:nth-child(3) {
            background: var(--primary-dark);
            width: 250px;
            height: 250px;
        }

        .circle:nth-child(4) {
            background: var(--primary-light);
            width: 350px;
            height: 350px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(2, 132, 199, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            z-index: 10;
            transition: all 0.5s ease;
        }

        .login-container:hover {
            box-shadow: 0 12px 40px rgba(2, 132, 199, 0.2);
        }

        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            display: block;
            filter: drop-shadow(0 2px 4px rgba(2, 132, 199, 0.2));
        }

        h2 {
            color: var(--primary-dark);
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 700;
            position: relative;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-light), var(--primary-medium));
            border-radius: 3px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(203, 213, 225, 0.5);
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 1.25rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-medium);
            box-shadow: 0 0 0 0.25rem rgba(14, 165, 233, 0.25);
            background: rgba(255, 255, 255, 0.95);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-medium), var(--primary-dark));
            border: none;
            border-radius: 10px;
            padding: 12px;
            color: white;
            font-weight: 600;
            width: 100%;
            margin-top: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(2, 132, 199, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(2, 132, 199, 0.3);
        }

        .form-check-input:checked {
            background-color: var(--primary-medium);
            border-color: var(--primary-medium);
        }

        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            color: #64748b;
            font-size: 0.85rem;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            25% {
                transform: translateY(-20px) translateX(10px);
            }
            50% {
                transform: translateY(10px) translateX(-15px);
            }
            75% {
                transform: translateY(-10px) translateX(15px);
            }
        }

        @media (max-width: 576px) {
            .login-container {
                margin: 0 1rem;
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
 <div class="liquid-bg">
        <div class="circle" id="circle1"></div>
        <div class="circle" id="circle2"></div>
        <div class="circle" id="circle3"></div>
        <div class="circle" id="circle4"></div>
    </div>

    <div class="login-container">
        <img src="img/logo2.png" alt="Admin Logo" class="logo">
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn btn-login">Login</button>
        </form>
        <p class="footer-text">© <?= date('Y'); ?> Admin Panel. All rights reserved.</p>
    </div>

    <script>
        gsap.to("#circle1", {duration: 20, x: 100, y: -50, repeat: -1, yoyo: true, ease: "sine.inOut"});
        gsap.to("#circle2", {duration: 25, x: -150, y: 80, repeat: -1, yoyo: true, ease: "sine.inOut"});
        gsap.to("#circle3", {duration: 18, x: 120, y: 100, repeat: -1, yoyo: true, ease: "sine.inOut"});
        gsap.to("#circle4", {duration: 22, x: -80, y: -70, repeat: -1, yoyo: true, ease: "sine.inOut"});
    </script>
</body>
</html>