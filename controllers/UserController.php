<?php
require_once 'Database.php';
class UserController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUsers()
    {
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

    public function getUserById($userId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
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

    public function getUserByName($username)
    {
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

    public function updateUser($firstName, $lastName, $username, $email, $userId)
    {
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

    public function deleteUser($userId)
    {
        $conn = $this->db->getConnection();

        $sql = "DELETE FROM users WHERE user_id=?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("i", $userId);

        if (!$stmt->execute()) {
            die("Hiba az adat frissítése során: " . $stmt->error);
        }

        echo "User deleted.";
        $stmt->close();

        unset($_SESSION["username"]);
        session_destroy();
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
                $_SESSION["user_id"] = $row['user_id'];
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
        unset($_SESSION["username"]);
        session_destroy();
        exit;
    }

}
?>