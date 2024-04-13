<?php
session_start();
include_once ('./controllers/UserController.php');
require_once ('controllers/Database.php');

$database = Database::getInstance();

// if (isset($_SESSION["username"])) {
//     header("Location: index.php");
// }

if (isset($_POST["login"]) && $_SERVER['REQUEST_METHOD'] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $userHandler = new UserController($database);
    $userHandler->loginUser($username, $password);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="./assets/styles.css">
</head>

<body>
    <div class="container">
        <div class="main-container">
            <div class="form" id="user-form">
                <h2>Login as a User</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" class="button" value="Login">
                    </div>
                </form>
                <p>Don't have an account? <a href="signup.php"> <button class="button">Sign up</button></a></p>
            </div>
        </div>
    </div>
</body>

</html>