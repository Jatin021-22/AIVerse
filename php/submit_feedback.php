<?php
include 'db.php';

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$subject = htmlspecialchars($_POST['subject']);
$message = htmlspecialchars($_POST['message']);
$rating = isset($_POST['rating']) ? (int)$_POST['rating'] : null;

$sql = "INSERT INTO feedback (name, email, subject, message, rating) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $name, $email, $subject, $message, $rating);

if ($stmt->execute()) {
  echo "✅ Feedback submitted successfully.";
} else {
  echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
