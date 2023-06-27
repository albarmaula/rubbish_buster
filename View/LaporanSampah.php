<!DOCTYPE html>
<html>
<head>
    <title>Form Lokasi</title>
    <link rel="stylesheet" href="../css/styleformlaporan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
</head>
<body>
    <div class="navbar">
        <?php include(__DIR__ . "/navbar.php"); ?>
    </div>
    <div class="container">
    <h2>Form Lokasi</h2>
  <div class="form-container">
  <form class="form" action="Berandapage.php?action=save" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="address">Alamat:</label>
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

            <div class="form-group">
                <label for="photo">Foto:</label>
                <input type="file" id="photo" name="photo" accept="image/*">
            </div>

            <button class="btn" type="button" onclick="showMap()">Pilih Peta</button>
            <button class="btn" type="submit">Simpan</button>
        </form>
  </div>
</div>

<div id="map-popup" class="map-popup">
  <div class="map-popup-content">
    <div id="map" class="map"></div>
    <input type="text" id="search-input" placeholder="Search">
    <button onclick="searchLocation()">Search</button>
    <button onclick="closeMap()">Close</button>
  </div>
</div>
<button onclick="showMap()">Open Map</button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script>
        var map;
        var marker;
        var mapPopup = document.getElementById('map-popup');
        var searchInput = document.getElementById('search-input');

        function showMap() {
            mapPopup.style.display = 'block';

        setTimeout(function() {
            map = L.map('map').setView([-7.2575, 112.7521], 13);

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
            var query = $('#search-input').val();

            if (query) {
                var url = 'https://nominatim.openstreetmap.org/search?q=' + query + '&format=json&addressdetails=1&limit=1';

                $.ajax({
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        if (data.length > 0) {
                            var lat = data[0].lat;
                            var lon = data[0].lon;

                            if (marker) {
                                map.removeLayer(marker);
                            }

                            marker = L.marker([lat, lon]).addTo(map);
                            map.setView([lat, lon], 13);
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>
