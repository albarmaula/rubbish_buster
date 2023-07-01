<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <link rel="stylesheet" href="../css/styleadminpage.css">
    <style>
        table {
            background-color: #41644A;
            border-spacing: 0;
            width: 100%;
            border: 2px solid #41644A;
            border-radius: 5px;
        }
        
        th{
            text-align: left;
            padding: 16px;
            color: white;
        }
        td {
            text-align: left;
            padding: 16px;
            color: white;
            background-color: #61876E;
        }
        
        td:nth-child(even) {
            background-color: #658A72;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <?php include(__DIR__ . "/navbar.php"); ?>
    </div>
    <h1>Admin</h1>

    <?php
    require_once '../Model/Location.php';
    require_once '../Controller/LocationController.php';

    $locationsController = new LocationsController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_location'])) {
        $locationId = $_POST['location_id'];
        $locationsController->deleteItem($locationId);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Update location status when admin approves or rejects
        $locationId = $_POST['location_id'];
        $status = $_POST['status'];
        $locationsController->updateLocationStatus($locationId, $status);
    }

    $locations = $locationsController->getAllLocations();

    if (!empty($locations)) {
        echo '<table>';
        echo '<tr>';
        echo '<th>Nama</th>';
        echo '<th>Latitude</th>';
        echo '<th>Longitude</th>';
        echo '<th>Alamat</th>';
        echo '<th>Foto</th>';
        echo '<th>Status</th>';
        echo '<th>Persetujuan</th>';
        echo '<th>Hapus</th>';
        echo '</tr>';

        foreach ($locations as $location) {
            echo '<tr>';
            echo '<td>' . $location['name'] . '</td>';
            echo '<td>' . $location['latitude'] . '</td>';
            echo '<td>' . $location['longitude'] . '</td>';
            echo '<td>' . $location['address'] . '</td>';

            $image = $location['photo_path'];
            $image_src = "../image/".$image;

            if (isset($image) && file_exists($image_src)) {
                echo '<td><img src="' . $image_src . '" alt="Foto Lokasi" style="width: 100px;"></td>';
            } else {
                echo '<td>Tidak ada foto.</td>';
            }

            echo '<td>' . $location['status'] . '</td>';

            if ($location['status'] === 'pending') {
                echo '<td>';
                echo '<form method="post" action="">';
                echo '<input type="hidden" name="location_id" value="' . $location['id'] . '">';
                echo '<select name="status">';
                echo '<option value="approved">Setujui</option>';
                echo '<option value="rejected">Tolak</option>';
                echo '</select>';
                echo '<button class="btn" type="submit">Submit</button>';
                echo '</form>';
                echo '</td>';
            } else {
                echo '<td>-</td>';
            }

            echo '<td>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="location_id" value="' . $location['id'] . '">';
            echo '<button class="btn btn-danger" type="submit" name="delete_location">Hapus</button>';
            echo '</form>';
            echo '</td>';

            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo '<p>Tidak ada lokasi ditemukan.</p>';
    }
    ?>

<br>
    <div class="footer">
        <p>Hak Cipta &copy; 2023 Rubbish Buster. Semua hak dilindungi.</p>
        <p>Kontak: info@rubbishbuster.com | Telepon: 0856-4849-9655</p>
    </div>
</body>
</html>
