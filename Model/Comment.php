<?php
require_once '../Database/CommentDB.php';

class Comment extends CommentDB
{
    public function createComment($postId, $userId, $content)
    {
        $query = "INSERT INTO comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->bind_param("iis", $postId, $userId, $content);
        return $stmt->execute();
    }

    public function getCommentsByPostId($postId)
    {
        $query = "SELECT * FROM comments WHERE post_id = ?";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
