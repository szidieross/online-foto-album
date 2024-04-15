<?php
include_once './includes/header.php';
require_once './controllers/Database.php';
require_once './controllers/ImageController.php';

$db = Database::getInstance();
$imageController = new ImageController($db);

$images = $imageController->getAllImages();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <h1>Photo Gallery</h1>
    <h2>HOMEPAGE</h2>

    <div class="flex-box">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $image): ?>
                <div class="flex-item">
                    <?php
                    $imagePath = "uploads/" . $image['file_name'];
                    ?>
                    <img src="<?php echo $imagePath; ?>" alt="Uploaded Image" class="flex-image">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No images found.</p>
        <?php endif; ?>
    </div>

    <!-- <div class="grid-container">
        <div class="grid-item">1</div>
        <div class="grid-item">2</div>
        <div class="grid-item">3</div>
        <div class="grid-item">4</div>
        <div class="grid-item">5</div>
        <div class="grid-item">6</div>
    </div> -->

</body>

</html>

<?php
include_once './includes/footer.php';
?>