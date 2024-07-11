<?php
include 'includes/db.php'; 
include 'includes/header.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$post = null;
$comments_result = null;
$comment_error = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post_id = $_GET['id'];

    $query = "SELECT posts.*, users.username 
              FROM posts 
              INNER JOIN users ON posts.user_id = users.id 
              WHERE posts.post_id = $post_id";
    $result = $conn->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            $post = $result->fetch_assoc();

            $comment_query = "SELECT comments.*, users.username 
                              FROM comments 
                              INNER JOIN users ON comments.user_id = users.id 
                              WHERE comments.post_id = $post_id 
                              ORDER BY created_at DESC";
            $comments_result = $conn->query($comment_query);
        } else {
            echo "<p>Post not found.</p>";
        }
    } else {
    
        echo "Error: " . $conn->error;
    }
} else {
    echo "<p>Invalid post ID.</p>";
}

$isUserLoggedIn = isset($_SESSION['user_id']);
$currentUserId = $isUserLoggedIn ? $_SESSION['user_id'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $isUserLoggedIn) {
    $comment_content = mysqli_real_escape_string($conn, $_POST['comment']);

    if (empty($comment_content)) {
        $comment_error = "Comment cannot be empty.";
    } else {
        $user_id = $_SESSION['user_id'];
        $insert_comment_query = "INSERT INTO comments (post_id, user_id, content, created_at) 
                                 VALUES ('$post_id', '$user_id', '$comment_content', NOW())";

        if ($conn->query($insert_comment_query) === TRUE) {
            header("Location: post.php?id=$post_id"); 
            exit();
        } else {
            $comment_error = "Error adding comment: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Detail</title>
    <link rel="stylesheet" href="css/post.css">
</head>
<body>

<div class="post-detail">
    <?php if ($post): ?>
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <p>by <?php echo htmlspecialchars($post['username']); ?></p>
        <?php if (!empty($post['image'])): ?>
            <img src="images/<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="post-image">
        <?php endif; ?>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        
        <?php if ($currentUserId === $post['user_id']): ?>
            <a href="user_edit.php?id=<?php echo $post['post_id']; ?>"class="edit-button">Edit Post</a>
            <a href="user_delete.php?id=<?php echo $post['post_id'];?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete Post</a>
        <?php endif; ?>

        <div class="comments">
            <h3>Comments:</h3>
            <?php if ($comments_result && $comments_result->num_rows > 0): ?>
                <?php while ($comment = $comments_result->fetch_assoc()): ?>
                    <div class="comment">
                        <p><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong> <?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No comments yet.</p>
            <?php endif; ?>

            <?php if ($isUserLoggedIn): ?>
                <form method="POST" action="">
                    <textarea name="comment" placeholder="Add a comment..." required></textarea><br>
                    <button type="submit">Post Comment</button>
                    <p class="error"><?php echo $comment_error; ?></p>
                </form>
            <?php else: ?>
                <p><a href="login_user.php">Log in to add a comment</a></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php';  ?>
</body>
</html>
