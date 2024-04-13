<?php
session_start();
require_once './controllers/Database.php';
require_once './controllers/UserController.php';

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Initialize Database and UserController
$db = Database::getInstance();
$userController = new UserController($db);

// Retrieve user data
$username = $_SESSION["username"];
$user = $userController->getUserByName($username);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];

    // Call updateUser function
    $userController->updateUser($firstName, $lastName, $username, $email, $user['user_id']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>

<body>
    <h1>Welcome, <?php echo $user['username']; ?>!</h1>
    <h2>Your Profile</h2>
    <form method="POST" action="">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>

        <input type="submit" name="submit" value="Update Profile">
    </form>
    <form method="POST" action="delete_account.php">
        <input type="submit" name="submit" value="Delete Account">
    </form>
    <a href="logout.php">Logout</a>
</body>

</html>
