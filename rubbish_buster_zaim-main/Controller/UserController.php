<?php
require_once(__DIR__ . "/../Model/User.php");
class UserController{
    private $model;

    public function __construct() {
        $this->model = new User();
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $action = $_GET['action'];

            switch($_GET['action']){
                case 'register':
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
                    }break;
////////////////////////////////////////////////////////////////////////////////////////////
                case 'login':
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    // Validate form inputs (e.g., check for empty fields)
                    // Call the login model to login the user
                    $errors = array();

                    $checkemail = "SELECT * FROM user WHERE email = '$email'";
                    $result = DB::exec($checkemail);
                    if (mysqli_num_rows($result) < 1) {
                        $errors[] = "Email does not exist";
                    }

                    $checkpassword = "SELECT * FROM user WHERE email = '$email' AND password = '$password' ";
                    $result = DB::exec($checkpassword);
                    if (mysqli_num_rows($result) < 1) {
                        $errors[] = "Your password is wrong";
                    }

                    if (count($errors) === 0) {
                        // Call the model to register the user
                        $success = $this->model->loginUser($email, $password);
        
                        if ($success) {
                            // Redirect to a success page or perform any other actions
                            require '../View/Berandapage.php';
                        } else {
                            // Display an error message or redirect to an error page

                            // require '../View/Berandapage.php';
                        }
                    } else {
                        // Display the register form with error messages
                        require '../View/LoginPage.php';
                    }
                    break;
            }
        } else {
            $action = $_GET['action'];

            switch ($action) {
                case 'register':
                    require '../View/registerPage.php';
                    break;

                case 'login':
                    require '../View/loginPage.php';
                    break;
            }
        }
    }
    public function getUsername($email) {
        $user = $this->model->getUserByEmail($email);

        if ($user) {
            return $user['username'];
        } else {
            return '';
        }
    }

    public function isLoggedIn() {
        // Menggunakan session untuk memeriksa apakah user sudah login
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
    public function logoutUser() {
        // Menghapus session saat user logout
        session_start();
        session_destroy();
    }
}
$controller = new UserController();
$controller->handleRequest();
?>