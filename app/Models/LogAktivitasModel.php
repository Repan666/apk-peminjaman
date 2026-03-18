<?php

namespace App\Models;

use CodeIgniter\Model;

class LogAktivitasModel extends Model
{
    protected $table            = 'log_aktivitas';
    protected $primaryKey       = 'id';

    protected $allowedFields = [
        'user_id',
        'aktivitas',
        'keterangan',
        'ip_address',
        'created_at'
    ];

    protected $useTimestamps = false;
}