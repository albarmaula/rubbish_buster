<?php
require_once(__DIR__ . "/../Controller/UserController.php");

// Inisialisasi UserController
$userController = new UserController();

// Panggil method logoutUser pada UserController
$userController->logoutUser();

// Redirect ke halaman lain setelah logout
header("Location: ../View/LoginPage.php");
exit();
?>