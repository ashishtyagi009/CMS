<footer>
    <div class="container">
        <p>&copy; <?php echo date("Y"); ?> My CMS Project. All rights reserved.</p>
        <nav class="footer-navigation">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">My Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login_user.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</footer>

<style>
    .footer-navigation ul li a {
        color: #3498db;
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .footer-navigation ul li a:hover {
        color: #2980b9;
    }

    .footer-navigation ul li a:visited {
        color: #9b59b6;
    }

    .footer-navigation ul li a:focus, 
    .footer-navigation ul li a:active {
        color: #2c3e50;
    }

    footer {
        background-color: #2c3e50;
        color: #ecf0f1;
        padding: 20px 0;
    }

    footer p {
        color: #ecf0f1;
    }
</style>

<script src="js/scripts.js"></script>
</body>
</html>
