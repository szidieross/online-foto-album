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

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $user = $userController->getUserByName($username);
    $currentUserId = $user['user_id'];
}

$imageId = $_GET['image_id'];
$image = $imageController->getImageById($imageId);
$title = $image["title"];
$userId = $image["user_id"];
$imagesUser = $userController->getUserById($userId);
$imageUserName = $imagesUser["username"];
$imagesUserName = $imagesUser["first_name"] . " " . $imagesUser["last_name"];

if (isset($_SESSION["username"]) && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_comment"])) {
    if (!empty($_POST["comment"])) {

        $username = $_SESSION["username"];
        $user = $userController->getUserByName($username);
        $userId = $user['user_id'];

        $comment = $_POST["comment"];
        $commentController->createComment($userId, $imageId, $comment);
        header("Location: image.php?image_id=" . $imageId);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_comment"])) {
    $commentId = $_POST["comment_id"];
    $commentController->deleteComment($commentId);
    header("Location: image.php?image_id=" . $imageId);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_image"])) {
    $imageController->deleteImage($imageId);
    header("Location: user.php?user_id=" . $currentUserId);
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
        <h1><?php echo $title . " by <a class='link' href='user.php?user_id=" . $userId . "'>" . $imagesUserName . "</a>"; ?>
        </h1>

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

        <?php if (isset($_SESSION['username']) && $_SESSION['username'] == $imageUserName): ?>
            <button id="updateImageButton" class='delete-button'>
                <img src='./assets/images/settings.svg' alt='Settings'>
            </button>

            <div id="updateImageModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Update Image</h2>
                    <form action="" method="post" enctype="multipart/form-data" class="update-form">
                        <label for="newTitle">New Title:</label><br>
                        <input type="text" id="newTitle" name="newTitle" required><br><br>
                        <label for="newImage">New Image:</label><br>
                        <input type="file" id="newImage" name="newImage" accept="image/*" required><br><br>
                        <input type="submit" class="submit" value="Update" name="update_image">
                    </form>
                    <form action="" method="post">
                        <input type="submit" class="submit" value="Delete Image" name="delete_image">
                    </form>
                </div>
            </div>

            <div id="modalBackdrop" class="modal-backdrop"></div>

        <?php endif; ?>


        <form action="" method="post" class="comment-form">

            <?php if (isset($_SESSION["username"])): ?>
                <div class="comment-container">
                    <label for="comment" class="comment-form-label">Add a comment:</label><br>
                    <textarea id="comment" class="comment-textarea" name="comment" rows="4" cols="50"
                        required></textarea><br>
                    <input type="submit" class="submit" value="Submit" name="submit_comment">
                </div>

            <?php else: ?>
                <div class="comment-container">
                    <p class="comment-form-label">Log in to comment</p>
                </div>
            <?php endif ?>
        </form>

        <div class="comments-section">
            <div class="comments-container">
                <h2>Comments</h2>
                <?php
                $comments = $commentController->getCommnentsByImageId($imageId);

                if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class='comment'>
                            <a class="comment-user" href="user.php?user_id=<?php echo $comment['user_id']; ?>">
                                <?php echo $comment['first_name'] . ' ' . $comment['last_name']; ?>
                            </a>
                            <p class="comment-text"><?php echo $comment['comment']; ?></p>
                            <p class="comment-date">
                                <?php echo date('F d, Y H:i', strtotime($comment['created_at'])); ?>
                            </p>

                            <?php if ($currentUserId == $comment['user_id'] || $_SESSION['username'] == $imageUserName): ?>
                                <form action='' method='post'>
                                    <input type='hidden' name='comment_id' value='<?php echo $comment['comment_id']; ?>'>
                                    <button type='submit' name='delete_comment' class='delete-button'>
                                        <img src='./assets/images/delete.svg' alt='Delete'>
                                    </button>
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
    <script>
        var updateImageButton = document.getElementById("updateImageButton");
        var updateImageModal = document.getElementById("updateImageModal");
        var modalBackdrop = document.getElementById("modalBackdrop");

        updateImageButton.onclick = function () {
            updateImageModal.style.display = "block";
            modalBackdrop.style.display = "block";
        }

        var closeButtons = document.getElementsByClassName("close");
        for (var i = 0; i < closeButtons.length; i++) {
            closeButtons[i].onclick = function () {
                updateImageModal.style.display = "none";
                modalBackdrop.style.display = "none";
            }
        }

        window.onclick = function (event) {
            if (event.target == updateImageModal) {
                updateImageModal.style.display = "none";
                modalBackdrop.style.display = "none";
            }
        }

    </script>
</body>

</html>

<?php
include_once './includes/footer.php';
?>