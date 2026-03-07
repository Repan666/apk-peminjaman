<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard Petugas',
            'pending_count' => 5, // Contoh dummy, nanti ambil dari model
            'aktif_count' => 12,
            'kembali_today' => 3
        ];
        return view('petugas/dashboard', $data);
    }
}