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
  <link rel="stylesheet" href="../css/styleformlaporan.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" /> -->
  <style>
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9998;
    }

    .popup-form {
        text-align:center;
        color: white; 
        width: 400px;
        background-color: #41644A;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
    #map {
        height: 400px;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <?php include(__DIR__ . "/navbar.php"); ?>
  </div>

  <div id="map"></div>

  <div class="body">
    <p>Rubbish Buster adalah sebuah konsep atau program yang bertujuan untuk mengurangi dan mengatasi masalah sampah atau limbah di suatu wilayah atau komunitas tertentu. Tujuan utama dari Rubbish Buster adalah untuk meningkatkan kesadaran dan partisipasi masyarakat dalam mengelola sampah dengan cara yang lebih bertanggung jawab dan berkelanjutan.</p>
    <a class="btn_lapor" href="#" onclick="openFormVolunteer()">Volunteer</a>
    <a class="btn_lapor" href="#" onclick="openForm()">Lapor Sampah</a>
  </div>
  
    <div class="board">
        <img src="../image/image_sampah.jpg" />
        <div style="text-align: center; color: white;  font-family: Inter; font-weight: 700; word-wrap: break-word">Berdasarkan data Sistem Informasi Pengelolaan Sampah Nasional (SIPSN) Kementerian 
        Lingkungan Hidup dan Kehutanan (KLHK), volume timbulan sampah di Indonesia pada 2022 
        mencapai 19,45 juta ton. Angka tersebut menurun 37,52% dari 2021 yang sebanyak 31,13 juta ton.
        </div>
    </div>

    <div class="isi">“Menjaga kebersihan lingkungan merupakan tanggung jawab bagi setiap manusia. Karena tubuh<br/>manusia yang sehat berasal dari lingkungan yang sehat dan bersih,<br/>” kata Kepala DLH Kota Kota Palangka Raya, Ahmad Zain</div>
    
    <div class="footer">
        <p>Hak Cipta &copy; 2023 Rubbish Buster. Semua hak dilindungi.</p>
        <p>Kontak: info@rubbishbuster.com | Telepon: 0856-4849-9655</p>
    </div>


    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Create the map
        var map = L.map('map').setView([-7.2575, 112.7521], 13);

        // Add tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add markers to the map
        <?php foreach ($locations as $location) : ?>
        L.marker([<?= $location['latitude'] ?>, <?= $location['longitude'] ?>]).addTo(map);
        <?php endforeach; ?>

        // Add markers to the map using OpenLayers
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

        function openForm() {
          document.getElementById("formOverlay").style.display = "flex";
        }

        function closeForm() {
            document.getElementById("formOverlay").style.display = "none";
        }

        function openFormVolunteer() {
          document.getElementById("formVolOverlay").style.display = "flex";
        }

        function closeFormVolunteer() {
            document.getElementById("formVolOverlay").style.display = "none";
        }

    </script>

<!-- Laporan Sampah______________________________________________________________________________________________ -->
  <div class="overlay" id="formOverlay" style="display: none;">
    <div class="popup-form">
        <h2>Laporan Sampah</h2>
        <!-- Add your form fields here -->
        <form class="form" action="Berandapage.php?action=save" method="post" enctype="multipart/form-data">
        <div class="form-group">
                    <label for="name">Nama:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="address">Alamat laporan:</label>
                    <input type="text" id="address" name="address" required>
                    <!-- <button class="btn" type="button" onclick="showMap()">Pilih Peta</button> -->
                </div>

                <div class="form-group">
                    <label for="latitude">Latitude:</label>
                    <input type="text" id="latitude" name="latitude" required>
                </div>

                <div class="form-group">
                    <label for="longitude">Longitude:</label>
                    <input type="text" id="longitude" name="longitude" required>
                </div>

                <button class="btn" type="button" onclick="showMap()">Pilih Peta</button>

                <div class="form-group">
                    <label for="photo">Foto:</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                </div>

                <button class="btn" type="button" onclick="closeForm()">Batal</button>
                <button class="btn" type="submit">Simpan</button>
        </form>
        </div>
    </div>

    <div id="map-popup" class="map-popup" style="display: none; ">
        <div class="map-popup-content" style="background-color: #41644A;">
            <div id="map-popup-map" class="map"></div><br>
            <input type="text" id="search-input" placeholder="Search">
            <button class="btn" onclick="searchLocation()">Search</button>
            <button class="btn" onclick="closeMap()">Close</button>
        </div>
    </div>
    <!-- <button onclick="showMap()">Open Map</button> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script>
        var map;
        var marker;
        var mapPopup = document.getElementById('map-popup');
        var searchInput = document.getElementById('search-input');

        function showMap() {
            mapPopup.style.display = 'block';

            setTimeout(function() {
                map = L.map('map-popup-map').setView([-7.2575, 112.7521], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                    maxZoom: 18
                }).addTo(map);

                map.on('click', function(event) {
                    if (marker) {
                        map.removeLayer(marker);
                    }

                    marker = L.marker(event.latlng).addTo(map);

                    document.getElementById('latitude').value = event.latlng.lat.toFixed(6);
                    document.getElementById('longitude').value = event.latlng.lng.toFixed(6);
                });
            }, 100);
        }

        function closeMap() {
            mapPopup.style.display = 'none';
            map.remove();
        }

        function searchLocation() {
            var query = searchInput.value;

            if (query) {
                var url = 'https://nominatim.openstreetmap.org/search?q=' + query + '&format=json&addressdetails=1&limit=1';

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            var lat = data[0].lat;
                            var lon = data[0].lon;

                            if (marker) {
                                map.removeLayer(marker);
                            }

                            marker = L.marker([lat, lon]).addTo(map);
                            map.setView([lat, lon], 13);
                        }
                    })
                    .catch(error => {
                        console.log('Error:', error);
                    });
            }
        }
    </script>

<!-- Volunteer__________________________________________________________________________________________________________ -->
    <div class="overlay" id="formVolOverlay" style="display: none;">
        <div class="popup-form">
            <h2>Aktivitas Pembersihan</h2>
            <!-- Add your form fields here -->
            <form class="form" action="Berandapage.php?action=save" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="address">Alamat Pembersihan:</label>
                        <input type="text" id="address" name="address" required>
                    </div>

                    <div class="form-group">
                        <label for="latitude">Latitude:</label>
                        <input type="text" id="latitude" name="latitude" required>
                    </div>

                    <div class="form-group">
                        <label for="longitude">Longitude:</label>
                        <input type="text" id="longitude" name="longitude" required>
                    </div>

                    <button class="btn" type="button" onclick="showMap()">Pilih Peta</button>

                    <!-- ///////////////////////benakno -->
                    <div class="form-group">
                        <label for="address">Tanggal dan Jam:</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Deskripsi:</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                    <!-- ///////////////////// -->

                    <div class="form-group">
                        <label for="photo">Foto:</label>
                        <input type="file" id="photo" name="photo" accept="image/*">
                    </div>

                    <button class="btn" type="button" onclick="closeFormVolunteer()">Batal</button>
                    <button class="btn" type="submit">Simpan</button>
            </form>
            </div>
        </div>

        <div id="map-popup" class="map-popup" style="display: none; ">
            <div class="map-popup-content" style="background-color: #41644A;">
                <div id="map-popup-map" class="map"></div><br>
                <input type="text" id="search-input" placeholder="Search">
                <button class="btn" onclick="searchLocation()">Search</button>
                <button class="btn" onclick="closeMap()">Close</button>
            </div>
        </div>
        <!-- <button onclick="showMap()">Open Map</button> -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
        <script>
            var map;
            var marker;
            var mapPopup = document.getElementById('map-popup');
            var searchInput = document.getElementById('search-input');

            function showMap() {
                mapPopup.style.display = 'block';

                setTimeout(function() {
                    map = L.map('map-popup-map').setView([-7.2575, 112.7521], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                        maxZoom: 18
                    }).addTo(map);

                    map.on('click', function(event) {
                        if (marker) {
                            map.removeLayer(marker);
                        }

                        marker = L.marker(event.latlng).addTo(map);

                        document.getElementById('latitude').value = event.latlng.lat.toFixed(6);
                        document.getElementById('longitude').value = event.latlng.lng.toFixed(6);
                    });
                }, 100);
            }

            function closeMap() {
                mapPopup.style.display = 'none';
                map.remove();
            }

            function searchLocation() {
                var query = searchInput.value;

                if (query) {
                    var url = 'https://nominatim.openstreetmap.org/search?q=' + query + '&format=json&addressdetails=1&limit=1';

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                var lat = data[0].lat;
                                var lon = data[0].lon;

                                if (marker) {
                                    map.removeLayer(marker);
                                }

                                marker = L.marker([lat, lon]).addTo(map);
                                map.setView([lat, lon], 13);
                            }
                        })
                        .catch(error => {
                            console.log('Error:', error);
                        });
                }
            }
        </script>

</body>
</html>

<?php
}
?>