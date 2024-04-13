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
$user=$userController->getUserByName($username);
$userId = $user['user_id'];

echo "userId: ". $userId;
// Fetch images associated with the user
// $userImages = $imageController->getUserImages($userId);
$images = $imageController->getUserImages(5);
var_dump($images);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Images</title>
    <style>
        .image-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .image-item {
            margin: 10px;
        }

        .image-item img {
            width: 200px;
            height: auto;
        }
    </style>
</head>

<body>
    <h1>User Images</h1>

  

    <div class="grid-container">
    <?php if (!empty($images)): ?>
        <?php foreach ($images as $image): ?>
            <div class="grid-item">
                <?php
                $imagePath = "uploads/" . $image['file_name'];
                ?>
                <img src="<?php echo $imagePath; ?>" alt="Uploaded Image">
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
