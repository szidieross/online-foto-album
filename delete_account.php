<?php
// session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

require_once './controllers/UserController.php';
require_once './controllers/Database.php';

$db = Database::getInstance();
$userController = new UserController($db);

$username = $_SESSION["username"];
$user = $userController->getUserByName($username);
$userId = $user['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Call deleteUser function
    // $username = $_POST["username"];
    $userController->deleteUser($user['user_id']);
    header("Location: index.php");
}
?>