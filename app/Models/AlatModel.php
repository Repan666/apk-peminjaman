<?php

namespace App\Models;

use CodeIgniter\Model;

class AlatModel extends Model
{
    protected $table = 'alat';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'kode_alat',
        'nama_alat',
        'kategori_id',
        'stok',
        'kondisi',
        'status'
    ];

    protected $useTimestamps = true;
}