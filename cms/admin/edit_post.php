<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login_admin.php');
    exit();
}

include '../includes/db.php';
include '../includes/functions.php';

$id = $_GET['id'];
$query = "SELECT * FROM posts WHERE post_id = $id";
$result = $conn->query($query);
$post = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize_input($_POST['title']);
    $content = sanitize_input($_POST['content']);

    $query = "UPDATE posts SET title = '$title', content = '$content' WHERE post_id = $id";
    if ($conn->query($query)) {
        header('Location: manage_posts.php');
    } else {
        echo "Error updating post: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<main>
    <div class="admin-edit-post">
        <h2>Edit Post</h2>
        <form method="POST" action="">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo $post['title']; ?>" required>
            <label for="content">Content:</label>
            <textarea name="content" rows="10" required><?php echo $post['content']; ?></textarea>
            <button type="submit">Update Post</button>
        </form>
    </div>
</main>

<script src="js/admin_scripts.js"></script>
<?php include '../includes/footer.php'; ?>
</body>
</html>
