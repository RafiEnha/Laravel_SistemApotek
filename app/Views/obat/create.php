<?= $this->include('layout/header') ?>

<?= $this->include('layout/sidebar') ?>

<main>
  <div class="container-fluid py-4">
    <div class="mb-4">
      <h2 class="fw-bold mb-1">Tambah Obat</h2>
      <p class="text-muted mb-0">
        Tambahkan data obat baru ke dalam sistem.
      </p>
    </div>
    <div class="row">
      <div class="col-lg-8 col-xl-7">
        <div class="card border-0 shadow-sm">
          <div class="card-body p-4">
            <form action="/obat/store" method="post">
              <div class="mb-3">
                <label for="kode_obat" class="form-label fw-semibold">
                  Kode Obat
                </label>
                <input type="text" class="form-control" id="kode_obat" name="kode_obat" maxlength="45" required>
                <div class="form-text">
                  Maksimal 45 karakter.
                </div>
              </div>
              <div class="mb-3">
                <label for="nama_obat" class="form-label fw-semibold">
                  Nama Obat
                </label>
                <input type="text" class="form-control" id="nama_obat" name="nama_obat" maxlength="255" required>
              </div>
              <div class="mb-3">
                <label for="satuan_obat" class="form-label fw-semibold">
                  Satuan Obat
                </label>
                <input type="text" class="form-control" id="satuan_obat" name="satuan_obat" maxlength="45" required>
              </div>
              <div class="mb-3">
                <label for="harga_obat" class="form-label fw-semibold">
                  Harga Obat
                </label>
                <div class="input-group">
                  <span class="input-group-text">
                    Rp
                  </span>
                  <input type="number" class="form-control" id="harga_obat" name="harga_obat" min="0" step="0.01" required>
                </div>
              </div>
              <div class="mb-4">
                <label for="stock_obat" class="form-label fw-semibold">
                  Stock Obat
                </label>
                <input type="number" class="form-control" id="stock_obat" name="stock_obat" min="0" required>
              </div>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                  Simpan Obat
                </button>
                <a href="/obat" class="btn btn-outline-secondary">
                  Batal
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?= $this->include('layout/footer') ?>