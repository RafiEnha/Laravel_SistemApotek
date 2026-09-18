<?php
/** @var array<int, array<string, mixed>> $laporan */
/** @var int $totalTerjual */
/** @var float $totalPenjualan */

$totalObat = count($laporan);
?>

<?= $this->include('layout/header') ?>

<?= $this->include('layout/sidebar') ?>

<style>
  @media print {
    .app-navbar,
    .app-sidebar,
    .no-print {
      display: none !important;
    }
    body {
      background: white !important;
    }
    main {
      margin: 0 !important;
    }
    .container-fluid {
      padding: 0 !important;
    }
    .card {
      box-shadow: none !important;
      border: 1px solid #dee2e6 !important;
    }
  }
</style>

<main>
  <div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="fw-bold mb-1">Laporan Penjualan</h2>
        <p class="text-muted mb-0">
          Laporan sisa stok dan penjualan setiap obat.
        </p>
      </div>
      <div class="d-flex no-print">
        <button type="button" class="btn btn-primary" onclick="window.print()">
          Cetak Laporan
        </button>
      </div>
    </div>
    <div class="row g-4 mb-4">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body p-4">
            <div class="text-muted small mb-2">
              Total Jenis Obat
            </div>
            <div class="fs-2 fw-bold">
              <?= $totalObat ?>
            </div>
            <div class="text-muted small mt-1">
              jenis obat dalam sistem
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body p-4">
            <div class="text-muted small mb-2">
              Total Item Terjual
            </div>
            <div class="fs-2 fw-bold">
              <?= $totalTerjual ?>
            </div>
            <div class="text-muted small mt-1">
              item obat terjual
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body p-4">
            <div class="text-muted small mb-2">
              Total Penjualan
            </div>
            <div class="fs-2 fw-bold text-primary">
              Rp
              <?= number_format(
                $totalPenjualan,
                0,
                ',',
                '.'
              ) ?>
            </div>
            <div class="text-muted small mt-1">
              total nilai penjualan
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-0 p-4">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h5 class="fw-bold mb-1">Detail Laporan</h5>
            <p class="text-muted small mb-0">
              Sisa stok dan riwayat penjualan setiap obat.
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
                <th>Kode Obat</th>
                <th>Nama Obat</th>
                <th>Satuan</th>
                <th class="text-center">Sisa Stok</th>
                <th class="text-center">Total Terjual</th>
                <th class="text-end px-4">Total Penjualan</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($laporan)): ?>
                <tr>
                  <td colspan="7" class="text-center py-5">
                    <div class="text-muted">
                      <div class="fs-5 mb-2">
                        Belum ada data
                      </div>
                      <div class="small">
                        Belum terdapat data obat untuk ditampilkan.
                      </div>
                    </div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($laporan as $index => $item): ?>
                  <?php
                  $stock = (int) $item['stock_obat'];
                  $terjual = (int) $item['total_terjual'];
                  ?>
                  <tr>
                    <td class="px-4 fw-semibold">
                      <?= $index + 1 ?>
                    </td>
                    <td>
                      <span class="badge text-bg-secondary">
                        <?= esc($item['kode_obat']) ?>
                      </span>
                    </td>
                    <td>
                      <a href="/obat/<?= $item['id_obat'] ?>/penjualan" class="text-decoration-none fw-semibold">
                        <?= esc($item['nama_obat']) ?>
                      </a>
                    </td>
                    <td>
                      <?= esc($item['satuan_obat']) ?>
                    </td>
                    <td class="text-center">
                      <?php if ($stock <= 10): ?>
                        <span class="badge text-bg-danger">
                          <?= $stock ?>
                        </span>
                      <?php elseif ($stock <= 30): ?>
                        <span class="badge text-bg-warning">
                          <?= $stock ?>
                        </span>
                      <?php else: ?>
                        <span class="badge text-bg-success">
                          <?= $stock ?>
                        </span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
                      <?php if ($terjual === 0): ?>
                        <span class="text-muted">
                          0
                        </span>
                      <?php else: ?>
                        <span class="fw-semibold">
                          <?= $terjual ?>
                        </span>
                      <?php endif; ?>
                    </td>
                    <td class="text-end px-4">
                      <span class="fw-semibold">
                        Rp
                        <?= number_format(
                          $item['total_penjualan'],
                          0,
                          ',',
                          '.'
                        ) ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
            <?php if (!empty($laporan)): ?>
              <tfoot class="table-light">
                <tr>
                  <th colspan="5" class="text-end">Total</th>
                  <th class="text-center"><?= $totalTerjual ?></th>
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
    <div class="mt-3 text-muted small">
      Laporan menampilkan <strong><?= $totalObat ?></strong> jenis obat.
      Data total terjual dan total penjualan dihitung berdasarkan transaksi yang tersimpan di sistem.
    </div>
  </div>
</main>

<?= $this->include('layout/footer') ?>