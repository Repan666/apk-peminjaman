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
    $db = \Config\Database::connect();

    $peminjaman = $this->peminjamanModel
        ->select('peminjaman.*, users.nama as nama_user, alat.nama_alat, alat.kode_alat')
        ->join('users','users.id = peminjaman.user_id')
        ->join('alat','alat.id = peminjaman.alat_id')
        ->where('peminjaman.id',$id)
        ->first();

    if(!$peminjaman){
        return redirect()->back()->with('error','Data tidak ditemukan');
    }

    // ✅ ambil tarif dari settings
    $settingModel = new \App\Models\SettingModel();
    $tarif = $settingModel->getValue('denda_per_hari') ?? 0;

    // ✅ hitung denda dari function DB
    if ($peminjaman['tanggal_dikembalikan']) {
        $query = $db->query("
            SELECT hitung_denda(?, ?) AS denda
        ", [
            $peminjaman['tanggal_kembali'],
            $peminjaman['tanggal_dikembalikan']
        ]);

        $result = $query->getRowArray();
        $denda = $result['denda'];
    } else {
        $denda = 0;
    }

    // ✅ hitung selisih dinamis (jangan hardcode 5000)
    $selisih = $tarif > 0 ? floor($denda / $tarif) : 0;

    return view('petugas/pengembalian/detail', [
        'peminjaman' => $peminjaman,
        'denda'      => $denda,
        'selisih'    => $selisih,
        'tarif'      => $tarif
    ]);
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

    // ✅ CUMA UPDATE STATUS
    $this->peminjamanModel->update($id,[
        'status' => 'selesai'
    ]);

    $db->transComplete();

    $namaPetugas = session()->get('nama') ?? 'Petugas';

    logAktivitas(
        'Verifikasi Pengembalian',
        'Petugas ' . $namaPetugas . ' memverifikasi pengembalian alat'
    );

    return redirect()->to('/petugas/pengembalian')
        ->with('success','Pengembalian berhasil diverifikasi');
}
}