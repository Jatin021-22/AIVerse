<?php
session_start();
include 'db.php';

$id = $_GET['id'];
$check = mysqli_query($conn, "SELECT * FROM admin WHERE id = $id AND is_protected = 1");

if (mysqli_num_rows($check) > 0) {
    echo "❌ Cannot delete a super admin!";
    exit;
}

mysqli_query($conn, "DELETE FROM admin WHERE id = $id");
header("Location: manage_admin.php"); 
?>
