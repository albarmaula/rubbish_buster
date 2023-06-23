// Inisialisasi peta
var map = L.map('map').setView([-6.1753924, 106.8271528], 13);

// Tambahkan layer peta dari Leaflet Provider Tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
  maxZoom: 18,
}).addTo(map);

// Tambahkan marker ke peta
function addMarkerToMap(lat, lon, locationName) {
  var marker = L.marker([lat, lon]).addTo(map);
  marker.bindPopup(locationName);
  marker.openPopup();
}

// Tangani penambahan lokasi saat form dikirim
document.getElementById('location-form').addEventListener('submit', function(event) {
  event.preventDefault();
  
  var locationInput = document.getElementById('location-input');
  var location = locationInput.value;

  // Hapus spasi awal dan akhir dari input lokasi
  location = location.trim();

  // Jika input lokasi tidak kosong
  if (location !== '') {
    // Reset input
    locationInput.value = '';
    
    // Ambil koordinat lokasi menggunakan geocoding
    var geocodeUrl = 'https://nominatim.openstreetmap.org/search?format=json&q=' + location;

    fetch(geocodeUrl)
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        if (data.length > 0) {
          var lat = data[0].lat;
          var lon = data[0].lon;
          
          // Tambahkan marker ke peta
          addMarkerToMap(lat, lon, location);
          
          // Kirim data ke server
          var postData = {
            location: location,
            latitude: lat,
            longitude: lon
          };
          
          fetch('save_location.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(postData)
          })
          .then(function(response) {
            if (response.ok) {
              console.log('Data berhasil disimpan ke database');
            } else {
              console.error('Gagal menyimpan data ke database');
            }
          })
          .catch(function(error) {
            console.error('Error:', error);
          });
        } else {
          alert('Lokasi tidak ditemukan');
        }
      })
      .catch(function(error) {
        console.error('Error:', error);
      });
  }
});
