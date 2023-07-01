<?php
require_once(__DIR__ . "/../Controller/UserController.php");

// Inisialisasi UserController
$userController = new UserController();
$userData = null;

// Memeriksa apakah pengguna telah login
if ($userController->isLoggedIn()) {
    // Mengambil email dari UserController
    $email = $_SESSION['email'];
    
    // Mengambil data pengguna berdasarkan email
    $userData = $userController->getUserByEmail($email);
    
    // Memeriksa apakah data pengguna berhasil diperoleh
    if ($userData === null) {
        // Data pengguna tidak ditemukan, berikan respon sesuai kebutuhan Anda
        echo 'User data not found.';
        exit();
    }
    
    // Mengambil username dari data pengguna
    $username = $userData['username'];
    
    // Menampilkan username di sebelah kiri navbar
    echo '<a class="nav-link" href="../View/Profilepage.php">' . $username . '</a>';
}

?>

<div class="navbar-links">
    <link rel="stylesheet" href="../css/styleberanda.css">
    <a class="nav-link" href="../View/Donasipage.php">Donasi</a>
    <a class="nav-link" href="#post">Post</a>
    <a class="nav-link" href="../View/VolunteerPage.php">Volunteer</a>
    <a class="nav-link" href="../View/Berandapage.php">Beranda</a>

    <?php
    if ($userController->isLoggedIn()) {
        // Menampilkan tombol logout jika pengguna telah login
        echo '<a class="nav-link" href="../Controller/LogoutController.php">Logout</a>';
    }
    
    if ($userData && $userData['role'] == 'admin') {
        echo '<a class="nav-link" href="../View/AdminPage.php">Admin</a>';
    }
    ?>
</div>

<div class="navbar-burger" onclick="toggleMenu()"></div>

<script>
function toggleMenu() {
  var navbarLinks = document.getElementsByClassName("navbar-links")[0];
  if (navbarLinks.style.display === "block") {
    navbarLinks.style.display = "none";
  } else {
    navbarLinks.style.display = "block";
  }
}
</script>
</nav>
