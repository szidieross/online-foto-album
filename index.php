<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery</title>
</head>
<body>
    <h1>Photo Gallery</h1>

    <!-- Form for uploading images -->
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image">
        <input type="submit" value="Upload Image">
    </form>

    <!-- Display images from the database -->
    <div class="gallery">
        <?php include 'functions.php'; ?>
        <?php $images = getImages(); ?>
        <?php foreach ($images as $image): ?>
            <div class="image">
                <img src="uploads/<?php echo $image['filename']; ?>" alt="<?php echo $image['title']; ?>">
                <p><?php echo $image['title']; ?></p>
                <!-- Add comment section here -->
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
