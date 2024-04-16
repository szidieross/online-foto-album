<?php
require_once 'Database.php';
class ImageController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getAllImages()
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM images ORDER BY uploaded_at DESC");
        $stmt->execute();

        $result = $stmt->get_result();

        $images = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $images[] = $row;
            }
        }

        return $images;
    }

    public function getUserImages($userId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM images WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();

        $images = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $images[] = $row;
            }
        }

        return $images;
    }
    public function getImageById($imageId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM images WHERE image_id = ?");
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

    public function getImagesByTag($tagId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM images 
                            INNER JOIN image_tags ON images.image_id = image_tags.image_id
                            WHERE image_tags.tag_id = ?");
        $stmt->bind_param("i", $tagId);
        $stmt->execute();

        $result = $stmt->get_result();

        $images = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $images[] = $row;
            }
        }

        return $images;
    }

    public function getUserImagesByTag($userId, $tagId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM images 
                        INNER JOIN image_tags ON images.image_id = image_tags.image_id
                        WHERE images.user_id = ? AND image_tags.tag_id = ?");
        $stmt->bind_param("ii", $userId, $tagId);
        $stmt->execute();

        $result = $stmt->get_result();

        $images = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $images[] = $row;
            }
        }

        return $images;
    }


    public function uploadImage($userId, $fileName, $title)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO images (user_id, file_name, title) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $fileName, $title);

        if ($stmt->execute()) {
            $imageId = $conn->insert_id;
            $stmt->close();
            return $imageId;
        } else {
            echo "Hiba a kép feltöltése során: " . $stmt->error;
            return false;
        }
    }

    public function updateImage($imageId, $title, $tags)
    {
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

    public function deleteImage($imageId)
    {
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