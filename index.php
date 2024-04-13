<?php
include './functions/functions.php';
include_once './includes/header.php';

require_once './controllers/Database.php';

$db = Database::getInstance();


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

</body>

</html>

<?php
include_once './includes/footer.php';

$conn->close();
?>