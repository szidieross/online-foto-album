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

$imageId = $_GET['image_id'];
$image = $imageController->getImageById($imageId);
$title = $image["title"];
$userId = $image["user_id"];
$imagesUser = $userController->getUserById($userId);
$imageUserName = $imagesUser["username"];
$imagesUserName = $imagesUser["first_name"] . " " . $imagesUser["last_name"];

$username = $_SESSION["username"];
$user = $userController->getUserByName($username);
$currentUserId = $user['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_comment"])) {
    if (!empty($_POST["comment"])) {
        $user = $userController->getUserByName($username);
        $userId = $user['user_id'];

        $comment = $_POST["comment"];
        $commentController->createComment($userId, $imageId, $comment);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_comment"])) {
    $commentId = $_POST["comment_id"];
    $commentController->deleteComment($commentId);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title . " by " . $imagesUserName ?></title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <div class="container">
        <h1><?php echo $title . " by " . $imagesUserName ?></h1>

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


        <form action="" method="post" class="comment-form">
            <div class="comment-container">
                <label for="comment" class="comment-form-label">Add a comment:</label><br>
                <textarea id="comment" class="comment-textarea" name="comment" rows="4" cols="50"
                    required></textarea><br>
                <input type="submit" class="submit" value="Submit" name="submit_comment">
            </div>
        </form>

        <div class="comments-section">
            <div class="comments-container">
                <h2>Comments</h2>
                <?php
                $comments = $commentController->getCommnentsByImageId($imageId);

                if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class='comment'>
                            <p><?php echo $comment['comment']; ?></p>
                            <p>By:
                                <?php echo $comment['first_name'] . ' ' . $comment['last_name'] . ' (' . $comment['username'] . ')'; ?>
                            </p>
                            <p>Date: <?php echo $comment['created_at']; ?></p>

                            <?php if ($currentUserId == $comment['user_id'] || $_SESSION['username'] == $imageUserName): ?>
                                <form action='' method='post'>
                                    <input type='hidden' name='comment_id' value='<?php echo $comment['comment_id']; ?>'>
                                    <input class="submit" type='submit' value='Delete' name='delete_comment'>
                                </form>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No comments yet.</p>
                <?php endif; ?>

            </div>
        </div>

    </div>
</body>

</html>

<?php
include_once './includes/footer.php';
?>