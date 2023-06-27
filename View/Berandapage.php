<?php
require_once '../Model/Location.php';
require_once '../Controller/LocationController.php';

$action = $_GET['action'] ?? '';

$locationsController = new LocationsController();

if ($action === 'save') {
    $locationsController->saveLocation();
} else {
    // Get all locations from the database
    $locations = $locationsController->getAllApprovedLocations();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="../css/styleberanda.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>
<body>
  <div class="navbar">
    <?php include(__DIR__ . "/navbar.php"); ?>
  </div>

  <div id="map"></div>

  <div class="body">
    <p>Rubbish Buster adalah sebuah konsep atau program yang bertujuan untuk mengurangi dan mengatasi masalah sampah atau limbah di suatu wilayah atau komunitas tertentu. Tujuan utama dari Rubbish Buster adalah untuk meningkatkan kesadaran dan partisipasi masyarakat dalam mengelola sampah dengan cara yang lebih bertanggung jawab dan berkelanjutan.</p>
    <a class="btn_lapor" href="../View/LaporanSampah.php">Lapor Sampah</a>
  </div>
  
  <div class="board">
    <img src="../image/image_sampah.jpg" />
    <div style="text-align: center; color: white;  font-family: Inter; font-weight: 700; word-wrap: break-word">Berdasarkan data Sistem Informasi Pengelolaan Sampah Nasional (SIPSN) Kementerian 
      Lingkungan Hidup dan Kehutanan (KLHK), volume timbulan sampah di Indonesia pada 2022 
      mencapai 19,45 juta ton. Angka tersebut menurun 37,52% dari 2021 yang sebanyak 31,13 juta ton.</div>
  </div>

  <div class="isi">“Menjaga kebersihan lingkungan merupakan tanggung jawab bagi setiap manusia. Karena tubuh<br/>manusia yang sehat berasal dari lingkungan yang sehat dan bersih,<br/>” kata Kepala DLH Kota Kota Palangka Raya, Ahmad Zain</div>
  
  <div class="footer">
    <p>Hak Cipta &copy; 2023 Rubbish Buster. Semua hak dilindungi.</p>
    <p>Kontak: info@rubbishbuster.com | Telepon: 0856-4849-9655</p>
  </div>

  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script>// Create the map
var map = L.map('map').setView([-7.2575, 112.7521], 13);

// Add tile layer (OpenStreetMap)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
}).addTo(map);

// Add markers to the map
<?php foreach ($locations as $location) : ?>
  L.marker([<?= $location['latitude'] ?>, <?= $location['longitude'] ?>]).addTo(map);
<?php endforeach; ?>

// Add markers to the map
<?php foreach ($locations as $location) : ?>
  var marker = new ol.Feature({
    geometry: new ol.geom.Point(ol.proj.fromLonLat([<?= $location['longitude'] ?>, <?= $location['latitude'] ?>]))
  });

  var iconStyle = new ol.style.Style({
    image: new ol.style.Icon({
      src: './marker.png',
      scale: 0.5
    })
  });

  marker.setStyle(iconStyle);

  var vectorSource = new ol.source.Vector({
    features: [marker]
  });

  var vectorLayer = new ol.layer.Vector({
    source: vectorSource
  });

  map.addLayer(vectorLayer);
<?php endforeach; ?>
</script>
</body>
</html>
<?php
}
?>