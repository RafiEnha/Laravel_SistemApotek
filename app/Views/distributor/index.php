<?php
/** @var array<int, array<string, mixed>> $distributor */
?>

<?= $this->include('layout/header') ?>

<?= $this->include('layout/sidebar') ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
  #map {
    height: 500px;
    width: 100%;
    border-radius: 10px;
  }

  .distributor-map {
    overflow: hidden;
    border-radius: 10px;
  }
</style>

<main>
  <div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="fw-bold mb-1">Informasi Distributor</h2>
        <p class="text-muted mb-0">
          Kelola data distributor dan lokasi distribusinya.
        </p>
      </div>
      <a href="/distributor/create" class="btn btn-primary">
        + Tambah Distributor
      </a>
    </div>
    <div class="row g-4 mb-4">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body p-4">
            <div class="text-muted small mb-2">
              Total Distributor
            </div>
            <div class="fs-2 fw-bold">
              <?= count($distributor) ?>
            </div>
            <div class="text-muted small mt-1">
              distributor terdaftar
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body p-4">
            <div class="text-muted small mb-2">
              Distributor dengan Lokasi
            </div>
            <div class="fs-2 fw-bold text-primary">
              <?php
              $jumlahLokasi = 0;
              foreach ($distributor as $item) {
                if (
                  $item['latitude'] !== null &&
                  $item['latitude'] !== '' &&
                  $item['longitude'] !== null &&
                  $item['longitude'] !== ''
                ) {
                  $jumlahLokasi++;
                }
              }
              ?>
              <?= $jumlahLokasi ?>
            </div>
            <div class="text-muted small mt-1">
              memiliki koordinat lokasi
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body p-4">
            <div class="text-muted small mb-2">
              Data Tanpa Lokasi
            </div>
            <div class="fs-2 fw-bold text-warning">
              <?= count($distributor) - $jumlahLokasi ?>
            </div>
            <div class="text-muted small mt-1">
              belum memiliki koordinat
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white border-0 p-4">
        <div>
          <h5 class="fw-bold mb-1">Peta Lokasi Distributor</h5>
          <p class="text-muted small mb-0">
            Lokasi distributor berdasarkan koordinat yang tersimpan.
          </p>
        </div>
      </div>
      <div class="card-body p-3">
        <div class="distributor-map">
          <div id="map"></div>
        </div>
      </div>
    </div>
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-0 p-4">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h5 class="fw-bold mb-1">Daftar Distributor</h5>
            <p class="text-muted small mb-0">
              Data lengkap distributor yang terdaftar.
            </p>
          </div>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="px-4">No</th>
                <th>Nama Distributor</th>
                <th>Alamat</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th class="text-center px-4">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($distributor)): ?>
                <tr>
                  <td
                    colspan="6"
                    class="text-center py-5">
                    <div class="text-muted">
                      <div class="fs-5 mb-2">
                        Belum ada distributor
                      </div>
                      <div class="small">
                        Tambahkan distributor untuk mulai mengelola informasi distribusi.
                      </div>
                    </div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($distributor as $index => $item): ?>
                  <tr>
                    <td class="px-4 fw-semibold">
                      <?= $index + 1 ?>
                    </td>
                    <td>
                      <div class="fw-semibold">
                        <?= esc($item['nama_distributor']) ?>
                      </div>
                    </td>
                    <td>
                      <div class="text-muted" style="max-width: 350px;">
                        <?= esc($item['alamat_distributor']) ?>
                      </div>
                    </td>
                    <td>
                      <?php if ($item['latitude'] !== null && $item['latitude'] !== ''): ?>
                        <span class="font-monospace small">
                          <?= esc($item['latitude']) ?>
                        </span>
                      <?php else: ?>
                        <span class="text-muted">-</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if ($item['longitude'] !== null && $item['longitude'] !== ''): ?>
                        <span class="font-monospace small">
                          <?= esc($item['longitude']) ?>
                        </span>
                      <?php else: ?>
                        <span class="text-muted">-</span>
                      <?php endif; ?>
                    </td>
                    <td class="px-4">
                      <div class="d-flex justify-content-center gap-2">
                        <a href="/distributor/edit/<?= $item['id_distributor'] ?>" class="btn btn-sm btn-primary">
                          Edit
                        </a>
                        <form action="/distributor/delete/<?= $item['id_distributor'] ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus distributor ini?')">
                          <button type="submit" class="btn btn-sm btn-danger">
                            Hapus
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="mt-3 text-muted small">
      Menampilkan <strong><?= count($distributor) ?></strong> distributor.
    </div>
  </div>
</main>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
  const distributors = <?= json_encode($distributor) ?>;
  const defaultLatitude = -7.2575;
  const defaultLongitude = 112.7521;

  const map = L.map('map').setView([defaultLatitude, defaultLongitude], 10);

  L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }
  ).addTo(map);

  const markerGroup = L.featureGroup();

  distributors.forEach(function(item) {
    const latitude =
      parseFloat(item.latitude);
    const longitude =
      parseFloat(item.longitude);
    if (Number.isNaN(latitude) || Number.isNaN(longitude)) {
      return;
    }

    const marker = L.marker([latitude, longitude]);

    marker.bindPopup(`
      <div style="min-width: 200px;">
        <div class="fw-bold mb-1">
          ${escapeHtml(item.nama_distributor)}
        </div>
        <div class="small">
          ${escapeHtml(item.alamat_distributor)}
        </div>
        <hr class="my-2">
        <div class="small text-muted">
          Lat: ${latitude}
          <br>
          Long: ${longitude}
        </div>
      </div>
    `);

    marker.addTo(markerGroup);
  });

  markerGroup.addTo(map);

  if (markerGroup.getLayers().length > 0) {
    map.fitBounds(markerGroup.getBounds().pad(0.1));
  }

  function escapeHtml(value) {
    return String(value)
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
  }
</script>

<?= $this->include('layout/footer') ?>