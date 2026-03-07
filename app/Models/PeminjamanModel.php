<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table      = 'peminjaman';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'alat_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'denda',
        'status',
        'keterangan'
    ];

    protected $useTimestamps = true;
}