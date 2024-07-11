<?php
include 'includes/db.php';

session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            header('Location: index.php');
            exit();
        } else {
            $error = 'Invalid username or password.';
        }
    } else {
        $error = 'Please fill in both fields.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="login-form">
    <h2>User Login</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
        </div>
        <div class="form-group">
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
        </div>
        <button type="submit">Login</button>
        <p class="error"><?php echo $error; ?></p>
        <p><a href="signup.php">Create an account</a></p>
    </form>
</div>
</body>
</html>
