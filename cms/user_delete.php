<?php
include 'includes/db.php'; 
include 'includes/header.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login_user.php');
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post_id = $_GET['id'];
    $currentUserId = $_SESSION['user_id'];

    $query = "SELECT * FROM posts WHERE post_id = $post_id AND user_id = $currentUserId";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $conn->begin_transaction();

        try {
            $delete_comments_query = "DELETE FROM comments WHERE post_id = $post_id";
            $conn->query($delete_comments_query);

            $delete_post_query = "DELETE FROM posts WHERE post_id = $post_id AND user_id = $currentUserId";
            $conn->query($delete_post_query);

            $conn->commit();
            
            echo "<p>Post and associated comments deleted successfully.</p>";
        } catch (Exception $e) {
            $conn->rollback();
            echo "<p>Error deleting post: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Post not found or you don't have permission to delete this post.</p>";
    }
} else {
    echo "<p>Invalid post ID.</p>";
}
?>
