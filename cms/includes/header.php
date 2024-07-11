<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$projectName = "MY CMS Project";

$isUserLoggedIn = isset($_SESSION['user_id']);
$isAdminLoggedIn = isset($_SESSION['admin_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $projectName; ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js" defer></script>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="project-name">
                <h1><?php echo $projectName; ?></h1>
            </div>
            <nav class="navigation">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <?php if ($isUserLoggedIn): ?>
                        <li><a href="add_post.php">Add Post</a></li> 
                    <?php endif; ?>
                    <?php if ($isUserLoggedIn): ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login_user.php">Login</a></li>
                    <?php endif; ?>
            </nav>
            <div class="search-bar">
                <form action="search.php" method="GET">
                    <input type="text" name="query" placeholder="Search...">
                    <button type="submit">Search</button>
                </form>
            </div>
        </div>
    </header>
    <main>
