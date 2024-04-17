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

        $existingTag = $this->getTagByName($tagName);
        if ($existingTag) {
            return $existingTag['tag_id'];
        }

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

    public function getTagByName($tagName)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM tags WHERE name = ?");
        $stmt->bind_param("s", $tagName);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $tag = $result->fetch_assoc();
            return $tag;
        } else {
            return null;
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

    public function getTagsByUserId($userId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT DISTINCT t.* FROM tags t 
                            INNER JOIN image_tags it ON t.tag_id = it.tag_id
                            INNER JOIN images i ON it.image_id = i.image_id
                            WHERE i.user_id = ?");
        $stmt->bind_param("i", $userId);
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

    public function getTagsByImageId($imageId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT t.* FROM tags t 
                        INNER JOIN image_tags it ON t.tag_id = it.tag_id
                        WHERE it.image_id = ?");
        $stmt->bind_param("i", $imageId);
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


}