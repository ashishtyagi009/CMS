<?php
// Start session if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login_admin.php');
    exit();
}

include '../includes/db.php'; // Include database connection
include '../includes/admin_header.php'; // Include admin header

// Query to fetch posts with user information
$query = "SELECT posts.*, users.username 
          FROM posts 
          INNER JOIN users ON posts.user_id = users.id 
          ORDER BY posts.created_at DESC";
$result = $conn->query($query);
?>

<main>
    <div class="admin-manage-posts">
        <h2>Manage Posts</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($post = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($post['title']); ?></td>
                        <td><?php echo htmlspecialchars($post['username']); ?></td>
                        <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                        <td>
                            <a href="edit_post.php?id=<?php echo $post['post_id']; ?>">Edit</a>
                            <a href="delete_post.php?id=<?php echo $post['post_id']; ?>" class="delete-post" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<script src="js/admin_scripts.js"></script> <!-- Link to admin-specific JavaScript -->
<?php include '../includes/footer.php'; // Include footer ?>
</body>
</html>
