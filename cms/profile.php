<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login_user.php');
    exit();
}

include 'includes/db.php'; 
include 'includes/header.php'; 

$user_id = $_SESSION['user_id'];

$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = $conn->query($user_query);

if ($user_result && $user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
} else {
    echo "<p>User not found.</p>";
    exit();
}

$post_query = "SELECT * FROM posts WHERE user_id = $user_id ORDER BY created_at DESC";
$post_result = $conn->query($post_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/profile.css">
    <style>
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .post-preview {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: box-shadow 0.3s;
        }

        .post-preview:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .post-preview a {
            text-decoration: none;
            color: #333;
        }

        .post-preview h3 {
            margin: 0 0 10px 0;
            font-size: 1.5rem;
            color: #333;
        }

        .post-preview .post-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .post-preview .post-content {
            color: #555;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="profile-container">
            <h1>My Profile</h1>
            <div class="profile-details">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>User ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
            </div>

            <div class="user-posts">
                <h2>My Posts</h2>
                <?php if ($post_result && $post_result->num_rows > 0): ?>
                    <div class="posts-grid">
                        <?php while ($post = $post_result->fetch_assoc()): ?>
                            <div class="post-preview">
                                <a href="post.php?id=<?php echo $post['post_id']; ?>">
                                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                                    <?php if (!empty($post['image'])): ?>
                                        <img src="images/<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="post-image">
                                    <?php endif; ?>
                                    <p class="post-content"><?php echo substr(htmlspecialchars($post['content']), 0, 150); ?>...</p>
                                </a>
                                <a href="user_edit.php?id=<?php echo $post['post_id']; ?>">Edit Post</a>
                                <a href="user_delete.php?id=<?php echo $post['post_id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete Post</a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p>No posts yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php';  ?>
</body>
</html>
