<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AlatModel;
use App\Models\PeminjamanModel;
use App\Models\LogAktivitasModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $alatModel = new AlatModel();
        $peminjamanModel = new PeminjamanModel();
        $logModel = new LogAktivitasModel();

        $data = [
            'title'             => 'Dashboard Admin',
            'total_user'        => $userModel->countAll(),
            'total_alat'        => $alatModel->countAll(),
            // Hitung peminjaman berdasarkan status
            'total_pending'     => $peminjamanModel->where('status', 'pending')->countAllResults(),
            'total_aktif'       => $peminjamanModel->where('status', 'dipinjam')->countAllResults(),
            
            // Ambil 5 peminjaman terbaru dengan join user dan alat
            'peminjaman_baru'   => $peminjamanModel->select('peminjaman.*, users.nama as nama_peminjam, alat.nama_alat')
                                    ->join('users', 'users.id = peminjaman.user_id')
                                    ->join('alat', 'alat.id = peminjaman.alat_id')
                                    ->orderBy('peminjaman.created_at', 'DESC')
                                    ->limit(5)
                                    ->find(),
                                    
            // Ambil 5 log aktivitas terbaru
            'recent_logs'       => $logModel->select('log_aktivitas.*, users.nama')
                                    ->join('users', 'users.id = log_aktivitas.user_id')
                                    ->orderBy('log_aktivitas.created_at', 'DESC')
                                    ->limit(5)
                                    ->find()
        ];

        return view('admin/dashboard', $data);
    }
}