<?php
include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Photo Gallery</h1>

    <h2>HOMEPAGE</h2>

    
    <!-- Form for uploading images -->
    <!-- <div class="upload-form">
        <h2>Upload Image</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="image" required>
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="description" placeholder="Description"></textarea>
            <input type="submit" value="Upload Image">
        </form>
    </div> -->

    <!-- Display images from the database -->
    <!-- <div class="gallery">
        <?php $images = getImages(); ?>
        <?php foreach ($images as $image): ?>
            <div class="image">
                <img src="uploads/<?php echo $image['filename']; ?>" alt="<?php echo $image['title']; ?>">
                <h3><?php echo $image['title']; ?></h3>
                <p><?php echo $image['description']; ?></p>
                <p>Uploaded by: <?php echo getUsernameById($image['user_id']); ?></p>
                <p>Uploaded at: <?php echo $image['uploaded_at']; ?></p>
                <form action="comment.php" method="post">
                    <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>">
                    <input type="text" name="comment" placeholder="Add a comment">
                    <input type="submit" value="Post Comment">
                </form>
                <?php $comments = getCommentsByImageId($image['id']); ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <p><?php echo getUsernameById($comment['user_id']); ?>:</p>
                        <p><?php echo $comment['comment']; ?></p>
                        <p><?php echo $comment['created_at']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div> -->
</body>
</html>
