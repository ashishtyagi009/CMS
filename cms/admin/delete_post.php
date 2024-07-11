<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login_admin.php');
    exit();
}

include '../includes/db.php';

$id = $_GET['id'];
$query = "DELETE FROM posts WHERE post_id = $id";

if ($conn->query($query)) {
    header('Location: manage_posts.php');
} else {
    echo "Error deleting post: " . $conn->error;
}
?>
