<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<?php
include 'db.php'; 
$query = "SELECT * FROM feedback ORDER BY submitted_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Feedback Dashboard</title>
    <link rel="icon" href="img/logo2.png" type="image/png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/feedback.css">
</head>

<?php include 'background.php'?>
<body>
  <div class="container py-4">
    <h2 class="text-center">User Feedback Dashboard</h2>

    <div class="feedback-grid">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="feedback-card">
          <div class="feedback-header">
            <h3 class="feedback-title"><?= htmlspecialchars($row['name']) ?> (ID: <?= $row['id'] ?>)</h3>
            <p class="feedback-meta"><?= htmlspecialchars($row['email']) ?> | <?= date('d M Y, h:i A', strtotime($row['submitted_at'])) ?></p>
          </div>
          
          <p class="feedback-content"><strong>Subject:</strong> <?= htmlspecialchars($row['subject']) ?></p>
          
          <div class="feedback-content">
            <strong>Message:</strong><br>
            <div style="padding-left: 1rem; margin-top: 0.5rem;">
              <?= nl2br(htmlspecialchars($row['message'])) ?>
            </div>
          </div>
          
          <p class="feedback-content rating">
            <strong>Rating:</strong>
            <?php
              for ($i = 1; $i <= 5; $i++) {
                echo $i <= $row['rating'] ? '★' : '☆';
              }
            ?>
          </p>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
  
<?php include 'sidebar.php'; ?>
</body>
</html>

<?php include 'footer.php'; ?>