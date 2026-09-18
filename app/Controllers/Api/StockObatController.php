<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ObatModel;

class StockObatController extends BaseController
{
  public function index()
  {
    $model = new ObatModel();
    $obat = $model
      ->select(['id_obat', 'kode_obat', 'nama_obat', 'satuan_obat', 'stock_obat',])
      ->orderBy('nama_obat', 'ASC')
      ->findAll();

    return $this->response
      ->setStatusCode(200)
      ->setJSON([
        'status' => true,
        'message' => 'Data stock obat berhasil diambil.',
        'data' => $obat,
      ]);
  }

  public function show($id)
  {
    $model = new ObatModel();
    $obat = $model
      ->select(['id_obat', 'kode_obat', 'nama_obat', 'satuan_obat', 'stock_obat',])
      ->find((int) $id);

    if (!$obat) {
      return $this->response
        ->setStatusCode(404)
        ->setJSON([
          'status' => false,
          'message' => 'Obat tidak ditemukan.'
        ]);
    }

    return $this->response
      ->setStatusCode(200)
      ->setJSON([
        'status' => true,
        'message' => 'Data stock obat berhasil diambil.',
        'data' => $obat,
      ]);
  }
}
