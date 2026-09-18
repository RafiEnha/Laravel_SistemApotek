<?php

namespace App\Controllers;

use App\Models\ObatModel;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;

class TransaksiController extends BaseController
{
  public function index()
  {
    $obatModel = new ObatModel();
    return view('transaksi/index', [
      'obat' => $obatModel->findAll()
    ]);
  }

  public function store()
  {
    $ids = $this->request->getPost('id_obat');
    $jumlahs = $this->request->getPost('jumlah');
    if (!is_array($ids) || !is_array($jumlahs) || count($ids) === 0) {
      return redirect()->back()->with(
        'error',
        'Minimal satu obat harus dipilih.'
      );
    }
    $items = [];
    foreach ($ids as $index => $idObat) {
      $idObat = (int) $idObat;
      $jumlah = (int) ($jumlahs[$index] ?? 0);
      if ($idObat <= 0 || $jumlah <= 0) {
        return redirect()->back()->with(
          'error',
          'Obat dan jumlah harus valid.'
        );
      }
      if (isset($items[$idObat])) {
        $items[$idObat] += $jumlah;
      } else {
        $items[$idObat] = $jumlah;
      }
    }
    $obatModel = new ObatModel();
    $transaksiModel = new TransaksiModel();
    $detailModel = new DetailTransaksiModel();
    $db = db_connect();
    $db->transBegin();
    try {
      $total = 0;
      $details = [];
      foreach ($items as $idObat => $jumlah) {
        $query = $db->query(
          'SELECT id_obat, nama_obat, harga_obat, stock_obat
                     FROM obat
                     WHERE id_obat = ?
                     FOR UPDATE',
          [$idObat]
        );
        $obat = $query->getRowArray();
        if (!$obat) {
          throw new \Exception(
            'Obat dengan ID ' . $idObat . ' tidak ditemukan.'
          );
        }
        if ($obat['stock_obat'] < $jumlah) {
          throw new \Exception(
            'Stock ' . $obat['nama_obat'] .
              ' tidak mencukupi.'
          );
        }
        $harga = (float) $obat['harga_obat'];
        $subtotal = $harga * $jumlah;
        $total += $subtotal;
        $details[] = [
          'id_obat'  => $idObat,
          'jumlah'   => $jumlah,
          'harga'    => $harga,
          'subtotal' => $subtotal,
        ];
      }
      $transaksiModel->insert([
        'tanggal_transaksi' => date('Y-m-d H:i:s'),
        'total'             => $total,
      ]);
      $idTransaksi = $transaksiModel->getInsertID();
      foreach ($details as $detail) {
        $detailModel->insert([
          'id_transaksi' => $idTransaksi,
          'id_obat'      => $detail['id_obat'],
          'jumlah'       => $detail['jumlah'],
          'harga'        => $detail['harga'],
          'subtotal'     => $detail['subtotal'],
        ]);
        $db->table('obat')
          ->set(
            'stock_obat',
            'stock_obat - ' . $detail['jumlah'],
            false
          )
          ->where('id_obat', $detail['id_obat'])
          ->where('stock_obat >=', $detail['jumlah'])
          ->update();
        if ($db->affectedRows() !== 1) {
          throw new \Exception(
            'Gagal mengurangi stock obat.'
          );
        }
      }
      if ($db->transStatus() === false) {
        throw new \Exception(
          'Gagal menyimpan transaksi.'
        );
      }
      $db->transCommit();
      return redirect()->to(
        '/transaksi/struk/' . $idTransaksi
      )->with(
        'success',
        'Transaksi berhasil disimpan.'
      );
    } catch (\Throwable $e) {
      $db->transRollback();
      return redirect()->back()->with(
        'error',
        $e->getMessage()
      );
    }
  }
  
  public function struk($id)
  {
    $transaksiModel = new TransaksiModel();
    $transaksi = $transaksiModel->find((int) $id);
    if (!$transaksi) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
        'Transaksi tidak ditemukan.'
      );
    }
    $db = db_connect();
    $details = $db->table('detail_transaksi dt')
      ->select(
        'dt.*, o.nama_obat, o.satuan_obat'
      )
      ->join(
        'obat o',
        'o.id_obat = dt.id_obat'
      )
      ->where(
        'dt.id_transaksi',
        (int) $id
      )
      ->get()
      ->getResultArray();
    return view('transaksi/struk', [
      'transaksi' => $transaksi,
      'details'   => $details,
    ]);
  }
}
