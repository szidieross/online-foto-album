<?php
require_once 'Database.php';
class UserController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Az összes felhasználó adatainak lekérdezése
    public function getUsers()
    {
        // Adatbázisból lekérdezés az azonosító alapján
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM users");
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return $user;
        } else {
            return null;
        }
    }

    // Egy adott felhasználó adatainak lekérdezése
    public function getUserById($userId)
    {
        // Adatbázisból lekérdezés az azonosító alapján
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE iserId = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return $user;
        } else {
            return null;
        }
    }

    // Egy adott felhasználó adatainak lekérdezése
    public function getUserByName($username)
    {
        // Adatbázisból lekérdezés az azonosító alapján
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return $user;
        } else {
            return null;
        }
    }

    // Felhasználó adatainak frissítése
    public function updateUser($firstName, $lastName, $username, $email, $userId)
    {
        // Adatbázisban a felhasználó adatainak frissítése
        $conn = $this->db->getConnection();

        $sql = "UPDATE users SET first_name=?, last_name=?, username=?, email=? WHERE user_id=?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssssi", $firstName, $lastName, $username, $email, $userId);

        if (!$stmt->execute()) {
            die("Hiba az adat frissítése során: " . $stmt->error);
        }

        $_SESSION["username"] = $username;
        echo "Changes saved.";
        $stmt->close();
    }

    // Felhasználó törlése
    public function deleteUser($userId, $username)
    {
        // Adatbázisból felhasználó törlése
        $conn = $this->db->getConnection();

        $sql = "DELETE users WHERE user_id=?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("i", $userId);

        if (!$stmt->execute()) {
            die("Hiba az adat frissítése során: " . $stmt->error);
        }


        $_SESSION["username"] = $username;
    
        $this->logoutUser();
        echo "User deleted.";
        $stmt->close();
    }
    public function createUser($firstName, $lastName, $username, $email, $password)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstName, $lastName, $username, $email, $password);

        if ($stmt->execute()) {
            $userId = $conn->insert_id;
            return $userId;
        } else {
            echo "Hiba a felhasználó létrehozása során: " . $stmt->error;
            return false;
        }
    }

    public function loginUser($username, $password)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT username, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Hiba a lekerdezes elokeszitese soran: " . $conn->error);
        }

        $stmt->bind_param("s", $username);

        if (!$stmt->execute()) {
            die("Hiba a lekerdezes soran: " . $conn->error);
        }

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                $_SESSION["username"] = $username;
                header("Location: index.php");
            } else {
                echo "Wrong password";
            }
        } else {
            echo "This username doesn't exist.";
        }
    }

    public function logoutUser()
    {
        echo "hello logout";
        session_start();
        unset($_SESSION["username"]);
        session_destroy();

        // header("Location: ../home.php");
        exit;
    }

}
?>