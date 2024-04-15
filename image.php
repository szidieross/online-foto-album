<?php
session_start();
include_once './includes/header.php';
require_once './controllers/Database.php';
require_once './controllers/ImageController.php';
require_once './controllers/UserController.php';

$db = Database::getInstance();
$imageController = new ImageController($db);
$userController = new UserController($db);

if (isset($_GET['image_id'])) {
    $imageId = $_GET['image_id'];
} else {
    header("Location: notfound.php");
    exit;
}
$image = $imageController->getImageById($imageId);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <h1>Image</h1>

    <?php if (!empty($image)): ?>
        <div class="image-holder">
            <?php
            $imagePath = "uploads/" . $image['file_name'];
            ?>
            <img src="<?php echo $imagePath; ?>" alt="Uploaded Image" class="image">
        </div>
    <?php else: ?>
        <p>No image found.</p>
    <?php endif; ?>

</body>

</html>

<?php
include_once './includes/footer.php';
?>