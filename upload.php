<?php
// session_start();

include_once './includes/header.php';
require_once './controllers/Database.php';
require_once './controllers/ImageController.php';
require_once './controllers/UserController.php';
require_once './controllers/TagController.php';

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];
$userController = new UserController($db);
$imageController = new ImageController($db);
$tagController = new TagController($db);

$user = $userController->getUserByName($username);
$userId = $user["user_id"];
var_dump($user);
echo "userId: " . $userId;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    if (isset($_POST["title"]) && !empty($_POST["title"])) {
        $title = $_POST["title"];
    }
    if (isset($_POST["tags"]) && !empty($_POST["tags"])) {
        $tagsString = str_replace(' ', '', $_POST["tags"]);
        $tags = explode(',', $tagsString);
    }
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $image = $_FILES["image"];

        if ($image["size"] > 5 * 1024 * 1024) {
            echo "File is too large. Max file size is 5MB.";
            exit;
        }

        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        $fileExtension = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedTypes)) {
            echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit;
        }

        $fileName = uniqid() . "." . $fileExtension;

        $uploadDirectory = "uploads/";
        $destination = $uploadDirectory . $fileName;
        if (move_uploaded_file($image["tmp_name"], $destination)) {
            echo "Image uploaded successfully.";

            $db = Database::getInstance();
            $conn = $db->getConnection();

            $imageId = $imageController->uploadImage($userId, $fileName, $title);

            foreach ($tags as $tag) {
                $tagId = $tagController->createTag($tag);
                $tagController->attachTagToImage($imageId, $tagId);
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "No image selected.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <h2>Upload Image</h2>
    <form action="" method="post" enctype="multipart/form-data" class="form">
        <input type="file" name="image" accept="image/*" required>

        <label for="title">Title:</label>
        <input type="text" id="title" name="title"><br>

        <label for="tags">Tags:</label>
        <input type="text" id="tags" name="tags"><br>

        <input type="submit" value="Upload Image" name="submit" class="form-button">

    </form>
</body>

</html>

<?php
include_once './includes/footer.php';
?>