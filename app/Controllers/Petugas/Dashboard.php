<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $peminjamanModel = new PeminjamanModel();

        $data = [
            'title'         => 'Dashboard Petugas',
            'pending_count' => $peminjamanModel->where('status', 'pending')->countAllResults(),
            'aktif_count'   => $peminjamanModel->where('status', 'dipinjam')->countAllResults(),
            'kembali_today' => $peminjamanModel->where('status', 'selesai')
                                               ->where('updated_at >=', date('Y-m-d 00:00:00'))
                                               ->countAllResults(),
            
            // Hapus users.kelas karena tidak ada di DB
            'antrean'       => $peminjamanModel->select('peminjaman.*, users.nama as nama_siswa, alat.nama_alat')
                                               ->join('users', 'users.id = peminjaman.user_id')
                                               ->join('alat', 'alat.id = peminjaman.alat_id')
                                               ->where('peminjaman.status', 'pending')
                                               ->orderBy('peminjaman.created_at', 'ASC')
                                               ->limit(5)
                                               ->find()
        ];

        return view('petugas/dashboard', $data);
    }
}