<?php
include 'includes/db.php'; 

$username = '';
$password = '';
$usernameError = $passwordError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($username)) {
        $usernameError = "Username is required";
    }

    if (empty($password)) {
        $passwordError = "Password is required";
    }

    if (empty($usernameError) && empty($passwordError)) {

        $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

        if ($conn->query($query) === TRUE) {
            header('Location: index.php');
            exit();
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br>
                <span class="error"><?php echo $usernameError; ?></span>
            </div>

            <div class="form-group">
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br>
                <span class="error"><?php echo $passwordError; ?></span>
            </div>

            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>
</html>
