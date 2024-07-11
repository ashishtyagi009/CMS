<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Posts</title>
    <link rel="stylesheet" href="css/index.css">
    <style>
        .post {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ccc;
        }
        .post h3 {
            margin-top: 0;
        }
        .post img {
            max-width: 100%;
            max-height: 150px; 
            width: auto;
            height: auto;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .post p {
            line-height: 1.6;
        }
        .post .read-more {
            display: inline-block;
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .post .read-more:hover {
            background-color: #0056b3;
        }
.post .read-more {
    display: inline-block;
    padding: 8px 16px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.post .read-more:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <div class="container">
            <h2>Latest Posts</h2>

            <?php
            include 'includes/db.php';

            $sql = "SELECT * FROM posts ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $post_id = $row['post_id'];
                    $title = $row['title'];
                    $content = $row['content'];
                    $created_at = $row['created_at'];
                    $image = $row['image']; 
                    
                    echo "<div class='post'>";
                    echo "<h3>$title</h3>";
                    if (!empty($image)) {
                        echo "<img src='images/$image' alt='$title'>";
                    }
                    echo "<p>$content</p>";
                    echo "<p><em>Posted on: $created_at</em></p>";
                    echo "<a href='post.php?id=$post_id' class='read-more'>Read more</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>No posts found.</p>";
            }

            $conn->close();
            ?>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
