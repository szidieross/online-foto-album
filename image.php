<?php
// session_start();
include_once './includes/header.php';
require_once './controllers/Database.php';
require_once './controllers/ImageController.php';
require_once './controllers/UserController.php';
require_once './controllers/CommentController.php';

$db = Database::getInstance();
$imageController = new ImageController($db);
$userController = new UserController($db);
$commentController = new CommentController($db);

if (isset($_GET['image_id'])) {
    $imageId = $_GET['image_id'];
} else {
    header("Location: notfound.php");
    exit;
}
$image = $imageController->getImageById($imageId);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_comment"])) {
    if (!empty($_POST["comment"])) {
        $username = $_SESSION["username"];
        $user = $userController->getUserByName($username);
        $userId = $user['user_id'];

        $comment = $_POST["comment"];
        $commentController->createComment($userId, $imageId, $comment);
    }
}
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


    <form action="" method="post">
        <label for="comment">Add a comment:</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br>
        <input type="submit" value="Submit" name="submit_comment">
    </form>

    <div class="comments-section">
        <h2>Comments</h2>
        <?php
        $comments = $commentController->getCommnentsByImageId($imageId);
        if (!empty($comments)) {
            foreach ($comments as $comment) {
                echo "<p>{$comment['comment']}</p>";
            }
        } else {
            echo "<p>No comments yet.</p>";
        }
        ?>
    </div>

</body>

</html>

<?php
include_once './includes/footer.php';
?>