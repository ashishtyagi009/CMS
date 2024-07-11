<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login_admin.php');
    exit();
}

include '../includes/db.php'; 

if (isset($_GET['id'])) {
    $comment_id = $_GET['id'];

    if (is_numeric($comment_id) && $comment_id > 0) {
        $comment_id = intval($comment_id); 
        $comment_id = mysqli_real_escape_string($conn, $comment_id);

        $query = "DELETE FROM comments WHERE comment_id = $comment_id";

        if ($conn->query($query) === TRUE) {
            
            header('Location: manage_comments.php?msg=Comment+deleted+successfully');
            exit();
        } else {
            header('Location: manage_comments.php?msg=Error+deleting+comment');
            exit();
        }
    } else {
        header('Location: manage_comments.php?msg=Invalid+comment+ID');
        exit();
    }
} else {
    header('Location: manage_comments.php?msg=Missing+comment+ID');
    exit();
}

$conn->close(); 
?>
