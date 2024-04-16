<?php
// session_start();
require_once './includes/header.php';
require_once './controllers/Database.php';
require_once './controllers/UserController.php';

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$db = Database::getInstance();
$userController = new UserController($db);

$username = $_SESSION["username"];
$user = $userController->getUserByName($username);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];

    $userController->updateUser($firstName, $lastName, $username, $email, $user['user_id']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <div class="container">
        <h1>Welcome, <?php echo $user['first_name']; ?>!</h1>
        <h2>Your Profile</h2>
        <form method="POST" action="" class="form">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" class="form-text-input" name="first_name"
                value="<?php echo $user['first_name']; ?>" required><br><br>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" class="form-text-input"
                value="<?php echo $user['last_name']; ?>" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-text-input" value="<?php echo $user['email']; ?>"
                required><br><br>

            <input type="submit" name="submit" value="Update Profile" class="submit">
        </form>
        <form method="POST" action="delete_account.php" class="form">
            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
            <input type="submit" name="submit" value="Delete Account" class="submit">
        </form>

        <a href="logout.php" class="submit">Logout</a>
    </div>
</body>

</html>

<?php
include_once './includes/footer.php';
?>