<?php

namespace App\Controllers\Peminjam;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;

class Dashboard extends BaseController
{
    protected $peminjamanModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        $data = [
            'title' => 'Dashboard Peminjam',
            'total_pinjam' => $this->peminjamanModel
                ->where('user_id', $userId)
                ->countAllResults()
        ];

        return view('peminjam/dashboard', $data);
    }
}