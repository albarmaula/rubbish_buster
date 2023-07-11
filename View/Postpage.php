<?php
// Postpage.php

// Mengimpor file model yang diperlukan
session_start();
$email = $_SESSION['email'];
require_once '../Model/Post.php';
require_once '../Model/Comment.php';

// Membuat objek model Post dan Comment
$postModel = new Post();
$commentModel = new Comment();

// Memeriksa apakah ada permintaan POST untuk penambahan postingan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['content']) && isset($_FILES['image'])) {
    // Mengambil email dari sesi atau pengguna yang sedang masuk
    $email = $_SESSION['email']; // Gantikan dengan kunci sesi yang sesuai

    // Mengambil data dari form
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image'];

    // Membuat objek model Post
    $postModel = new Post();

    // Menyimpan data ke database menggunakan metode create pada model Post
    if ($postModel->create($title, $content, $image, $email)) {
        $response = array("message" => "Postingan berhasil disimpan");

        // Redirect ke halaman yang berbeda menggunakan metode GET
        header('Location: Postpage.php');
        exit();
    } else {
        $response = array("message" => "Gagal menyimpan postingan");
    }
}

// Memeriksa apakah ada permintaan POST untuk penambahan komentar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id']) && isset($_POST['email']) && isset($_POST['content'])) {
    // Mengambil data dari formulir
    $postId = $_POST['post_id'];
    $email = $_POST['email'];
    $content = $_POST['content'];

    // Menyimpan komentar ke dalam database
    if ($postModel->createComment($postId, $email, $content)) {
        $response = array("message" => "Komentar berhasil disimpan");
        // Redirect atau lakukan tindakan lain setelah berhasil menyimpan komentar
        // ...
    } else {
        $response = array("message" => "Gagal menyimpan komentar");
        // Handle jika gagal menyimpan komentar
        // ...
    }
    header('Location: Postpage.php');
    exit();
}
if (isset($_GET['success'])) {
    $successMessage = $_GET['success'];
    echo '<p class="success">' . $successMessage . '</p>';
}

if (isset($_GET['error'])) {
    $errorMessage = $_GET['error'];
    echo '<p class="error">' . $errorMessage . '</p>';
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Postingan</title>
  <link rel="stylesheet" href="../css/stylepost.css">
</head>
<body>
  <div class="navbar">
    <?php include(__DIR__ . "/navbar.php"); ?>
  </div><br><br>
  <div id="post-container" class="post-container">
      <?php
      // Mengimpor file model yang diperlukan
      require_once '../Model/Post.php';

      // Membuat objek model Post
      $postModel = new Post();

      // Mengambil semua postingan dari database
      $posts = $postModel->getAllPosts();

      // Menampilkan postingan
// ...
foreach ($posts as $post) {
    echo '<div class="post-item">';
    echo '<h3>' . $post['email'] . '</h3> <br>';
    echo '<img src="../post/' . $post['image_name'] . '" alt="Post Image">';
    echo '<h3>' . $post['title'] . '</h3>';
    echo '<p>' . $post['content'] . '</p>';

    // Tampilkan komentar
    $comments = $commentModel->getCommentsByPostId($post['id']);
    echo '<h4>Komentar: </h4>';
    echo '<div class="comments">';
    foreach ($comments as $comment) {
        echo '<div class="comment">';
        echo '<div class="comment-user">' . $comment['email'] . '</div>';
        echo '<div class="comment-content">' . $comment['content'] . '</div>';
        echo '<div class="comment-date">' . $comment['created_at'] . '</div>';
        echo '</div>';
    }
    echo '</div>';

    // Form komentar
    echo '<form class="comment-form" method="POST" action="Postpage.php">';
    echo '<input type="hidden" name="post_id" value="' . $post['id'] . '">';
    echo '<input type="hidden" name="email" value="' . $email . '">';
    echo '<textarea name="content" placeholder="Tambahkan komentar" required></textarea>';
    echo '<button type="submit">Kirim</button>';
    echo '</form>';

    echo '</div>';
}

// ...
      ?>

    </div>
  </div>
  <div class="floating-button">
    <a href="#" class="add-post-btn">+</a>
  </div>
  <div id="add-post-form" class="add-post-form hidden">
    <h2>Tambah Postingan</h2>
    <form id="post-form" method="POST" action="Postpage.php" enctype="multipart/form-data">
      <div class="form-group">
          <label for="title">Judul:</label>
          <input type="text" id="title" name="title">
      </div>
      <div class="form-group">
          <label for="content">Konten:</label>
          <textarea id="content" name="content"></textarea>
      </div>
      <div class="form-group">
          <label for="image">Gambar:</label>
          <input type="file" id="image" name="image">
      </div>
      <div class="form-group">
          <button type="submit">Tambahkan</button>
      </div>
    </form>
  </div>
  <script src="../js/post.js"></script>

  <div class="footer">
    <p>Hak Cipta &copy; 2023 Rubbish Buster. Semua hak dilindungi.</p>
    <p>Kontak: info@rubbishbuster.com | Telepon: 0856-4849-9655</p>
  </div>
</body>
</html>
</html>
