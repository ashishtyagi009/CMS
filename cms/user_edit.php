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

$post = null;
$update_error = '';
$update_success = false;
$currentUserId = $_SESSION['user_id'];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post_id = $_GET['id'];

    $query = "SELECT * FROM posts WHERE post_id = $post_id AND user_id = $currentUserId";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        echo "<p>Post not found or you don't have permission to edit this post.</p>";
        exit();
    }
} else {
    echo "<p>Invalid post ID.</p>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $image = $post['image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_path = 'images/' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $image = basename($_FILES['image']['name']);
        } else {
            $update_error = "Error uploading image.";
        }
    }

    if (empty($title) || empty($content)) {
        $update_error = "Title and content cannot be empty.";
    } else {
        $update_query = "UPDATE posts SET title = '$title', content = '$content', image = '$image' WHERE post_id = $post_id AND user_id = $currentUserId";
        if ($conn->query($update_query) === TRUE) {
            $update_success = true;
            header("Location: post.php?id=$post_id"); 
            exit();
        } else {
            $update_error = "Error updating post: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="css/post.css">
</head>
<body>
<div class="post-edit">
    <h2>Edit Post</h2>
    <?php if ($update_success): ?>
        <p class="success">Post updated successfully!</p>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br>
        
        <label for="content">Content:</label><br>
        <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea><br>
        
        <label for="image">Image:</label><br>
        <input type="file" name="image"><br>
        <?php if (!empty($post['image'])): ?>
            <img src="images/<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="post-image">
        <?php endif; ?><br>
        
        <button type="submit">Update Post</button>
        <p class="error"><?php echo $update_error; ?></p>
    </form>
</div>

<?php include 'includes/footer.php';  ?>
</body>
</html>
