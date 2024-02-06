<?php
include 'config.php';

// Function to establish database connection
function connect() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

// Function to add image to the database
function addImage($filename, $title) {
    $conn = connect();
    $sql = "INSERT INTO images (filename, title) VALUES ('$filename', '$title')";
    if (mysqli_query($conn, $sql)) {
        echo "Image uploaded successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}

// Function to retrieve images from the database
function getImages() {
    $conn = connect();
    $sql = "SELECT * FROM images";
    $result = mysqli_query($conn, $sql);
    $images = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($conn);
    return $images;
}
?>
