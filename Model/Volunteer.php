<?php
require_once '../Database/VolunteerDB.php';
class Volunteer
{
    

    private $database;

    public function __construct()
    {
        $this->database = new VolunteerDB();
    }

    public function saveActivity($address, $latitude, $longitude, $photoPath, $date, $desc)
    {
        $query = "INSERT INTO volunteer (address, latitude, longitude, photo_path, date, desc) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [$address, $latitude, $longitude, $photoPath, $date, $desc];
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
    public function getAllActivityDone()
    {
        $query = "SELECT * FROM volunteer WHERE date < CURRENT_TIMESTAMP() ORDER BY date DESC";
        return $this->database->fetchAll($query);
    }

    public function getAllActivityNotDone()
    {
        $query = "SELECT * FROM volunteer WHERE date > CURRENT_TIMESTAMP() ORDER BY date DESC";
        return $this->database->fetchAll($query);
    }

    public function deleteItem($volId)
    {
        $query = "DELETE FROM volunteer WHERE id = ?";
        $params = [$volId];
        $this->database->execute($query, $params);
    }

// ...


}
