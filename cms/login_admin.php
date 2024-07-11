<?php
include 'includes/db.php';
include 'includes/functions.php';

session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND is_admin = 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            header('Location: admin/dashboard.php');
            exit();
    } else {
        $error = 'Invalid username or password or not an admin.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="login-form">
    <h2>Admin Login</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
        <p><?php echo $error; ?></p>
    </form>
</div>
</body>
</html>
