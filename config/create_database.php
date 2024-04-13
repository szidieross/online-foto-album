<?php

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "online_foto_album";

// $conn = new mysqli($servername, $username, $password);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $sql = "DROP DATABASE IF EXISTS $dbname";
// if ($conn->query($sql) === TRUE) {
//     echo "Database deleted successfully\n";
// } else {
//     echo "Error deleting database: " . $conn->error . "\n";
// }

// $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
// if ($conn->query($sql) === TRUE) {
//     echo "Database created successfully\n";
// } else {
//     echo "Error creating database: " . $conn->error . "\n";
// }

// $conn->select_db($dbname);

// $sql = "CREATE TABLE IF NOT EXISTS users (
//     user_id INT PRIMARY KEY AUTO_INCREMENT,
//     first_name VARCHAR(50),
//     last_name VARCHAR(50),
//     username VARCHAR(50),
//     email VARCHAR(50),
//     password VARCHAR(100),
//     role VARCHAR(20) NOT NULL
// )";

// if ($conn->query($sql) === TRUE) {
//     echo "Table 'users' created successfully\n";
// } else {
//     echo "Error creating table 'users': " . $conn->error . "\n";
// }

// $sql = "CREATE TABLE IF NOT EXISTS images (
//     image_id INT PRIMARY KEY AUTO_INCREMENT,
//     user_id INT,
//     file_name VARCHAR(255) NOT NULL,
//     title VARCHAR(255),
//     tags VARCHAR(255),
//     uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (user_id) REFERENCES users(user_id)
// )";

// if ($conn->query($sql) === TRUE) {
//     echo "Table 'images' created successfully\n";
// } else {
//     echo "Error creating table 'images': " . $conn->error . "\n";
// }

// $sql = "CREATE TABLE IF NOT EXISTS comments (
//     comment_id INT PRIMARY KEY AUTO_INCREMENT,
//     user_id INT,
//     image_id INT,
//     comment VARCHAR(255),
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (user_id) REFERENCES users(user_id),
//     FOREIGN KEY (image_id) REFERENCES images(image_id)
// )";

// if ($conn->query($sql) === TRUE) {
//     echo "Table 'comments' created successfully\n";
// } else {
//     echo "Error creating table 'comments': " . $conn->error . "\n";
// }

// $conn->close();
?>