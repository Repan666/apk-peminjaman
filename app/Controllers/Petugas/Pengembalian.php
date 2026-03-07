<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\AlatModel;

class Pengembalian extends BaseController
{
    protected $peminjamanModel;
    protected $alatModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->alatModel = new AlatModel();
    }

    // LIST VERIFIKASI PENGEMBALIAN
    public function index()
    {
        $data['pengembalian'] = $this->peminjamanModel
            ->select('peminjaman.*, users.nama as nama_user, alat.nama_alat, alat.kode_alat')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->where('peminjaman.status','menunggu_verifikasi')
            ->orderBy('peminjaman.tanggal_dikembalikan','ASC')
            ->findAll();

        return view('petugas/pengembalian/index',$data);
    }

    // DETAIL PENGEMBALIAN
    public function detail($id)
    {
        $peminjaman = $this->peminjamanModel
            ->select('peminjaman.*, users.nama as nama_user, alat.nama_alat, alat.kode_alat')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->where('peminjaman.id',$id)
            ->first();

        if(!$peminjaman){
            return redirect()->back()->with('error','Data tidak ditemukan');
        }

        // hitung selisih hari
        $tgl_kembali = strtotime($peminjaman['tanggal_kembali']);
        $tgl_dikembalikan = strtotime($peminjaman['tanggal_dikembalikan']);

        $selisih = floor(($tgl_dikembalikan - $tgl_kembali) / 86400);

        if($selisih < 0){
            $selisih = 0;
        }

        // hitung estimasi denda
        $denda = $selisih * 5000;

        $data['peminjaman'] = $peminjaman;
        $data['selisih'] = $selisih;
        $data['denda'] = $denda;

        return view('petugas/pengembalian/detail',$data);
    }

    // VERIFIKASI PENGEMBALIAN
    public function verifikasi($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $peminjaman = $this->peminjamanModel->find($id);

        if(!$peminjaman){
            return redirect()->back()->with('error','Data tidak ditemukan');
        }

        if($peminjaman['status'] != 'menunggu_verifikasi'){
            return redirect()->back()->with('error','Status tidak valid');
        }

        // hitung denda
        $tgl_kembali = strtotime($peminjaman['tanggal_kembali']);
        $tgl_dikembalikan = strtotime($peminjaman['tanggal_dikembalikan']);

        $selisih = floor(($tgl_dikembalikan - $tgl_kembali) / 86400);

        $denda = 0;

        if($selisih > 0){
            $denda = $selisih * 5000;
        }

        // tambah stok alat
        $alat = $this->alatModel->find($peminjaman['alat_id']);

        $this->alatModel->update($alat['id'],[
            'stok' => $alat['stok'] + 1
        ]);

        // update peminjaman
        $this->peminjamanModel->update($id,[
            'status' => 'selesai',
            'denda' => $denda
        ]);

        $db->transComplete();

        return redirect()->to('/petugas/pengembalian')
        ->with('success','Pengembalian berhasil diverifikasi');
    }
}