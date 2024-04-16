<?php
// session_start();

include_once './includes/header.php';
require_once './controllers/Database.php';
require_once './controllers/ImageController.php';
require_once './controllers/UserController.php';

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];
$userController = new UserController($db);
$imageController = new ImageController($db);
$user = $userController->getUserByName($username);
$userId = $user["user_id"];
var_dump($user);
echo "userId: " . $userId;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Check if file was uploaded without errors
    if (isset($_POST["title"]) && !empty($_POST["title"])) {
        $title = $_POST["title"];
    }
    if (isset($_POST["tags"]) && !empty($_POST["tags"])) {
        $tags = explode(',', $_POST["tags"]);
    }
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $image = $_FILES["image"];

        // Check file size (max 5MB)
        if ($image["size"] > 5 * 1024 * 1024) {
            echo "File is too large. Max file size is 5MB.";
            exit;
        }

        // Allow only certain file formats
        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        $fileExtension = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedTypes)) {
            echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit;
        }

        // Generate a unique filename to prevent overwriting existing files
        $fileName = uniqid() . "." . $fileExtension;

        // Move the uploaded file to the desired directory
        $uploadDirectory = "uploads/";
        $destination = $uploadDirectory . $fileName;
        if (move_uploaded_file($image["tmp_name"], $destination)) {
            // Image uploaded successfully
            echo "Image uploaded successfully.";

            // Insert image information into the database
            $db = Database::getInstance();
            $conn = $db->getConnection();

            // $imageController->uploadImage($userId, $fileName, $title);
            $imageId=$imageController->uploadImage($userId, $fileName, $title);

            foreach ($tags as $tag) {
                $tagId = $imageController->createTag($tag); // Create tag if it doesn't exist
                $imageController->attachTagToImage($imageId, $tagId); // Attach tag to the uploaded image
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