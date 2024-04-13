<?php
session_start();

// if (!isset($_SESSION["username"])) {
//     header("Location: login.php"); // Redirect to login page if not logged in
//     exit;
// }

require_once './controllers/Database.php';
require_once './controllers/UserController.php';

$db = Database::getInstance();
$userController = new UserController($db);

$username = $_SESSION["username"];
$user = $userController->getUserByName($username);
$userId = $user['user_id'];
echo "userId: " . $userId;

// var_dump($user);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Call deleteUser function
    // $username = $_POST["username"];
    $userController->deleteUser($user['user_id']);
    header("Location: index.php");
}
?>