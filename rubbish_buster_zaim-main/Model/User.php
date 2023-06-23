<?php
require_once(__DIR__ . "/../DB.php");

class User{
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function registerUser($username, $email, $password) {
        // Implement the logic to register a user in the database
        $query = "INSERT INTO user (username, email, password) VALUES ('$username','$email', '$password')";
        $result = $this->db->exec($query);

        if ($result) {
            return true; // Registration successful
        } else {
            return false; // Registration failed
        }
    }

    public function loginUser($email, $password) {
        // Implement the logic to verify user credentials from the database
        $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
        $result = $this->db->exec($query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            return true;
        }
    
        return false; // Login failed
    }

    public function getUserByUsername($username) {
        $query = "SELECT * FROM user WHERE username = '$username'";
        $result = $this->db->exec($query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }
    }
    
    
}
?>