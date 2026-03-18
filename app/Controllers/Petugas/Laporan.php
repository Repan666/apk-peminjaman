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

        $builder = $this->peminjamanModel
            ->select('
                peminjaman.id,
                users.nama AS nama_peminjam,
                alat.nama_alat,
                peminjaman.tanggal_pinjam,
                peminjaman.tanggal_kembali,
                peminjaman.status
            ')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id');

        if($tanggal_awal && $tanggal_akhir){
            $builder->where('peminjaman.tanggal_pinjam >=',$tanggal_awal);
            $builder->where('peminjaman.tanggal_pinjam <=',$tanggal_akhir);
        }

        $data['laporan'] = $builder->orderBy('peminjaman.id','DESC')->findAll();

        return view('petugas/laporan/peminjaman',$data);
    }



    // ==========================
    // LAPORAN PENGEMBALIAN
    // ==========================
    public function pengembalian()
    {

        $tanggal_awal  = $this->request->getGet('tanggal_awal');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');

        $builder = $this->peminjamanModel
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
            ->where('peminjaman.status','selesai');

        if($tanggal_awal && $tanggal_akhir){
            $builder->where('peminjaman.tanggal_dikembalikan >=',$tanggal_awal);
            $builder->where('peminjaman.tanggal_dikembalikan <=',$tanggal_akhir);
        }

        $data['laporan'] = $builder->orderBy('peminjaman.id','DESC')->findAll();

        return view('petugas/laporan/pengembalian',$data);
    }
}