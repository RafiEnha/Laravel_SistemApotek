<?php

namespace App\Models;

use CodeIgniter\Model;

class DistributorModel extends Model
{
    protected $table            = 'distributor';
    protected $primaryKey       = 'id_distributor';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'nama_distributor',
        'alamat_distributor',
        'latitude',
        'longitude',
    ];
}