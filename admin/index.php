<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<?php
include 'db.php';

// Query for active users
$sql_active = "SELECT a.username, r.email, a.ip_address, a.login_time 
               FROM active_sessions a 
               JOIN registration r ON a.username = r.username";
$result_active = $conn->query($sql_active);

// Query for all registered users
$sql_users = "SELECT * FROM registration";
$result_users = $conn->query($sql_users);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Active Users & Manage Users</title>
    <link rel="icon" href="img/logo2.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/index.css">
</head>

<?php include 'background.php'?>
<body>

<!-- ACTIVE USERS -->
<div class="container py-4">
    <h2 class="mb-4 text-center">👥 Active Users</h2>
    <div class="row">
        <?php while ($row = $result_active->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card user-card p-3">
                    <h5 class="card-title">👤 <?php echo htmlspecialchars($row['username']); ?></h5>
                    <p class="card-text">📧 <?php echo htmlspecialchars($row['email']); ?></p>
                    <p class="card-text">🌐 IP: <?php echo htmlspecialchars($row['ip_address']); ?></p>
                    <p class="card-text text-muted">🕒 Logged in at:<br> <?php echo date("d M Y, h:i A", strtotime($row['login_time'])); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
            <div class="divider1"></div>

<!-- MANAGE USERS -->
<div class="container py-5">
    <h2 class="text-center mb-4">👤 Manage Users</h2>
    <div class="row">
        <?php while ($row = $result_users->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card user-card p-3">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?></h5>
                    <p class="card-text">📧 <?php echo htmlspecialchars($row['email']); ?></p>
                    <p class="card-text">🧑 Username: <?php echo htmlspecialchars($row['username']); ?></p>
                    <p class="card-text">📍 Pincode: <?php echo htmlspecialchars($row['pincode']); ?></p>
                    <p class="card-text">📱 Phone: <?php echo htmlspecialchars($row['phone']); ?></p>
                    <form method="POST" action="delete_user.php" onsubmit="return confirmDelete(event, <?php echo $row['id']; ?>)">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn btn-danger w-100 mt-2">Delete User</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script>
function confirmDelete(event, userId) {
    event.preventDefault();
    Swal.fire({
        title: 'Confirm User Deletion',
        text: "This action will permanently delete the user and all associated data.",
        icon: 'warning',
        imageUrl: 'img/logo2.png',
        imageWidth: 80,
        imageHeight: 80,
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#7dd3fc',
        confirmButtonText: 'Delete Permanently',
        cancelButtonText: 'Cancel',
        background: 'rgba(255, 255, 255, 0.9)',
        backdrop: `
            rgba(2, 132, 199, 0.1)
            url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%230ea5e9' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E")
        `
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form to delete the user
            fetch(event.target.action, {
                method: 'POST',
                body: new URLSearchParams(new FormData(event.target)),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                }
            })
            .then(response => response.text())
            .then(() => {
                // Show success message
                Swal.fire({
                    title: 'Deleted!',
                    text: 'The user has been deleted successfully.',
                    icon: 'success',
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'OK',
                    willClose: () => {
                        // Refresh the page after deletion
                        window.location.reload();
                    }
                });
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'There was a problem deleting the user', 'error');
            });
        }
    });
    return false;
}
</script>
<?php include 'sidebar.php'; ?>
<?php $conn->close(); ?>
</body>
</html>
<?php include 'footer.php'?>