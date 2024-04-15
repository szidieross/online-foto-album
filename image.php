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

// Fetch the image data
$image = $imageController->getImageById(21);

var_dump($image);

// If the image data is found, display it
// if (!empty($image)) {
//     $imagePath = "uploads/" . $image['file_name'];
//     echo "<img src='$imagePath' alt='Uploaded Image'>";
// } else {
//     echo "No image found.";
// }
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
        <?php
        $imagePath = "uploads/" . $image['file_name'];
        ?>
        <img src="<?php echo $imagePath; ?>" alt="Uploaded Image">
    <?php else: ?>
        <p>No image found.</p>
    <?php endif; ?>

</body>

</html>

<?php
include_once './includes/footer.php';
?>
