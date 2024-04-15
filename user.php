<?php
session_start();
include_once './includes/header.php';
require_once './controllers/Database.php';
require_once './controllers/ImageController.php';
require_once './controllers/UserController.php';

// Initialize Database and ImageController
$db = Database::getInstance();
$imageController = new ImageController($db);
$userController = new UserController($db);

// Assume $userId contains the ID of the user whose images you want to fetch
// $userId = 5;
$username = $_SESSION["username"];
$user = $userController->getUserByName($username);
$userId = $user['user_id'];

echo "userId: " . $userId;
// Fetch images associated with the user
// $userImages = $imageController->getUserImages($userId);
$images = $imageController->getUserImages($userId);
var_dump($images);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Images</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <h1>User Images</h1>

    <h2>Filter user's images by category</h2>
    <select id="select-dropdown">
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
        <option value="option4">Option 4</option>
    </select>

    <div class="flex-box">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $image): ?>
                <div class="flex-item">
                    <form method="POST" action="image.php">
                        <input type="hidden" name="image_id" value="<?php echo $image['image_id']; ?>">
                        <!-- <a href="image/<?php echo $image['image_id']; ?>"> -->
                        <?php
                        $imagePath = "uploads/" . $image['file_name'];
                        ?>
                        <img src="<?php echo $imagePath; ?>" alt="Uploaded Image" class="flex-image">
                        <!-- </a> -->
                        <input type="submit" name="submit" value="Cim">
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No images found.</p>
        <?php endif; ?>
    </div>


</body>

</html>

<?php
include_once './includes/footer.php';
?>