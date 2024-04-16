<?php
// session_start();
include_once './includes/header.php';
require_once './controllers/Database.php';
require_once './controllers/ImageController.php';
require_once './controllers/UserController.php';
require_once './controllers/TagController.php';

$db = Database::getInstance();
$imageController = new ImageController($db);
$userController = new UserController($db);
$tagController = new TagController($db);

if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
} else {
    header("Location: notfound.php");
    exit;
}

$userId = $_GET['user_id'];
$user = $userController->getUserById($userId);
$userName = $user["first_name"] . " " . $user["last_name"];

$tags = $tagController->getTagsByUserId($userId);

if (isset($_GET['tag_id'])) {
    $tagId = $_GET['tag_id'];
    $images = $imageController->getUserImagesByTag($userId, $tagId);
} else {
    $images = $imageController->getUserImages($userId);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $userName . "'s Gallery" ?></title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <div class="container">
        <h1><?php echo $userName . "'s Gallery" ?></h1>
        <h2>Filter by tags</h2>
        <select id="select-dropdown" class="select-dropdown">
            <option value="all" class="select-option" <?php echo !isset($_GET['tag_id']) || $_GET['tag_id'] == 'all' ? ' selected' : ''; ?>>All</option>
            <?php foreach ($tags as $tag): ?>
                <option value="<?php echo $tag['tag_id']; ?>" class="select-option" <?php echo isset($_GET['tag_id']) && $_GET['tag_id'] == $tag['tag_id'] ? ' selected' : ''; ?>><?php echo $tag['name']; ?></option>
            <?php endforeach; ?>
        </select>

        <div class="flex-box">
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $image): ?>
                    <div class="flex-item">
                        <a href="image.php?image_id=<?php echo $image['image_id']; ?>">
                            <?php
                            $imagePath = "uploads/" . $image['file_name'];
                            ?>
                            <img src="<?php echo $imagePath; ?>" alt="Uploaded Image" class="flex-image">
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No images found.</p>
            <?php endif; ?>
        </div>
    </div>
    <script>
        document.getElementById('select-dropdown').addEventListener('change', function () {
            var tagId = this.value;
            if (tagId === 'all') {
                location.href = 'user.php?user_id=<?php echo $userId; ?>';
            } else {
                location.href = 'user.php?user_id=<?php echo $userId; ?>&tag_id=' + tagId;
            }
        });
    </script>
</body>

</html>

<?php
include_once './includes/footer.php';
?>