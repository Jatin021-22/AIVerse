<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    echo "❌ You are not logged in.";
    exit();
}

$username = $_SESSION['username'];

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM registration WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "❌ User not found.";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>AI Verse | My Profile</title>
    
  <link rel="icon" href="../img\Screenshot_2025-06-29_121809-removebg-preview.png" type="image/png">
    <style>
        :root {
            --primary-blue: #4da6ff;
            --light-blue: #e6f2ff;
            --border-color: #e0e0e0;
        }
        .profile-container {
            width: 100%;
            max-width: 600px;
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            margin-bottom:30px;
        }
        
        .profile-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(to right, var(--primary-blue), #80c0ff);
        }
        
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 28px;
            position: relative;
        }
        
        .profile-field {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .profile-field:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .field-label {
            width: 120px;
            font-weight: 500;
            color: #666;
            font-size: 14px;
        }
        
        .field-value {
            flex: 1;
            min-width: 200px;
            padding: 12px 15px;
            background-color: var(--light-blue);
            border-radius: 10px;
            font-size: 15px;
            color: #333;
        }
        
        .edit-btn {
            display: block;
            margin: 30px auto 0;
            background-color: var(--primary-blue);
            color: white;
            text-align: center;
            padding: 14px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            width: fit-content;
            transition: background-color 0.2s ease;
            border: none;
            cursor: pointer;
            font-size: 15px;
        }
        
        .edit-btn:hover {
            background-color: #3a8de0;
        }
        .profile-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        
        @media (max-width: 600px) {
            .profile-container {
                padding: 30px 20px;
                margin: 20px;
            }
            
            .profile-field {
                flex-direction: column;
            }
            
            .field-label {
                width: 100%;
                margin-bottom: 8px;
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
  <span style="font-weight: bold;">View Profile</span>
</div>
<div class="profile-wrapper">
<div class="profile-container">
    <h2>My Profile</h2>

    <div class="profile-field">
        <div class="field-label">Username</div>
        <div class="field-value"><?= htmlspecialchars($user['username']) ?></div>
    </div>
    
    <div class="profile-field">
        <div class="field-label">First Name</div>
        <div class="field-value"><?= htmlspecialchars($user['fname']) ?></div>
    </div>
    
    <div class="profile-field">
        <div class="field-label">Last Name</div>
        <div class="field-value"><?= htmlspecialchars($user['lname']) ?></div>
    </div>
    
    <div class="profile-field">
        <div class="field-label">Email</div>
        <div class="field-value"><?= htmlspecialchars($user['email']) ?></div>
    </div>
    
    <div class="profile-field">
        <div class="field-label">Phone</div>
        <div class="field-value"><?= htmlspecialchars($user['phone']) ?></div>
    </div>
    
    <div class="profile-field">
        <div class="field-label">Pincode</div>
        <div class="field-value"><?= htmlspecialchars($user['pincode']) ?></div>
    </div>
    
    <div class="profile-field">
        <div class="field-label">Joined On</div>
        <div class="field-value"><?= htmlspecialchars($user['created_at']) ?></div>
    </div>

    <a href="update_profile.php" class="edit-btn">Edit Profile</a>
</div>
</div>
</body>
</html>
<?php include 'footer.php'?>