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

$msg = '';
if (isset($_GET['msg'])) {
    $msg = htmlspecialchars($_GET['msg']);
}

$query = "SELECT comments.*, users.username AS commenter, posts.title AS post_title 
          FROM comments 
          INNER JOIN users ON comments.user_id = users.id 
          INNER JOIN posts ON comments.post_id = posts.post_id 
          ORDER BY comments.created_at DESC";
$result = $conn->query($query);

if ($result === false) {
    echo "<p>Database query error: " . $conn->error . "</p>";
}
?>

<main>
    <div class="admin-manage-comments">
        <h2>Manage Comments</h2>
        <?php if ($msg): ?>
            <p class="message"><?php echo $msg; ?></p>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>Comment</th>
                    <th>Post</th>
                    <th>Commenter</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($comment = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($comment['content']); ?></td>
                            <td><?php echo htmlspecialchars($comment['post_title']); ?></td>
                            <td><?php echo htmlspecialchars($comment['commenter']); ?></td>
                            <td><?php echo htmlspecialchars($comment['created_at']); ?></td>
                            <td>
                                <a href="delete_comment.php?id=<?php echo $comment['comment_id']; ?>" class="delete-comment" onclick="return confirm('Are you sure you want to delete this comment?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No comments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<script src="js/admin_scripts.js"></script>
<?php include '../includes/footer.php';  ?>
</body>
</html>
