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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname   = trim($_POST['fname']);
    $lname   = trim($_POST['lname']);
    $email   = trim($_POST['email']);
    $pincode = trim($_POST['pincode']);
    $phone   = trim($_POST['phone']);

    // Validations
    if (!preg_match("/^[A-Za-z]{2,}$/", $fname)) {
        $error = "❌ First name must contain only letters (min 2).";
    } elseif (!preg_match("/^[A-Za-z]{1,}$/", $lname)) {
        $error = "❌ Last name must contain only letters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "❌ Invalid email format.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $error = "❌ Phone number must be 10 digits.";
    } elseif (!preg_match("/^[0-9]{6}$/", $pincode)) {
        $error = "❌ Pincode must be 6 digits.";
    } else {
        $update = $conn->prepare("UPDATE registration SET fname=?, lname=?, email=?, pincode=?, phone=? WHERE username=?");
        $update->bind_param("ssssss", $fname, $lname, $email, $pincode, $phone, $username);

        if ($update->execute()) {
            $success = "✅ Profile updated successfully.";
        } else {
            $error = "❌ Failed to update profile.";
        }
    }
}

$stmt = $conn->prepare("SELECT * FROM registration WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "❌ User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>AIverse | Update Profile</title>
    
  <link rel="icon" href="../img\Screenshot_2025-06-29_121809-removebg-preview.png" type="image/png">
    <style>
        :root {
            --primary-color: #4da6ff;
            --primary-light: #e6f2ff;
            --shadow-color: rgba(77, 166, 255, 0.2);
        }
        
        .profile-container {
            width: 100%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-bottom:30px;
        }
        
        .profile-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--primary-light) 0%, rgba(255,255,255,0) 70%);
            opacity: 0.3;
            z-index: -1;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 28px;
            position: relative;
        }
        
        h2::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: var(--primary-color);
            margin: 10px auto 0;
            border-radius: 3px;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
            font-size: 14px;
        }
        
        input[type="text"], 
        input[type="email"], 
        input[type="number"] {
            width: 100%;
            padding: 15px 20px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.8);
        }
        
        input[type="text"]:focus, 
        input[type="email"]:focus, 
        input[type="number"]:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--shadow-color);
            outline: none;
        }
        
        input[type="submit"] {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 16px;
            width: 100%;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 15px var(--shadow-color);
        }
        
        input[type="submit"]:hover {
            background-color: #3a8de0;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px var(--shadow-color);
        }
        
        input[type="submit"]:active {
            transform: translateY(0);
        }
        
        .message {
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 10px;
            text-align: center;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .success { 
            background-color: #e6f7e6;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }
        
        .error { 
            background-color: #ffebee;
            color: #c62828;
            border-left: 4px solid #c62828;
        }
        .profile-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Floating animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body>
    
    <?php include 'header.php'; include 'background.php'; ?>
    <div style="padding: 20px 30px; background: linear-gradient(to right, #e0f7faaa, #f0fcff54); border-radius: 12px; margin: 30px auto; max-width: 600px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); color: #0077b6; display: flex; align-items: center; gap: 10px; font-size: 18px; margin-top:150px;">
  <i class="fa-solid fa-house" style="color: #00b4d8;"></i>
  <a href="index.php" style="color: #0077b6; text-decoration: none; font-weight: 500;">Home</a>
  <span>/</span>
  <span style="font-weight: bold;">Update Profile</span>
</div>
<div class="profile-wrapper">
<div class="profile-container floating">
    <h2>My Profile</h2>

    <?php if ($success): ?>
        <div class="message success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="message error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="fname" value="<?= htmlspecialchars($user['fname']) ?>" required>
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="lname" value="<?= htmlspecialchars($user['lname']) ?>" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
        </div>

        <div class="form-group">
            <label>Pincode</label>
            <input type="text" name="pincode" value="<?= htmlspecialchars($user['pincode']) ?>" required>
        </div>

        <input type="submit" value="Update Profile">
    </form>
</div>
</div>
<script>
    // Add subtle interactive effects
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="number"]');
        
        inputs.forEach(input => {
            // Add focus class to parent
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
        
        // Add ripple effect to submit button
        const submitBtn = document.querySelector('input[type="submit"]');
        if (submitBtn) {
            submitBtn.addEventListener('click', function(e) {
                const x = e.clientX - e.target.getBoundingClientRect().left;
                const y = e.clientY - e.target.getBoundingClientRect().top;
                
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 1000);
            });
        }
    });
</script>

</body>
</html>
<?php include 'footer.php'?>