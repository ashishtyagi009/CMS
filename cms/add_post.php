<?php
include 'includes/db.php'; 
include 'includes/header.php'; 

$title = $content = '';
$imageError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $user_id = $_SESSION['user_id']; 

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_type = $_FILES['image']['type'];
        
        $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
        if (!in_array($image_type, $allowed_types)) {
            $imageError = "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
        } else {
            $upload_path = 'images/' . $image_name;
            if (move_uploaded_file($image_tmp, $upload_path)) {
                 $query = "INSERT INTO posts (title, content, image, created_at, user_id) 
                          VALUES ('$title', '$content', '$image_name', NOW(), $user_id)";

                if ($conn->query($query) === TRUE) {
                    echo "<p>Post added successfully!</p>";
                    header('Location: index.php');
                    exit();
                } else {
                    echo "Error: " . $query . "<br>" . $conn->error;
                }
            } else {
                $imageError = "Error uploading file. Please try again.";
            }
        }
    } else {
        $imageError = "Error uploading file. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Post</title>
    <link rel="stylesheet" href="css/add_post.css">
</head>

<main>
    <div class="container">
        <h2>Add New Post</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label><br>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required><br>
            </div>

            <div class="form-group">
                <label for="content">Content:</label><br>
                <textarea id="content" name="content" rows="4" required><?php echo htmlspecialchars($content); ?></textarea><br>
            </div>

            <div class="form-group">
                <label for="image">Image:</label><br>
                <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/gif" required><br>
                <span class="error"><?php echo $imageError; ?></span>
            </div>

            <button type="submit">Add Post</button>
        </form>
    </div>
</main>

<?php include 'includes/footer.php'; // Include footer ?>
</body>
</html>
