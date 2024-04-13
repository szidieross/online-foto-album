<?php
include 'functions.php';
include_once './includes/header.php';

// PELDA
// Include the Pizza and Orders classes
require_once "Pizza.php";
require_once "Orders.php";


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

// Create an instance of Orders
$orders = new Orders($conn);

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerName = $_POST["customer_name"];
    $pizzaType = $_POST["pizza_type"];
    $pizzaSize = $_POST["pizza_size"];
    $toppings = $_POST["toppings"] ?? [];
    if(!empty($toppings)) {
        $toppings = implode(", ", $toppings);
    }
    $deliveryAddress = $_POST["delivery_address"];

    // Create an instance of Pizza
    $pizza = new Pizza($pizzaType, $pizzaSize, $toppings);

    // Place the order
    $orders->placeOrder($customerName, $pizza, $deliveryAddress);
} elseif (isset($_GET["delete"])) {
    $deleteOrderId = $_GET["delete"];
    $orders->deleteOrder($deleteOrderId);
}

// Display orders
$orderList = $orders->getOrders();


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