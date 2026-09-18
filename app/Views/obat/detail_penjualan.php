<?php
/** @var array<string, mixed> $obat */
/** @var array<int, array<string, mixed>> $detailPenjualan */

$totalTerjual = 0;
$totalPenjualan = 0;

foreach ($detailPenjualan as $detail) {
  $totalTerjual += (int) $detail['jumlah'];
  $totalPenjualan += (float) $detail['subtotal'];
}
?>

<?= $this->include('layout/header') ?>

<?= $this->include('layout/sidebar') ?>

<main>
  <div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="fw-bold mb-1">Detail Penjualan Obat</h2>
        <p class="text-muted mb-0">
          Informasi obat dan riwayat transaksi penjualan.
        </p>
      </div>
      <a href="/obat" class="btn btn-outline-secondary">
        ← Kembali
      </a>
    </div>
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white border-0 p-4">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h5 class="fw-bold mb-1"><?= esc($obat['nama_obat']) ?></h5>
            <span class="text-muted">
              <?= esc($obat['kode_obat']) ?>
            </span>
          </div>
          <span class="badge text-bg-primary">
            ID <?= esc($obat['id_obat']) ?>
          </span>
        </div>
      </div>
      <div class="card-body">
        <div class="row g-4">
          <div class="col-md-6 col-xl-4">
            <div class="text-muted small mb-1">
              Kode Obat
            </div>
            <div class="fw-semibold">
              <?= esc($obat['kode_obat']) ?>
            </div>
          </div>
          <div class="col-md-6 col-xl-4">
            <div class="text-muted small mb-1">
              Nama Obat
            </div>
            <div class="fw-semibold">
              <?= esc($obat['nama_obat']) ?>
            </div>
          </div>
          <div class="col-md-6 col-xl-4">
            <div class="text-muted small mb-1">
              Satuan
            </div>
            <div class="fw-semibold">
              <?= esc($obat['satuan_obat']) ?>
            </div>
          </div>
          <div class="col-md-6 col-xl-4">
            <div class="text-muted small mb-1">
              Harga Saat Ini
            </div>
            <div class="fw-semibold text-primary">
              Rp
              <?= number_format(
                $obat['harga_obat'],
                0,
                ',',
                '.'
              ) ?>
            </div>
          </div>
          <div class="col-md-6 col-xl-4">
            <div class="text-muted small mb-1">
              Stock Saat Ini
            </div>
            <div>
              <?php
              $stock = (int) $obat['stock_obat'];
              ?>
              <?php if ($stock <= 10): ?>
                <span class="badge text-bg-danger fs-6">
                  <?= $stock ?>
                </span>
              <?php elseif ($stock <= 30): ?>
                <span class="badge text-bg-warning fs-6">
                  <?= $stock ?>
                </span>
              <?php else: ?>
                <span class="badge text-bg-success fs-6">
                  <?= $stock ?>
                </span>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-md-6 col-xl-4">
            <div class="text-muted small mb-1">
              Total Terjual
            </div>
            <div class="fw-semibold">
              <?= $totalTerjual ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row g-4 mb-4">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="text-muted small mb-2">
              Jumlah Transaksi
            </div>
            <div class="fs-3 fw-bold">
              <?= count($detailPenjualan) ?>
            </div>
            <div class="text-muted small mt-1">
              transaksi penjualan
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="text-muted small mb-2">
              Total Obat Terjual
            </div>
            <div class="fs-3 fw-bold">
              <?= $totalTerjual ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="text-muted small mb-2">
              Total Penjualan
            </div>
            <div class="fs-3 fw-bold text-primary">
              Rp
              <?= number_format(
                $totalPenjualan,
                0,
                ',',
                '.'
              ) ?>
            </div>
            <div class="text-muted small mt-1">
              nilai penjualan obat ini
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-0 p-4">
        <div>
          <h5 class="fw-bold mb-1">Riwayat Penjualan</h5>
          <p class="text-muted small mb-0">
            Daftar transaksi yang mengandung obat ini.
          </p>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="px-4">No</th>
                <th>ID Detail</th>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th class="text-center">Jumlah</th>
                <th class="text-end">Harga Saat Transaksi</th>
                <th class="text-end px-4">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($detailPenjualan)): ?>
                <tr>
                  <td colspan="7" class="text-center py-5">
                    <div class="text-muted">
                      <div class="fs-5 mb-2">
                        Belum ada transaksi
                      </div>
                      <div class="small">
                        Obat ini belum pernah tercatat dalam penjualan.
                      </div>
                    </div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($detailPenjualan as $index => $detail): ?>
                  <tr>
                    <td class="px-4">
                      <?= $index + 1 ?>
                    </td>
                    <td>
                      <?= esc($detail['id_detail']) ?>
                    </td>
                    <td>
                      <a href="/transaksi/struk/<?= $detail['id_transaksi'] ?>" class="text-decoration-none fw-semibold">
                        #<?= esc($detail['id_transaksi']) ?>
                      </a>
                    </td>
                    <td>
                      <?= date('d/m/Y H:i', strtotime($detail['tanggal_transaksi'])) ?>
                    </td>
                    <td class="text-center">
                      <span class="badge text-bg-secondary">
                        <?= esc($detail['jumlah']) ?>
                      </span>
                    </td>
                    <td class="text-end">
                      Rp
                      <?= number_format(
                        $detail['harga'],
                        0,
                        ',',
                        '.'
                      ) ?>
                    </td>
                    <td class="text-end px-4 fw-semibold">
                      Rp
                      <?= number_format(
                        $detail['subtotal'],
                        0,
                        ',',
                        '.'
                      ) ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
            <?php if (!empty($detailPenjualan)): ?>
              <tfoot class="table-light">
                <tr>
                  <th colspan="4" class="text-end">Total</th>
                  <th class="text-center"><?= $totalTerjual ?></th>
                  <th></th>
                  <th class="text-end px-4">
                    Rp
                    <?= number_format(
                      $totalPenjualan,
                      0,
                      ',',
                      '.'
                    ) ?>
                  </th>
                </tr>
              </tfoot>
            <?php endif; ?>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>

<?= $this->include('layout/footer') ?>