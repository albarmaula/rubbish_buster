<?php
require_once(__DIR__ . "/../Database/PostDB.php");

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new PostDB();
    }

    public function create($title, $content, $image,$email)
    {
        $imageName = $image['name'];
        $imagePath = $image['tmp_name'];

        // Pindahkan file gambar ke direktori yang diinginkan
        $targetDirectory = "../post/";
        $targetFile = $targetDirectory . basename($imageName);

        if (move_uploaded_file($imagePath, $targetFile)) {
            // Simpan data ke database
            $query = "INSERT INTO posts (title, content, image_name,email) VALUES (?, ?, ?,?)";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param("ssss", $title, $content, $imageName, $email);
            
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getAllPosts()
    {
        $query = "SELECT * FROM posts ORDER BY id DESC";
        $result = $this->db->getConnection()->query($query);

        $posts = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
        }

        return $posts;
    }
    public function createComment($postId, $email, $content)
    {
        $query = "INSERT INTO comments (post_id, email, content, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bind_param("iss", $postId, $email, $content);

        return $stmt->execute();
    }

    public function getCommentsByPostId($postId)
    {
        $query = "SELECT * FROM comments WHERE post_id = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

}
?>
