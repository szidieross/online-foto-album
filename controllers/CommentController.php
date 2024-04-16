<?php
require_once 'Database.php';


class CommentController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createComment($userId, $imageId, $comment)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO comments (user_id, image_id, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $userId, $imageId, $comment);
        if ($stmt->execute()) {
            $commentId = $conn->insert_id;
            return $commentId;
        } else {
            echo "Error adding comment: " . $stmt->error;
            return false;
        }
    }

    public function getCommnentsByImageId($imageId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT comments.*, users.username, users.first_name, users.last_name 
                            FROM comments 
                            INNER JOIN users ON comments.user_id = users.user_id
                            WHERE image_id = ?");
        $stmt->bind_param("i", $imageId);
        $stmt->execute();

        $result = $stmt->get_result();

        $comments = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }
        }

        return $comments;
    }

    public function deleteComment($commentId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("DELETE FROM comments WHERE comment_id=?");
        $stmt->bind_param("s", $commentId);
        if ($stmt->execute()) {
            $commentId = $conn->insert_id;
            return $commentId;
        } else {
            echo "Error deleting comment: " . $stmt->error;
            return false;
        }
    }
}