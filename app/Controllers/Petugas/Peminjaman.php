<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\AlatModel;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;
    protected $alatModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->alatModel = new AlatModel();
    }

    public function index()
    {
        // Mengambil semua data peminjaman yang statusnya PENDING untuk diverifikasi
        // Dan juga menampilkan yang sudah jalan (DIPINJAM) sebagai monitoring
        $peminjaman = $this->peminjamanModel
            ->select('peminjaman.*, users.nama as nama_user, users.role as role_user, alat.nama_alat, alat.kode_alat')
            ->join('users', 'users.id = peminjaman.user_id')
            ->join('alat', 'alat.id = peminjaman.alat_id')
            ->orderBy('peminjaman.id', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Verifikasi Peminjaman',
            'peminjaman' => $peminjaman
        ];

        return view('petugas/peminjaman/index', $data);
    }
    public function detail($id)
{
    $peminjaman = $this->peminjamanModel
        ->select('peminjaman.*, users.nama as nama_user, alat.nama_alat, alat.kode_alat, alat.stok')
        ->join('users','users.id = peminjaman.user_id')
        ->join('alat','alat.id = peminjaman.alat_id')
        ->where('peminjaman.id',$id)
        ->first();

    if(!$peminjaman){
        return redirect()->to('/petugas/peminjaman');
    }

    $data = [
        'title' => 'Detail Peminjaman',
        'peminjaman' => $peminjaman
    ];

    return view('petugas/peminjaman/detail',$data);
}
public function setuju($id)
{
    // ambil data peminjaman
    $peminjaman = $this->peminjamanModel->find($id);

    if(!$peminjaman){
        return redirect()->back()->with('error','Data tidak ditemukan');
    }

    // ambil data alat
    $alat = $this->alatModel->find($peminjaman['alat_id']);

    if(!$alat){
        return redirect()->back()->with('error','Data alat tidak ditemukan');
    }

    // cek stok
    if($alat['stok'] <= 0){
        return redirect()->back()->with('error','Stok alat habis');
    }

    // kurangi stok
    $this->alatModel->update($alat['id'],[
        'stok' => $alat['stok'] - 1
    ]);

    // update status peminjaman
    $this->peminjamanModel->update($id,[
        'status' => 'dipinjam'
    ]);

    return redirect()->to('/petugas/peminjaman')
        ->with('success','Peminjaman disetujui');
}
public function tolak($id)
{
    $this->peminjamanModel->update($id,[
        'status' => 'ditolak'
    ]);

    return redirect()->to('/petugas/peminjaman')
        ->with('success','Pengajuan ditolak');
}
}