<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;

class Laporan extends BaseController
{

    protected $peminjamanModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
    }


    // ==========================
    // LAPORAN PEMINJAMAN
    // ==========================
    public function peminjaman()
{
    $tanggal_awal  = $this->request->getGet('tanggal_awal');
    $tanggal_akhir = $this->request->getGet('tanggal_akhir');

    $db = \Config\Database::connect();

    // Kalau ada filter tanggal → pakai procedure
    if ($tanggal_awal && $tanggal_akhir) {

        $query = $db->query("CALL laporan_peminjaman(?, ?)", [
            $tanggal_awal,
            $tanggal_akhir
        ]);

        $data['laporan'] = $query->getResult();

    } else {
        // fallback (biar tetap jalan kalau tidak filter)
        $data['laporan'] = $this->peminjamanModel
            ->select('
                peminjaman.id,
                users.nama AS nama_peminjam,
                alat.nama_alat,
                peminjaman.tanggal_pinjam,
                peminjaman.tanggal_kembali,
                peminjaman.status
            ')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->orderBy('peminjaman.id','DESC')
            ->findAll();
    }

    return view('petugas/laporan/peminjaman', $data);
}



    // ==========================
    // LAPORAN PENGEMBALIAN
    // ==========================
    public function pengembalian()
{
    $tanggal_awal  = $this->request->getGet('tanggal_awal');
    $tanggal_akhir = $this->request->getGet('tanggal_akhir');

    $db = \Config\Database::connect();

    if ($tanggal_awal && $tanggal_akhir) {

        $query = $db->query("CALL laporan_pengembalian(?, ?)", [
            $tanggal_awal,
            $tanggal_akhir
        ]);

        $data['laporan'] = $query->getResult();

    } else {
        // fallback
        $data['laporan'] = $this->peminjamanModel
            ->select('
                peminjaman.id,
                users.nama AS nama_peminjam,
                alat.nama_alat,
                peminjaman.tanggal_pinjam,
                peminjaman.tanggal_kembali,
                peminjaman.tanggal_dikembalikan,
                peminjaman.denda,
                peminjaman.status
            ')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->where('peminjaman.status','selesai')
            ->orderBy('peminjaman.id','DESC')
            ->findAll();
    }

    return view('petugas/laporan/pengembalian', $data);
}
}