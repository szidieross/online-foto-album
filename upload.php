<?php
include 'functions.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $title = $_FILES["image"]["name"];
    $file_temp = $_FILES["image"]["tmp_name"];
    $file_name = basename($_FILES["image"]["name"]);
    $upload_dir = "uploads/";

    // Upload image
    if (move_uploaded_file($file_temp, $upload_dir . $file_name)) {
        // Add image data to database
        addImage($file_name, $title);
        header("Location: index.php");
        exit;
    } else {
        echo "Failed to upload image.";
    }
}
?>
