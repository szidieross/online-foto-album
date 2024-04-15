<?php
require_once './controllers/Database.php';
require_once './controllers/UserController.php';

$db = Database::getInstance();
$userController = new UserController($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <header>
        <h1 class="header-title">Online Photo Album</h1>
        <nav class="header-menu">
            <a href="index.php" class="menu-item">Home</a>
            <a href="upload.php" class="menu-item">Upload</a>
            <?php if (isset($_SESSION["username"])): ?>
                <a href="profile.php" class="menu-item">Profile</a>
                <a href="logout.php" class="menu-item">Logout</a>
            <?php else: ?>
                <a href="login.php" class="menu-item">Login</a>
                <a href="signup.php" class="menu-item">Signup</a>
            <?php endif; ?>
        </nav>
    </header>
</body>

</html>