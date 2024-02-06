<?php
class User
{
    private Database $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($firstName, $lastName, $username, $email, $password, $role)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $firstName, $lastName, $username, $email, $password, $role);

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

}
?>