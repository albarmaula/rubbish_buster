<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__."/../Model/User.php");
//require_once(_DIR_ . "/../Model/User.php");

class UserController{
    private $model;

    public function __construct() {
        $this->model = new User();
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_GET['action'])) { // Check if "action" key is set in $_GET array
                $action = $_GET['action'];

                switch($action){
                    case 'profile':
                        // Check if the user is logged in
                        if ($userController->isLoggedIn()) {
                            // Check the role of the user
                            if ($userData && $userData['role'] == 'admin') {
                                // Redirect to the admin page
                                header('Location: ../View/Adminpage.php');
                                exit();
                            } else {
                                // Redirect to the user profile page
                                header('Location: ../View/Profilepage.php');
                                exit();
                            }
                        } else {
                            // If the user is not logged in, redirect to the login page
                            header('Location: ../View/LoginPage.php');
                            exit();
                        }
            
                    case 'register':
                        // Register user
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        $email = $_POST['email'];
                        $errors = array();

                        // Check if the email already exists in the database
                        $checkemail = "SELECT * FROM user WHERE email = '$email'";
                        $result = DB::exec($checkemail);
                        if (mysqli_num_rows($result) > 0) {
                            $errors[] = "Email already exists";
                        }

                        // Check if the username already exists in the database
                        $checkusername = "SELECT * FROM user WHERE username = '$username'";
                        $result = DB::exec($checkusername);
                        if (mysqli_num_rows($result) > 0) {
                            $errors[] = "Username already exists";
                        }

                        // Check if the email is in a valid format
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $errors[] = "Invalid email format";
                        }

                        // Check if the password meets the common password requirements
                        // Example: At least 8 characters, containing at least one uppercase letter, one lowercase letter, and one digit
                        if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/", $password)) {
                            $errors[] = "Invalid password format";
                        }

                        if (count($errors) === 0) {
                            // Call the model to register the user
                            $success = $this->model->registerUser($username, $email, $password);

                            if ($success) {
                                // Redirect to a success page or perform any other actions
                                require '../View/LoginPage.php';
                            } else {
                                // Display an error message or redirect to an error page
                                require '../View/RegisterPage.php';
                            }
                        } else {
                            // Display the register form with error messages
                            require '../View/RegisterPage.php';
                        }
                        break;

                    case 'login':
                        // User login
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $errors = [];

                        // Retrieve the user from the database based on email
                        $query = "SELECT * FROM user WHERE email = '$email'";
                        $result = DB::exec($query);

                        if ($result && $user = mysqli_fetch_assoc($result)) {
                            // Verify the entered password with the stored hashed password
                            if (password_verify($password, $user['password'])) {
                                // Password verification successful, log the user in
                                // Set session variables or tokens to maintain user authentication
                                // Redirect the user to the appropriate page
                                $_SESSION['email'] = $email;
                                require '../View/BerandaPage.php';
                            } else {
                                // Password verification failed
                                $errors[] = "Invalid password";
                            }
                        } else {
                            // User not found in the database
                            $errors[] = "Email does not exist";
                        }

                        if (count($errors) > 0) {
                            // Display the login form with error messages
                            require '../View/LoginPage.php';
                        }
                        break;
                        
                    default:
                        // Handle the case when "action" is not recognized
                        break;
                }
            } else {
                // Handle the case when "action" key is not set in $_GET array
            }
        } else {
            if (isset($_GET['action'])) { // Check if "action" key is set in $_GET array
                $action = $_GET['action'];

                switch ($action) {
                    // Handle the GET requests
                    case 'register':
                        require '../View/RegisterPage.php';
                        break;

                    case 'login':
                        require '../View/LoginPage.php';
                        break;
                        
                    default:
                        // Handle the case when "action" is not recognized
                        break;
                }
            } else {
                // Handle the case when "action" key is not set in $_GET array
            }
        }
    }

    public function getUserByEmail($email) {
        return $this->model->getUserByEmail($email);
    }
    

    public function getUsername() {
        // Get the user's username based on the email stored in the session
        if ($this->isLoggedIn()) {
            $email = $_SESSION['email'];
            $user = $this->getUserByEmail($email);
            if ($user) {
                return $user['username'];
            }
        }
        return '';
    }
    

    public function isLoggedIn() {
        // Use session to check if the user is already logged in
        if (isset($_SESSION['email'])) {
            return true;
        } else {
            return false;
        }
    }

    public function logoutUser() {
        // Mulai atau lanjutkan sesi yang ada

    
        // Hapus semua data sesi
        $_SESSION = array();
    
        // Hancurkan sesi
        session_destroy();
    
        // Alihkan pengguna ke halaman login (misalnya, index.php)
        require '../View/LoginPage.php';
        exit();
    }
    

    public function showProfilePage()
    {
        // Pastikan pengguna sudah login sebelum mengakses halaman profil
        session_start();
        if (!isset($_SESSION['email'])) {
            // Pengguna belum login, redirect ke halaman login
            header('Location: LoginPage.php');
            exit();
        }

        // Ambil informasi pengguna berdasarkan email dari database
        $email = $_SESSION['email'];

        // Lakukan kueri ke database untuk mendapatkan data profil pengguna berdasarkan email
        $userProfile = $this->userModel->getUserByEmail($email);

        // Periksa apakah data profil pengguna berhasil diambil
        if ($userProfile === null) {
            // Data profil pengguna tidak ditemukan, berikan respon sesuai kebutuhan Anda
            echo 'User profile not found.';
            exit();
        }

        // Tampilkan halaman profil
        include 'Profilepage.php';
    }
    public function updateUser($username, $address, $email, $phoneNum) {
        // Panggil metode updateUser pada UserModel untuk mengupdate data pengguna
        if (isset($_POST['update'])) {
            $username = $_POST['username'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $phoneNum = $_POST['phone_num'];
    
            $result = $this->model->updateUser($email, $username, $address, $phoneNum);
    
            if ($result) {
                // Update berhasil
                echo "Profil berhasil diperbarui.";
            } else {
                // Gagal memperbarui
                echo "Gagal memperbarui profil.";
            }
        }
    }
}


$controller = new UserController();
$controller->handleRequest();
?>