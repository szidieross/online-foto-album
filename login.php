<?php
// session_start();

include_once './includes/header.php';
include_once './controllers/UserController.php';
require_once 'controllers/Database.php';

$database = Database::getInstance();

if (isset($_SESSION["username"])) {
    header("Location: index.php");
}

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
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <div class="container">
        <div class="main-container">
            <div class="form" id="user-form">
                <h2>Login</h2>
                <form action="" method="post" class="form">
                    <label>Username</label>
                    <input type="text" name="username" class="form-text-input">
                    <label>Password</label>
                    <input type="password" name="password" class="form-text-input">
                    <input type="submit" name="login" class="submit" value="Login" class="form-button">
                </form>
                <p>Don't have an account yet? <a href="signup.php"> <button  class="form-button">Sign up</button></a></p>
            </div>
        </div>
    </div>
</body>

</html>
<?php
include_once './includes/footer.php';
?>