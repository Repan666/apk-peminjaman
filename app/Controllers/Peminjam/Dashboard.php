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
            'title'         => 'Dashboard Peminjam',
            // Total semua riwayat pinjam milik user ini
            'total_pinjam'  => $this->peminjamanModel->where('user_id', $userId)->countAllResults(),
            // Total alat yang statusnya 'dipinjam' (masih dibawa user)
            'total_aktif'   => $this->peminjamanModel->where('user_id', $userId)->where('status', 'dipinjam')->countAllResults(),
            
            // Ambil 5 riwayat terakhir dengan join ke alat dan kategori
            'pengajuan_terakhir' => $this->peminjamanModel->select('peminjaman.*, alat.nama_alat, kategori.nama_kategori')
                                    ->join('alat', 'alat.id = peminjaman.alat_id')
                                    ->join('kategori', 'kategori.id = alat.kategori_id', 'left')
                                    ->where('peminjaman.user_id', $userId)
                                    ->orderBy('peminjaman.created_at', 'DESC')
                                    ->limit(5)
                                    ->find()
        ];

        return view('peminjam/dashboard', $data);
    }
}