<?php
class VolunteerController
{
    private $volunteer;

    public function __construct()
    {
        $this->volunteer = new Volunteer();
    }

    public function saveActivity()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $addressVol = $_POST['address'];
            $latitudeVol = $_POST['latitude'];
            $longitudeVol = $_POST['longitude'];
            $date = $_POST['date']; 
            $desc = $_POST['desc'];
    
            // Upload and save the photo
            $photoVol = $_FILES['photo'];
    
            $photoPath = $this->uploadPhoto($photoVol);
            if ($photoPath !== null) {
                $photoName = $photoVol['name'];
                $this->volunteer->saveActivity($addressVol, $latitudeVol, $longitudeVol, $photoName, $date, $desc);
    
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

    
    public function getAllActivityDone()
    {
        return $this->volunteer->getAllActivityDone();
    }

    public function getAllActivityNotDone()
    {
    return $this->volunteer->getAllActivityNotDone();
    }

    public function deleteItem($volId) {
        // Panggil fungsi penghapusan item pada model
        $this->volunteer->deleteItem($volId);
    }
}
