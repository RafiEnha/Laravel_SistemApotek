<?php

namespace App\Controllers;

class LaporanController extends BaseController
{
  public function penjualan()
  {
    $db = db_connect();

    $laporan = $db->table('obat o')
      ->select(
        '
                o.id_obat,
                o.kode_obat,
                o.nama_obat,
                o.satuan_obat,
                o.harga_obat,
                o.stock_obat,
                COALESCE(SUM(dt.jumlah), 0) AS total_terjual,
                COALESCE(SUM(dt.subtotal), 0) AS total_penjualan
                ',
        false
      )
      ->join(
        'detail_transaksi dt',
        'dt.id_obat = o.id_obat',
        'left'
      )
      ->groupBy([
        'o.id_obat',
        'o.kode_obat',
        'o.nama_obat',
        'o.satuan_obat',
        'o.harga_obat',
        'o.stock_obat',
      ])
      ->orderBy('o.nama_obat', 'ASC')
      ->get()
      ->getResultArray();
    $totalTerjual = 0;
    $totalPenjualan = 0;
    foreach ($laporan as $item) {
      $totalTerjual += (int) $item['total_terjual'];
      $totalPenjualan += (float) $item['total_penjualan'];
    }
    return view('laporan/penjualan', [
      'laporan'        => $laporan,
      'totalTerjual'   => $totalTerjual,
      'totalPenjualan' => $totalPenjualan,
    ]);
  }
}
