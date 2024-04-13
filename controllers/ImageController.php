<?php
require_once 'Database.php';
class ImageController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Összes kép lekérdezése az adatbázisból
    // public function getAllImages()
    // {
    //     // Adatbázisból lekérdezés
    //     $conn = $this->db->getConnection();
    //     $stmt = $conn->prepare("SELECT * FROM images ORDER BY uploaded_at DESC");
    //     $stmt->execute();

    //     $result = $stmt->get_result();

    //     if ($result->num_rows > 0) {
    //         $image = $result->fetch_assoc();
    //         return $image;
    //     } else {
    //         return null;
    //     }
    // }
    // Change the return type of the getAllImages() method to return an array of images
    public function getAllImages()
    {
        // Adatbázisból lekérdezés
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM images ORDER BY uploaded_at DESC");
        $stmt->execute();

        $result = $stmt->get_result();

        $images = []; // Initialize an empty array to store images

        if ($result->num_rows > 0) {
            // Fetch all rows and store them in the $images array
            while ($row = $result->fetch_assoc()) {
                $images[] = $row;
            }
        }

        return $images; // Return the array of images
    }


    // Egy adott kép adatainak lekérdezése
    public function getImageById($imageId)
    {
        // Adatbázisból lekérdezés az azonosító alapján
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM images WHERE id = ?");
        $stmt->bind_param("i", $imageId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $image = $result->fetch_assoc();
            return $image;
        } else {
            return null;
        }
    }

    // Új kép feltöltése
    public function uploadImage($userId, $fileName, $title, $tags)
    {
        // Adatbázisba új kép feltöltése
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO images (user_id, file_name, title, tags) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $userId, $fileName, $title, $tags);

        if ($stmt->execute()) {
            $imageId = $conn->insert_id;
            return $imageId;
        } else {
            echo "Hiba a kép feltöltése során: " . $stmt->error;
            return false;
        }
    }


    // Egy felhasználóhoz tartozó képek lekérdezése
    public function getUserImages($userId)
    {
        // Adatbázisból lekérdezés a felhasználó azonosítója alapján
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM images WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $image = $result->fetch_assoc();
            return $image;
        } else {
            echo "Hiba a képek lekérdezése során: " . $stmt->error;
            return null;
        }
    }

    // Kép adatainak frissítése
    public function updateImage($imageId, $title, $tags)
    {
        // Adatbázisban a kép adatainak frissítése
        $conn = $this->db->getConnection();

        $sql = "UPDATE images SET title=?, tags=? WHERE image_id=?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssssi", $title, $tags);

        if (!$stmt->execute()) {
            die("Hiba az adat frissítése során: " . $stmt->error);
        }
        echo "Changes saved.";
        $stmt->close();
    }

    // Kép törlése
    public function deleteImage($imageId)
    {
        // Adatbázisból kép törlése
        $conn = $this->db->getConnection();

        $sql = "DELETE images WHERE image_id=?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("i", $imageId);

        if (!$stmt->execute()) {
            die("Hiba az adat frissítése során: " . $stmt->error);
        }

        echo "Image deleted.";
        $stmt->close();
    }
}
?>