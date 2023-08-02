<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../Database/LocationDB.php';
class Location
{
    

    private $database;

    public function __construct()
    {
        $this->database = new LocationDB();
    }

    public function saveLocation($name, $address, $latitude, $longitude, $photoPath)
    {
        $query = "INSERT INTO locations (name, address, latitude, longitude, photo_path) VALUES (?, ?, ?, ?, ?)";
        $params = [$name, $address, $latitude, $longitude, $photoPath];
        $this->database->execute($query, $params);
    }

    // ...

    public function uploadPhoto($photo)
    {
        $targetDir = 'uploads/';
        $targetFile = $targetDir . basename($photo['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
        // Check if image file is a actual image or fake image
        $check = getimagesize($photo['tmp_name']);
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
        if ($photo['size'] > 500000) {
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
            if (move_uploaded_file($photo['tmp_name'], $targetFile)) {
                return $targetFile;
            } else {
                return null;
            }
        }
    }

    // ...
    public function getHistoryReport()
    {
        // Pastikan session telah dimulai sebelum mengakses $_SESSION
        $username = $_SESSION['username'];

        // Gunakan query untuk mengambil data lokasi berdasarkan nama pengguna yang sedang login
        $query = "SELECT * FROM locations WHERE name = '$username' ORDER BY status";

        return $this->database->fetchAll($query);
    }

    public function getAllLocations()
    {
        $query = "SELECT * FROM locations ORDER BY status";
        return $this->database->fetchAll($query);
    }

   public function getAllApprovedLocations()
    {
    $query = "SELECT * FROM locations WHERE status = 'approved'";
    return $this->database->fetchAll($query);
    }

    public function updateLocationStatus($locationId, $status)
    {
        $query = "UPDATE locations SET status = ? WHERE id = ?";
        $params = [$status, $locationId];
        $this->database->execute($query, $params);
    }

    public function deleteItem($locationId)
    {
        $query = "DELETE FROM locations WHERE id = ?";
        $params = [$locationId];
        $this->database->execute($query, $params);
    }

// ...


}
