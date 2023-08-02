<?php
// File: Profilepage.php

// Pastikan pengguna sudah login sebelum mengakses halaman profil
session_start();
if (!isset($_SESSION['email'])) {
    // Pengguna belum login, redirect ke halaman login
    header('Location: login.php');
    exit();
}

// Ambil informasi pengguna berdasarkan email dari database
$email = $_SESSION['email'];

// Lakukan kueri ke database untuk mendapatkan data profil pengguna berdasarkan email
require_once '../Model/User.php'; // Ganti UserModel.php dengan nama file model pengguna yang sesuai
$userModel = new User(); // Ganti UserModel dengan kelas model pengguna yang sesuai
$userProfile = $userModel->getUserByEmail($email);

require_once '../Controller/UserController.php'; // Ganti UserController.php dengan nama file dan lokasi yang sesuai
$controller = new UserController(); // Ganti UserController dengan kelas controller pengguna yang sesuai
$userProfile = $controller->getUserByEmail($email);

// Periksa apakah data profil pengguna berhasil diambil
if ($userProfile === null) {
    // Data profil pengguna tidak ditemukan, berikan respon sesuai kebutuhan Anda
    echo 'User profile not found.';
    exit();
}

// Perbarui profil pengguna
if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phone_num'];

    // Panggil metode updateUser pada UserController untuk mengupdate data pengguna
    $result = $controller->updateUser($username, $address, $email, $phoneNum);

    if ($result) {
        // Update berhasil
        header('Location: Profilepage.php');
    exit();
    } else {
		header('Location: Profilepage.php');
		exit();
    }
	
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/styleprofile.css">
</head>
<body>
    <div class="navbar">
    <?php include(__DIR__ . "/navbar.php"); ?>
  </div>
  <section class="py-5 my-5">
		<div class="container">
			<h1 class="mb-5">Account Settings</h1>
			<div class="bg-white shadow rounded-lg d-block d-sm-flex">
				<div class="profile-tab-nav border-right">
					<div class="p-4">
						<div class="img-circle text-center mb-3">
							<img src="../image/user2.jpg" alt="Image" class="shadow">
						</div>
						<h4 class="text-center"><?php echo $userProfile['username']; ?></h4>
					</div>
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link active" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
							<i class="fa fa-home text-center mr-1"></i> 
							Account
						</a>
						<a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
							<i class="fa fa-key text-center mr-1"></i> 
							Password
						</a>
						<a class="nav-link" id="security-tab" data-toggle="pill" href="#security" role="tab" aria-controls="security" aria-selected="false">
							<i class="fa fa-user text-center mr-1"></i> 
							Security
						</a>
						<a class="nav-link" id="application-tab" data-toggle="pill" href="#application" role="tab" aria-controls="application" aria-selected="false">
							<i class="fa fa-tv text-center mr-1"></i> 
							Riwayat Pelaporan
						</a>
						<a class="nav-link" id="notification-tab" data-toggle="pill" href="#notification" role="tab" aria-controls="notification" aria-selected="false">
							<i class="fa fa-bell text-center mr-1"></i> 
							Notification
						</a>
					</div>
				</div>
				<div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
					<div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
						<h3 class="mb-4">Account Settings</h3>
						<div class="row">
							<div class="col-md-6">
							<form action="Profilepage.php" method="post">
								<div class="form-group">
								  	<label>Name</label>
								  	<input type="text" name="username" class="form-control" value="<?php echo $userProfile['username']; ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Address</label>
								  	<input type="text" name="address" class="form-control" value="<?php echo $userProfile['address']; ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Email</label>
								  	<input type="text" name="email" class="form-control" value="<?php echo $userProfile['email']; ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Phone number</label>
								  	<input type="text" name="phone_num" class="form-control" value="<?php echo $userProfile['phone_num']; ?>">
								</div>
							</div>							
							<div class="col-md-12">
								<div class="form-group">
								  	<label>Bio</label>
									<textarea class="form-control" rows="4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore vero enim error similique quia numquam ullam corporis officia odio repellendus aperiam consequatur laudantium porro voluptatibus, itaque laboriosam veritatis voluptatum distinctio!</textarea>
								</div>
							</div>
						</div>
						<div>
							<button class="btn btn-primary" name="update">Update</button>
							<button class="btn btn-light">Cancel</button>
						</div>
						</form>
					</div>
					<div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
						<h3 class="mb-4">Password Settings</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Old password</label>
								  	<input type="password" class="form-control">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								  	<label>New password</label>
								  	<input type="password" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Confirm new password</label>
								  	<input type="password" class="form-control">
								</div>
							</div>
						</div>
						<div>
							<button type="submit" class="btn btn-primary" name="update">Update</button>
							<button class="btn btn-light">Cancel</button>
						</div>
					</div>
					<div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
						<h3 class="mb-4">Security Settings</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Login</label>
								  	<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Two-factor auth</label>
								  	<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="" id="recovery">
										<label class="form-check-label" for="recovery">
										Recovery
										</label>
									</div>
								</div>
							</div>
						</div>
						<div>
							<button class="btn btn-primary">Update</button>
							<button class="btn btn-light">Cancel</button>
						</div>
					</div>
					<div class="tab-pane fade" id="application" role="tabpanel" aria-labelledby="application-tab">
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

						$locations = $locationsController-> getHistoryReport();

						if (!empty($locations)) {
							echo '<table>';
							echo '<tr>';
							echo '<th>Nama</th>';
							echo '<th>Alamat</th>';
							echo '<th>Foto</th>';
							echo '<th>Status</th>';
							echo '<th>Hapus</th>';
							echo '</tr>';

							foreach ($locations as $location) {
								echo '<tr>';
								echo '<td>' . $location['name'] . '</td>';
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
					</div>
					<div class="tab-pane fade" id="notification" role="tabpanel" aria-labelledby="notification-tab">
						<h3 class="mb-4">Notification Settings</h3>
						<div class="form-group">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="notification1">
								<label class="form-check-label" for="notification1">
									Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum accusantium accusamus, neque cupiditate quis
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="notification2" >
								<label class="form-check-label" for="notification2">
									hic nesciunt repellat perferendis voluptatum totam porro eligendi.
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="notification3" >
								<label class="form-check-label" for="notification3">
									commodi fugiat molestiae tempora corporis. Sed dignissimos suscipit
								</label>
							</div>
						</div>
						<div>
							<button class="btn btn-primary">Update</button>
							<button class="btn btn-light">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
