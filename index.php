<?php
include './functions/functions.php';
include_once './includes/header.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_foto_album";
// Database connection
$conn = new mysqli($servername, $username, $password);
// $conn = new mysqli("localhost", "root", "", "pizza_order");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


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