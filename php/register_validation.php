<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname    = trim($_POST['fname']);
    $lname    = trim($_POST['lname']);
    $email    = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = $_POST['confirm_password'];
    $pincode  = trim($_POST['pincode']);

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        die("Phone number must be 10 digits");
    }


    if (strlen($password) < 6) {
        die("Password must be at least 6 characters");
    }
    if ($password !== $confirm_password) {
        die("❌ Password and Confirm Password do not match");
    }

    // Check duplicate email/username
    $check = $conn->prepare("SELECT * FROM registration WHERE email=? OR username=?");
    $check->bind_param("ss", $email, $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        die("Email or Username already exists");
    }

    // Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO registration (fname, lname, email, phone, username, password, pincode) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $fname, $lname, $email, $phone, $username, $hashed, $pincode);

    if ($stmt->execute()) {
        echo "✅ Registered successfully.";
         header("Location: login.php");
        
    } else {
        echo "❌ Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
