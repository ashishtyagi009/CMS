<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login_admin.php');
    exit();
}

include '../includes/db.php';
include '../includes/admin_header.php';

$query_posts = "SELECT COUNT(*) AS total_posts FROM posts";
$query_comments = "SELECT COUNT(*) AS total_comments FROM comments";
$result_posts = $conn->query($query_posts);
$result_comments = $conn->query($query_comments);

$total_posts = $result_posts->fetch_assoc()['total_posts'];
$total_comments = $result_comments->fetch_assoc()['total_comments'];
?>

<main>
    <div class="admin-dashboard">
        <h2>Welcome, Admin</h2>
        <div class="stats">
            <p>Total Posts: <?php echo $total_posts; ?></p>
            <p>Total Comments: <?php echo $total_comments; ?></p>
        </div>
        <div class="admin-actions">
            <a href="manage_posts.php">Manage Posts</a>
            <a href="manage_comments.php">Manage Comments</a>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>
