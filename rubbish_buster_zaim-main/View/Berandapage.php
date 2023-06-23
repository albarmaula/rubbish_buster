<!DOCTYPE html>
<html>
<head>
  <title>Beranda</title>
  <link rel="stylesheet" href="../css/styleberanda.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>
<body>
  <div class="navbar">
    <?php
    require_once(__DIR__ . "/../Controller/UserController.php");

    // Inisialisasi UserController
    $userController = new UserController();

    // Memeriksa apakah pengguna telah login
    if ($userController->isLoggedIn()) {
        // Mengambil username dari UserController
        $username = $userController->getUsername();

        // Menampilkan username di sebelah kiri atas navbar
        echo '<p class="username">' . $username . '</p>';
    }
    ?>
    <a href="#profil">Profil</a>
    <a href="#post">Post</a>
    <a href="#voluntir">Voluntir</a>
    <a href="#beranda">Beranda</a>
  </div>

  <div id="map"></div>

  <div class="body">
    <p>Rubbish Buster adalah sebuah konsep atau program yang bertujuan untuk mengurangi dan mengatasi masalah sampah atau limbah di suatu wilayah atau komunitas tertentu. Tujuan utama dari Rubbish Buster adalah untuk meningkatkan kesadaran dan partisipasi masyarakat dalam mengelola sampah dengan cara yang lebih bertanggung jawab dan berkelanjutan.</p>
    <button class="btn_lapor">Lapor Sampah</button>
  </div>
  
  <div class = "board">
    <img src="../image/image_sampah.jpg" />
    <div style="text-align: center; color: white;  font-family: Inter; font-weight: 700; word-wrap: break-word">Berdasarkan data Sistem Informasi Pengelolaan Sampah Nasional (SIPSN) Kementerian 
      Lingkungan Hidup dan Kehutanan (KLHK), volume timbulan sampah di Indonesia pada 2022 
      mencapai 19,45 juta ton. Angka tersebut menurun 37,52% dari 2021 yang sebanyak 31,13 juta ton.</div>
  </div>

<div class = "isi">“Menjaga kebersihan lingkungan merupakan tanggung jawab bagi setiap manusia. Karena tubuh<br/>manusia yang sehat berasal dari lingkungan yang sehat dan bersih,<br/>” kata Kepala DLH Kota Kota Palangka Raya,Ahmad Zain</div>
  
<div class="footer">
    <p>Hak Cipta &copy; 2023 Rubbish Buster. Semua hak dilindungi.</p>
    <p>Kontak: info@rubbishbuster.com | Telepon: 0856-4849-9655</p>
  </div>

  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script src="../View/main.js"></script>
</body>
</html>
