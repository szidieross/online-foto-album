<?php
session_start();
include_once './includes/header.php';
require_once './controllers/Database.php';
require_once './controllers/ImageController.php';
require_once './controllers/UserController.php';

$db = Database::getInstance();
$imageController = new ImageController($db);
$userController = new UserController($db);

if(isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
} else {
    header("Location: notfound.php");
    exit;
}
$images = $imageController->getUserImages($userId);
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
        <option value="option1">All</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
        <option value="option4">Option 4</option>
    </select>

    <div class="flex-box">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $image): ?>
                <div class="flex-item">
                    <a href="image.php?image_id=<?php echo $image['image_id']; ?>">
                        <?php
                        $imagePath = "uploads/" . $image['file_name'];
                        ?>
                        <img src="<?php echo $imagePath; ?>" alt="Uploaded Image" class="flex-image">
                    </a>
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