<?php
// session_start();
include_once ("includes/header.php");
include_once ("classes/Database.php");
include_once ("controllers/UserController.php");
include_once ("controllers/DoctorController.php");

$database = Database::getInstance();
$userHandler = new UserController($database);

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

$id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT * FROM users WHERE user_id=?";
$stmt = $database->prepare($sql);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
    $firstName = $userData['first_name'];
    $lastName = $userData['last_name'];
    $username = $userData['username'];
    $email = $userData['email'];
} else {
    die("No user found with ID: " . $id);
}

$stmt->close();

if (isset($_POST['update']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $username = $_POST["username"];
    $email = $_POST["email"];

    if (empty($firstName) || empty($lastName) || empty($username) || empty($email)) {
        echo "All fields are required!";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
    } else if (isset($_SESSION['doctor'])) {
        $doctorHandler->updateDoctorData($firstName, $lastName, $id);
        $userHandler->updateUser($firstName, $lastName, $username, $email, $id);
    } else {
        $userHandler->updateUser($firstName, $lastName, $username, $email, $id);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szerkeszt</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <div class="container">
        <div>
            <a href="./logout.php"><button class="submit">Logout</button></a>
            <a href="index.php"><button class="button">Home</button></a>
        </div>
        <form method="POST" action="" class="form">
            <input type="hidden" name="id" class="form-text-input" value="<?php echo $userData["user_id"]; ?>">
            First Name: <input type="text" class="form-text-input" name="first_name" value="<?php echo $firstName; ?>"
                required><br><br>
            Last Name: <input type="text" class="form-text-input" name="last_name" value="<?php echo $lastName; ?>"
                required><br><br>
            Username: <input type="text" class="form-text-input" name="username" value="<?php echo $username; ?>"
                required><br><br>
            Email: <input type="email" class="form-text-input" name="email" value="<?php echo $email; ?>"
                required><br><br>
            <input type="submit" name="update" class="submit" value="Save changes" class="form-button">
        </form>
    </div>
</body>

</html>
<?php
include_once './includes/footer.php';
?>