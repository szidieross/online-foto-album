<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_foto_album";

// Function to establish database connection
function connect()
{
    global $servername, $username, $password, $dbname;
    $conn = mysqli_connect($servername, $username, $password);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $conn->select_db($dbname);
    return $conn;
}

// Function to add image to the database
function addImage($filename, $title)
{
    $conn = connect();
    $filename = mysqli_real_escape_string($conn, $filename);
    $title = mysqli_real_escape_string($conn, $title);
    $sql = "INSERT INTO images (filename, title) VALUES ('$filename', '$title')";
    if (mysqli_query($conn, $sql)) {
        echo "Image uploaded successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}

// Function to retrieve images from the database
function getImages()
{
    $conn = connect();
    $sql = "SELECT * FROM images";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    $images = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($conn);
    return $images;
}