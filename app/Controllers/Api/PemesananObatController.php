<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ObatModel;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;

class PemesananObatController extends BaseController
{
  public function store()
  {
    $data = $this->request->getJSON(true);

    if (!is_array($data)) {
      return $this->response
        ->setStatusCode(400)
        ->setJSON([
          'status' => false,
          'message' => 'Request harus berupa JSON.'
        ]);
    }
    $items = $data['items'] ?? null;
    if (!is_array($items) || empty($items)) {
      return $this->response
        ->setStatusCode(400)
        ->setJSON([
          'status' => false,
          'message' => 'Items tidak boleh kosong.'
        ]);
    }
    $db = db_connect();
    $transaksiModel = new TransaksiModel();
    $detailModel = new DetailTransaksiModel();
    $db->transBegin();
    try {
      $details = [];
      $total = 0;
      foreach ($items as $item) {
        $idObat = (int) ($item['id_obat'] ?? 0);
        $jumlah = (int) ($item['jumlah'] ?? 0);
        if ($idObat <= 0 || $jumlah <= 0) {
          throw new \Exception(
            'id_obat dan jumlah harus valid.'
          );
        }
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
            'Obat dengan ID ' .
              $idObat .
              ' tidak ditemukan.'
          );
        }
        if ((int) $obat['stock_obat'] < $jumlah) {
          throw new \Exception(
            'Stock obat "' .
              $obat['nama_obat'] .
              '" tidak mencukupi.'
          );
        }
        $harga = (float) $obat['harga_obat'];
        $subtotal = $harga * $jumlah;
        $total += $subtotal;
        $details[] = [
          'id_obat' => $idObat,
          'jumlah' => $jumlah,
          'harga' => $harga,
          'subtotal' => $subtotal,
        ];
      }
      $transaksiModel->insert([
        'tanggal_transaksi' => date('Y-m-d H:i:s'),
        'total' => $total,
      ]);
      $idTransaksi = $transaksiModel->getInsertID();
      foreach ($details as $detail) {
        $detailModel->insert([
          'id_transaksi' => $idTransaksi,
          'id_obat' => $detail['id_obat'],
          'jumlah' => $detail['jumlah'],
          'harga' => $detail['harga'],
          'subtotal' => $detail['subtotal'],
        ]);
        $db->table('obat')
          ->set(
            'stock_obat',
            'stock_obat - ' . $detail['jumlah'],
            false
          )
          ->where(
            'id_obat',
            $detail['id_obat']
          )
          ->where(
            'stock_obat >=',
            $detail['jumlah']
          )
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
      return $this->response
        ->setStatusCode(201)
        ->setJSON([
          'status' => true,
          'message' => 'Pemesanan obat berhasil.',
          'data' => [
            'id_transaksi' => $idTransaksi,
            'total' => $total,
          ]
        ]);
    } catch (\Throwable $e) {
      $db->transRollback();
      return $this->response
        ->setStatusCode(400)
        ->setJSON([
          'status' => false,
          'message' => $e->getMessage()
        ]);
    }
  }
}
