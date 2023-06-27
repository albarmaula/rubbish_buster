<?php
class LocationsController
{
    private $location;

    public function __construct()
    {
        $this->location = new Location();
    }

    public function saveLocation()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $latitude = $_POST['latitude'];
            $longitude = $_POST['longitude'];
    
            // Upload and save the photo
            $photo = $_FILES['photo'];
    
            $photoPath = $this->uploadPhoto($photo);
            if ($photoPath !== null) {
                $photoName = $photo['name'];
                $this->location->saveLocation($name, $address, $latitude, $longitude, $photoName);
    
                // Redirect to homepage or any other page
                header('Location: Berandapage.php');
                exit();
            } else {
                echo "Failed to upload photo.";
            }
        }
    }
    
    private function uploadPhoto($photo)
    {
        $targetDir = __DIR__ . "/../image/"; // Pindahkan ke direktori "image" di luar "Controller"
        $targetFile = $targetDir . basename($photo['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
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
            return $photo['name'];
        } else {
            return null;
        }
    }
}

    
    public function getAllLocations()
    {
        return $this->location->getAllLocations();
    }

    public function getAllApprovedLocations()
    {
    return $this->location->getAllApprovedLocations();
    }

    public function updateLocationStatus($locationId, $status)
    {
         $this->location->updateLocationStatus($locationId, $status);
    }

    public function deleteItem($locationId) {
        // Panggil fungsi penghapusan item pada model
        $this->location->deleteItem($locationId);
    }
}
