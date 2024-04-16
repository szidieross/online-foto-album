<?php
require_once 'Database.php';


class TagController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getAllTags()
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM tags");
        $stmt->execute();

        $result = $stmt->get_result();

        $tags = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tags[] = $row;
            }
        }

        return $tags;
    }

    public function createTag($tagName)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO tags (name) VALUES (?)");
        $stmt->bind_param("s", $tagName);
        if ($stmt->execute()) {
            $tagId = $conn->insert_id;
            return $tagId;
        } else {
            echo "Error creating tag: " . $stmt->error;
            return false;
        }
    }

    public function attachTagToImage($imageId, $tagId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO image_tags (image_id, tag_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $imageId, $tagId);
        if ($stmt->execute()) {
            echo "Tag attached successfully to the image.";
            return true;
        } else {
            echo "Error attaching tag to image: " . $stmt->error;
            return false;
        }
    }

    public function getTagById($tagId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM tags WHERE tag_id = ?");
        $stmt->bind_param("i", $tagId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $image = $result->fetch_assoc();
            return $image;
        } else {
            return null;
        }
    }
}