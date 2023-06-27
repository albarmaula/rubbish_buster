<?php
require_once(__DIR__ . "/../DB.php");

class User{
    private $db;

    public function __construct() {
        $this->db = new DB();
    }
    

    public function registerUser($username, $email, $password) {
        // Implement the logic to register a user in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Implement the logic to register a user in the database
        $query = "INSERT INTO user (username, password, email) VALUES ('$username','$hashedPassword', '$email')";
        $result = $this->db->exec($query);

        if ($result) {
            return true; // Registration successful
        } else {
            return false; // Registration failed
        }
    }

    public function loginUser($email, $password) {
        // Implement the logic to verify user credentials from the database
        $query = "SELECT * FROM user WHERE email=?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("s", $email);
        $statement->execute();
        $result = $statement->get_result();
    
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user; // Login successful, return the user data
            }
        }
    
        return false; // Login failed
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM user WHERE email = '$email'";
        $result = $this->db->exec($query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }
    }

    public function getUserProfile()
    {
        // Implementasikan logika untuk mengambil data pengguna dari database
        // Gantikan kode di bawah ini dengan implementasi yang sesuai
        $query = "SELECT * FROM users WHERE email = 'example@example.com'";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function getUserData($email) {
        // Mengambil data pengguna dari database berdasarkan email
        $query = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($koneksi, $query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            return $user;
        } else {
            return null; // Pengguna tidak ditemukan
        }
    }


}
?>