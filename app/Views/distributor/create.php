<?= $this->include('layout/header') ?>

<?= $this->include('layout/sidebar') ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
  .map-container {
    height: 450px;
    border-radius: 10px;
    overflow: hidden;
  }
  #map {
    width: 100%;
    height: 100%;
  }
  .coordinate-input {
    font-family: monospace;
  }
</style>

<main>
  <div class="container-fluid py-4">
    <div class="mb-4">
      <h2 class="fw-bold mb-1">Tambah Distributor</h2>
      <p class="text-muted mb-0">
        Tambahkan data distributor dan tentukan lokasi
        distributor pada peta.
      </p>
    </div>
    <form action="/distributor/store" method="post">
      <div class="row g-4">
        <div class="col-lg-5">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 p-4">
              <h5 class="fw-bold mb-1">
                Informasi Distributor
              </h5>
              <p class="text-muted small mb-0">
                Masukkan informasi distributor.
              </p>
            </div>
            <div class="card-body p-4">
              <div class="mb-4">
                <label for="nama_distributor" class="form-label fw-semibold">
                  Nama Distributor
                </label>
                <input type="text" class="form-control" id="nama_distributor" name="nama_distributor" maxlength="255" required>
              </div>
              <div class="mb-4">
                <label for="alamat_distributor" class="form-label fw-semibold">
                  Alamat Distributor
                </label>
                <textarea class="form-control" id="alamat_distributor" name="alamat_distributor" rows="5" placeholder="Masukkan alamat lengkap distributor..." required></textarea>
              </div>
              <div class="mb-3">
                <label for="latitude" class="form-label fw-semibold">
                  Latitude
                </label>
                <input type="text" class="form-control coordinate-input bg-light" id="latitude" name="latitude" readonly required>
              </div>
              <div class="mb-4">
                <label for="longitude" class="form-label fw-semibold">
                  Longitude
                </label>
                <input
                  type="text" class="form-control coordinate-input bg-light" id="longitude" name="longitude" readonly required>
              </div>
              <div class="alert alert-info">
                <div class="fw-semibold mb-1">
                  Cara menentukan lokasi
                </div>
                <div class="small">
                  Klik pada peta untuk memilih lokasi
                  distributor. Marker juga dapat digeser
                  untuk menyesuaikan posisi.
                </div>
              </div>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                  Simpan Distributor
                </button>
                <a href="/distributor" class="btn btn-outline-secondary">
                  Batal
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 p-4">
              <h5 class="fw-bold mb-1">Lokasi Distributor</h5>
              <p class="text-muted small mb-0">
                Pilih titik lokasi distributor pada peta.
              </p>
            </div>
            <div class="card-body p-3">
              <div class="map-container">
                <div id="map"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</main>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
  const defaultLatitude = -7.2575;
  const defaultLongitude = 112.7521;
  const map = L.map('map').setView([defaultLatitude, defaultLongitude], 12);

  L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; OpenStreetMap contributors'
    }
  ).addTo(map);

  let marker = null;

  function updateCoordinates(latitude, longitude) {
    document.getElementById('latitude').value =
      latitude.toFixed(6);
    document.getElementById('longitude').value =
      longitude.toFixed(6);
  }

  function createMarker(latitude, longitude) {
    if (marker !== null) {
      marker.setLatLng([latitude, longitude]);
    } else {
      marker = L.marker(
        [latitude, longitude], {
          draggable: true
        }
      ).addTo(map);
    }
    updateCoordinates(latitude, longitude);
    marker.on(
      'dragend',
      function() {
        const position = marker.getLatLng();
        updateCoordinates(position.lat, position.lng);
      }
    );
  }

  map.on(
    'click',
    function(event) {
      createMarker(event.latlng.lat, event.latlng.lng);
    }
  );
</script>

<?= $this->include('layout/footer') ?>