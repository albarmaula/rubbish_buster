<?php

require_once(__DIR__."/../Model/Post.php");

class PostsController
{
    private $post;
    private $commentModel;

    public function __construct()
    {
        $this->post = new Post();
        $this->commentModel = new Comment();
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];

            $image = $_FILES['image'];

            $email = $_POST['email'];

            $imageName = $this->uploadImage($image);
            if ($imageName !== null) {
                $this->post->create($title, $content, $imageName,$email);

                // Redirect to homepage or any other page
                header('Location: Postpage.php');
                exit();
            } else {
                echo "Failed to upload image.";
            }
        }
    }

    private function uploadImage($image)
    {
        $targetDirectory = __DIR__ . "/../post/"; // Pindahkan ke direktori "post" di luar "Controller"
        $targetFile = $targetDirectory . basename($image['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($image['tmp_name']);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            $uploadOk = 0;
        }

        // Check file size
        if ($image['size'] > 500000) {
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif') {
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return null;
        } else {
            // Upload the file
            if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                return $image['name'];
            } else {
                return null;
            }
        }
    }


    public function getPostById($postId)
    {
        return $this->post->getPostById($postId);
    }

    public function deletePost($postId)
    {
        $this->post->deletePost($postId);
    }

    public function saveComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postId = $_POST['post_id'];
            $userId = $_POST['user_id'];
            $content = $_POST['content'];

            if ($this->commentModel->createComment($postId, $userId, $content)) {
                $response = array("message" => "Komentar berhasil disimpan");
            } else {
                $response = array("message" => "Gagal menyimpan komentar");
            }

            echo json_encode($response);
        }
    }

    public function getAllPosts()
    {
        $posts = $this->post->getAllPosts();
        foreach ($posts as &$post) {
            $post['comments'] = $this->commentModel->getCommentsByPostId($post['id']);
        }
        return $posts;
    }
}

?>
