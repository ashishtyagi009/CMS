<?php
include 'includes/db.php';
session_start();

function sanitize_input($input) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($input)));
}

if (isset($_GET['query']) && !empty($_GET['query'])) {
    $search_query = sanitize_input($_GET['query']);
    $search_query_safe = '%' . $search_query . '%';

    $search_posts_query = "SELECT * FROM posts WHERE title LIKE ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($search_posts_query);
    $stmt->bind_param('s', $search_query_safe);
    $stmt->execute();
    $search_result = $stmt->get_result();

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - <?php echo $projectName; ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .search-results {
            margin-top: 20px;
            padding: 0 20px;
        }

        .search-results .post-preview {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: box-shadow 0.3s;
        }

        .search-results .post-preview:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .search-results .post-preview a {
            text-decoration: none;
            color: #333;
        }

        .search-results .post-preview h3 {
            margin: 0 0 10px 0;
            font-size: 1.3rem;
        }

        .search-results .post-preview .post-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .search-results .post-preview .post-content {
            color: #555;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="search-results">
        <h2>Search Results</h2>
        <?php
        if (isset($search_result) && $search_result->num_rows > 0) {
            while ($post = $search_result->fetch_assoc()) {
                echo '<div class="post-preview">';
                echo '<a href="post.php?id=' . $post['post_id'] . '">';
                echo '<h3>' . htmlspecialchars($post['title']) . '</h3>';
                if (!empty($post['image'])) {
                    echo '<img src="images/' . htmlspecialchars($post['image']) . '" alt="' . htmlspecialchars($post['title']) . '" class="post-image">';
                }
                echo '<p class="post-content">' . substr(htmlspecialchars($post['content']), 0, 150) . '...</p>';
                echo '</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No results found.</p>';
        }
        ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
