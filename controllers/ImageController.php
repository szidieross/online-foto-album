<?php
class ImageController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Összes kép lekérdezése az adatbázisból
    public function getAllImages() {
        // Adatbázisból lekérdezés
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM images ORDER BY uploaded_at DESC");
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $image = $result->fetch_assoc();
            return $image;
        } else {
            return null;
        }
    }

    // Egy adott kép adatainak lekérdezése
    public function getImageById($imageId) {
        // Adatbázisból lekérdezés az azonosító alapján
    }

    // Új kép feltöltése
    public function uploadImage($imageData) {
        // Adatbázisba új kép feltöltése
    }

    // Egy felhasználóhoz tartozó képek lekérdezése
    public function getUserImages($userId) {
        // Adatbázisból lekérdezés a felhasználó azonosítója alapján
    }

    // Kép adatainak frissítése
    public function updateImage($imageId, $newData) {
        // Adatbázisban a kép adatainak frissítése
    }

    // Kép törlése
    public function deleteImage($imageId) {
        // Adatbázisból kép törlése
    }
}
?>
