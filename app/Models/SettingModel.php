<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table      = 'settings';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = ['nama', 'value', 'updated_at'];

    // =========================
    // AMBIL VALUE
    // =========================
    public function getValue($nama)
    {
        $data = $this->where('nama', $nama)->first();

        return $data ? $data['value'] : null;
    }

    // =========================
    // UPDATE VALUE
    // =========================
    public function setValue($nama, $value)
    {
        return $this->where('nama', $nama)
            ->set(['value' => $value])
            ->update();
    }
}