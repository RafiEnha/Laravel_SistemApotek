<?php

namespace App\Controllers;

use App\Models\DistributorModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DistributorController extends BaseController
{
  public function index()
  {
    $model = new DistributorModel();

    return view('distributor/index', [
      'distributor' => $model
        ->orderBy('id_distributor', 'ASC')
        ->findAll(),
    ]);
  }

  public function create()
  {
    return view('distributor/create');
  }

  public function store()
  {
    $model = new DistributorModel();
    $data = [
      'nama_distributor'   => $this->request->getPost('nama_distributor'),
      'alamat_distributor' => $this->request->getPost('alamat_distributor'),
      'latitude'           => $this->request->getPost('latitude'),
      'longitude'          => $this->request->getPost('longitude'),
    ];
    $model->insert($data);
    return redirect()->to('/distributor');
  }

  public function edit(int|string $id)
  {
    $model = new DistributorModel();
    $distributor = $model->find((int) $id);
    if ($distributor === null) {
      throw PageNotFoundException::forPageNotFound(
        'Distributor tidak ditemukan.'
      );
    }
    return view('distributor/edit', [
      'distributor' => $distributor,
    ]);
  }

  public function update(int|string $id)
  {
    $model = new DistributorModel();
    $data = [
      'nama_distributor'   => $this->request->getPost('nama_distributor'),
      'alamat_distributor' => $this->request->getPost('alamat_distributor'),
      'latitude'           => $this->request->getPost('latitude'),
      'longitude'          => $this->request->getPost('longitude'),
    ];
    $model->update((int) $id, $data);
    return redirect()->to('/distributor');
  }

  public function delete(int|string $id)
  {
    $model = new DistributorModel();
    $model->delete((int) $id);
    return redirect()->to('/distributor');
  }
}
