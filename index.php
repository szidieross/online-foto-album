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
    <h2>Filter by category</h2>
    <select id="select-dropdown" class="select-dropdown">
        <option value="option1" class="select-option">Option 1</option>
        <option value="option2" class="select-option">Option 2</option>
        <option value="option3" class="select-option">Option 3</option>
        <option value="option4" class="select-option">Option 4</option>
    </select>

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

</body>

</html>

<?php
include_once './includes/footer.php';
?>