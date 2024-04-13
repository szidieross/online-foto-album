<?php
session_start();
require_once ('controllers/UserController.php');
require_once ('controllers/Database.php');

// if (isset($_SESSION["username"])) {
//     header("Location: index.php");
// }

if (isset($_POST["sign_up"]) && $_SERVER['REQUEST_METHOD'] === "POST") {

    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $rawPassword = $_POST["password"];
    $confirmedPassword = $_POST["confirmPassword"];

    if (empty($firstName) || empty($lastName) || empty($username) || empty($email) || empty($rawPassword)) {
        echo "All fields are required!";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
    } else if (strlen($rawPassword) < 6) {
        echo "Password must be at least 6 characters long!";
    } else if ($rawPassword !== $confirmedPassword) {
        echo "Passwords do not match!";
    } else {

        $password = password_hash($rawPassword, PASSWORD_DEFAULT);

        $database = Database::getInstance();
        $userHandler = new UserController($database);

        $userExists = $userHandler->getUserByName($username);
        if ($userExists) {
            echo "This username is already taken, please choose another one.";
        } else {
            $result = $userHandler->createUser($firstName, $lastName, $username, $email, $password);
            if ($result) {
                echo "Registration successful!";
            } else {
                echo "Error occurred during registration!";
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./assets/styles.css">
</head>

<body>
    <div class="container">
        <p>Already have an account?</p>
        <a href="login.php">
            <button class="button">Sign in</button></a>
        <h2>Regisztralj</h2>

        <form method="POST" action="">
            First Name: <input type="text" name="first_name" id="" required><br><br>
            Last Name: <input type="text" name="last_name" id="" required><br><br>
            Username: <input type="text" name="username" id="" required><br><br>
            Email: <input type="email" name="email" id="" required><br><br>
            Password: <input type="password" name="password" id="" required><br><br>
            Confirm Password: <input type="password" name="confirmPassword" id="" required><br><br>
            <input type="submit" name="sign_up" class="button" value="Sign Up">
        </form>
        <p>Already have an account? <a href="login.php"> <button class="button">Sign in</button></a></p>
    </div>
</body>

</html>