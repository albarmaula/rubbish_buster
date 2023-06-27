<?php
// File: Profilepage.php

// Pastikan pengguna sudah login sebelum mengakses halaman profil
session_start();
if (!isset($_SESSION['email'])) {
    // Pengguna belum login, redirect ke halaman login
    header('Location: login.php');
    exit();
}

// Ambil informasi pengguna berdasarkan email dari database
$email = $_SESSION['email'];

// Lakukan kueri ke database untuk mendapatkan data profil pengguna berdasarkan email
require_once '../Model/User.php'; // Ganti UserModel.php dengan nama file model pengguna yang sesuai
$userModel = new User(); // Ganti UserModel dengan kelas model pengguna yang sesuai
$userProfile = $userModel->getUserByEmail($email);

// Periksa apakah data profil pengguna berhasil diambil
if ($userProfile === null) {
    // Data profil pengguna tidak ditemukan, berikan respon sesuai kebutuhan Anda
    echo 'User profile not found.';
    exit();
}

// Perbarui profil pengguna
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data yang dikirimkan oleh pengguna
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Lakukan validasi atau manipulasi data jika diperlukan

    // Simpan data diri tambahan ke dalam profil pengguna
    $userProfile['address'] = $address;
    $userProfile['phone_num'] = $phone;

    // Simpan profil pengguna yang diperbarui ke database (jika diperlukan)
    // $userModel->updateUserProfile($userProfile); // Contoh metode di model pengguna untuk menyimpan profil yang diperbarui

    // Redirect ke halaman profil setelah menyimpan perubahan
    // header('Location: profile.php');
    // exit();
}
// ...

// Perbarui profil pengguna
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data yang dikirimkan oleh pengguna
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Lakukan validasi atau manipulasi data jika diperlukan

    // Simpan data diri tambahan ke dalam profil pengguna
    $userProfile['address'] = $address;
    $userProfile['phone_num'] = $phone;

    // Simpan profil pengguna yang diperbarui ke database
    $userModel->updateUserProfile($userProfile);

    // Redirect ke halaman profil setelah menyimpan perubahan
    header('Location: Profilepage.php');
    exit();
}

// ...

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="../css/styleprofile.css">
</head>
<body>
    <div class="navbar">
    <?php include(__DIR__ . "/navbar.php"); ?>
  </div>
  <div class="profile">
  <div class="profile-photo">
    <!-- Tampilkan foto profil -->
    <img src="path/to/profile-photo.jpg" alt="Profile Photo">
    <!-- Tambahkan tombol atau elemen lain untuk mengganti foto profil -->
    <input type="file" id="photo_profile" name="photo" accept="image/*">
  </div>

  <div class="profile-form">
    <h1>User Profile</h1>
    <div class="profile-info">
      <label>Username:</label>
      <p><?php echo $userProfile['username']; ?></p>
      <label>Email:</label>
      <p><?php echo $userProfile['email']; ?></p>
    </div>

    <form method="POST" enctype="multipart/form-data">
      <label for="address">Address:</label>
      <input type="text" id="address" name="address" value="<?php echo $userProfile['address']; ?>">

      <label for="phone">Phone:</label>
      <input type="text" id="phone" name="phone" value="<?php echo $userProfile['phone_num']; ?>">

      <input type="submit" value="Save Changes">
    </form>
  </div>
</div>
</body>
</html>
