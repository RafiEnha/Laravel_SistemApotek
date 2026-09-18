<?php

namespace App\Controllers;

use App\Models\ObatModel;

class ObatController extends BaseController
{
  public function index()
  {
    $model = new ObatModel();
    $search = $this->request->getGet('search');
    $sort = $this->request->getGet('sort') ?? 'id_obat';
    $order = strtoupper(
      $this->request->getGet('order') ?? 'ASC'
    );
    $allowedSort = [
      'id_obat'    => 'id_obat',
      'nama_obat'  => 'nama_obat',
      'harga_obat' => 'harga_obat',
      'stock_obat' => 'stock_obat',
    ];
    if (!array_key_exists($sort, $allowedSort)) {
      $sort = 'id_obat';
    }
    if (!in_array($order, ['ASC', 'DESC'], true)) {
      $order = 'ASC';
    }
    if (!empty($search)) {
      $model->like(
        'nama_obat',
        $search,
        'both',
        null,
        true
      );
    }
    $model->orderBy(
      $allowedSort[$sort],
      $order
    );
    $data = [
      'obat'  => $model->findAll(),
      'search' => $search,
      'sort'  => $sort,
      'order' => $order,
    ];
    return view('obat/index', $data);
  }

  public function create()
  {
    return view('obat/create');
  }

  public function store()
  {
    $model = new ObatModel();
    $data = [
      'kode_obat'   => $this->request->getPost('kode_obat'),
      'nama_obat'   => $this->request->getPost('nama_obat'),
      'satuan_obat' => $this->request->getPost('satuan_obat'),
      'harga_obat'  => $this->request->getPost('harga_obat'),
      'stock_obat'  => $this->request->getPost('stock_obat'),
    ];
    $model->insert($data);
    return redirect()->to('/obat');
  }

  public function edit($id)
  {
    $model = new ObatModel();
    $data = [
      'obat' => $model->find($id)
    ];
    return view('obat/edit', $data);
  }

  public function update($id)
  {
    $model = new ObatModel();
    $data = [
      'kode_obat'   => $this->request->getPost('kode_obat'),
      'nama_obat'   => $this->request->getPost('nama_obat'),
      'satuan_obat' => $this->request->getPost('satuan_obat'),
      'harga_obat'  => $this->request->getPost('harga_obat'),
      'stock_obat'  => $this->request->getPost('stock_obat'),
    ];
    $model->update($id, $data);
    return redirect()->to('/obat');
  }

  public function delete($id)
  {
    $model = new ObatModel();
    $model->delete($id);
    return redirect()->to('/obat');
  }

  public function detailPenjualan(int|string $id)
  {
    $obatModel = new ObatModel();
    $obat = $obatModel->find((int) $id);
    if ($obat === null) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
        'Obat tidak ditemukan.'
      );
    }
    $db = db_connect();
    $detailPenjualan = $db->table('detail_transaksi dt')
      ->select([
        'dt.id_detail', 'dt.id_transaksi', 't.tanggal_transaksi', 'dt.jumlah', 'dt.harga', 'dt.subtotal',
      ])
      ->join(
        'transaksi t',
        't.id_transaksi = dt.id_transaksi'
      )
      ->where(
        'dt.id_obat',
        (int) $id
      )
      ->orderBy(
        't.tanggal_transaksi',
        'DESC'
      )
      ->get()
      ->getResultArray();
    return view('obat/detail_penjualan', [
      'obat'           => $obat,
      'detailPenjualan' => $detailPenjualan,
    ]);
  }
}
