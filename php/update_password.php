<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    echo "❌ You are not logged in.";
    exit();
}

$username = $_SESSION['username'];
$success = "";
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch current hashed password
    $stmt = $conn->prepare("SELECT password FROM registration WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user || !password_verify($old_password, $user['password'])) {
        $error = "❌ Old password is incorrect.";
    } elseif ($new_password !== $confirm_password) {
        $error = "❌ New passwords do not match.";
    } elseif (strlen($new_password) < 6) {
        $error = "❌ Password must be at least 6 characters.";
    } else {
        $hashed = password_hash($new_password, PASSWORD_BCRYPT);
        $update = $conn->prepare("UPDATE registration SET password = ? WHERE username = ?");
        $update->bind_param("ss", $hashed, $username);
        if ($update->execute()) {
            $success = "✅ Password updated successfully.";
        } else {
            $error = "❌ Failed to update password.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>AIverse | Update Password</title>
    
  <link rel="icon" href="../img\Screenshot_2025-06-29_121809-removebg-preview.png" type="image/png">
    <style>
        :root {
            --primary-blue: #4da6ff;
            --light-blue: #e6f2ff;
            --border-color: #e0e0e0;
            --error-red: #ff4d4d;
            --success-green: #2ecc71;
        }
        
        .password-container {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            margin-bottom:30px;
        }
        
        .password-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(to right, var(--primary-blue), #80c0ff);
        }
        
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 26px;
            position: relative;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.2s ease;
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        .form-group input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(77, 166, 255, 0.1);
            outline: none;
        }
        
        .submit-btn {
            background-color: var(--primary-blue);
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 10px;
        }
        
        .submit-btn:hover {
            background-color: #3a8de0;
        }
        
        .message {
            padding: 14px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        
        .success { 
            background-color: rgba(46, 204, 113, 0.1);
            color: var(--success-green);
            border-left: 4px solid var(--success-green);
        }
        
        .error { 
            background-color: rgba(255, 77, 77, 0.1);
            color: var(--error-red);
            border-left: 4px solid var(--error-red);
        }
        
        .password-strength {
            height: 4px;
            background: #eee;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }
        
        .strength-meter {
            height: 100%;
            width: 0;
            background: #ddd;
            transition: all 0.3s ease;
        }
        .profile-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        @media (max-width: 600px) {
            .password-container {
                padding: 30px 20px;
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    
    <?php include 'header.php'; include 'background.php'; ?>
    <div style="padding: 20px 30px; background: linear-gradient(to right, #e0f7faaa, #f0fcff54); border-radius: 12px; margin: 30px auto; max-width: 600px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); color: #0077b6; display: flex; align-items: center; gap: 10px; font-size: 18px; margin-top:150px;">
  <i class="fa-solid fa-house" style="color: #00b4d8;"></i>
  <a href="index.php" style="color: #0077b6; text-decoration: none; font-weight: 500;">Home</a>
  <span>/</span>
  <span style="font-weight: bold;">Update Password</span>
</div>
<div class="profile-wrapper">
<div class="password-container">
    <h2>Change Password</h2>

    <?php if ($success): ?>
        <div class="message success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="message error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="old_password">Current Password</label>
            <input type="password" id="old_password" name="old_password" required>
        </div>
        
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required>
            <div class="password-strength">
                <div class="strength-meter" id="strength-meter"></div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        
        <button type="submit" class="submit-btn">Update Password</button>
    </form>
</div>
</div>
<script>
    // Password strength indicator
    document.getElementById('new_password').addEventListener('input', function() {
        const password = this.value;
        const meter = document.getElementById('strength-meter');
        let strength = 0;
        
        if (password.length >= 6) strength += 1;
        if (password.length >= 8) strength += 1;
        if (/[A-Z]/.test(password)) strength += 1;
        if (/[0-9]/.test(password)) strength += 1;
        if (/[^A-Za-z0-9]/.test(password)) strength += 1;
        
        const colors = ['#ff4d4d', '#ff9933', '#ffcc00', '#99cc33', '#2ecc71'];
        const width = strength * 20;
        
        meter.style.width = width + '%';
        meter.style.backgroundColor = colors[strength - 1] || '#ddd';
    });
</script>

</body>
</html>
<?php include 'footer.php';?>