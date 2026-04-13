<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\AlatModel;
use App\Models\SettingModel;

class Pengembalian extends BaseController
{

    protected $peminjamanModel;
    protected $alatModel;
    protected $settingModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->alatModel = new AlatModel();
        $this->settingModel = new SettingModel();
    }

    // ==============================
    // LIST DATA
    // ==============================
    public function index()
{
    $db = \Config\Database::connect();

    $pengembalian = $this->peminjamanModel
    ->select('
        peminjaman.*,
        users.nama,
        users.no_hp,
        users.alamat,
        alat.nama_alat
    ')
    ->join('users','users.id = peminjaman.user_id')
    ->join('alat','alat.id = peminjaman.alat_id')
    ->whereIn('peminjaman.status',['menunggu_verifikasi','selesai'])
    ->orderBy('peminjaman.id','DESC')
    ->findAll();

    // ✅ HITUNG DENDA VIA FUNCTION
    foreach ($pengembalian as &$row) {
        if ($row['tanggal_dikembalikan']) {

            $query = $db->query("
                SELECT hitung_denda(?, ?) AS denda
            ", [
                $row['tanggal_kembali'],
                $row['tanggal_dikembalikan']
            ]);

            $result = $query->getRowArray();

            $row['denda'] = $result['denda'];
        } else {
            $row['denda'] = 0;
        }
    }

    $data['pengembalian'] = $pengembalian;

    return view('admin/pengembalian/index',$data);
}


    // ==============================
    // DETAIL
    // ==============================
    public function detail($id)
{
    $db = \Config\Database::connect();

    $peminjaman = $this->peminjamanModel
        ->select('peminjaman.*, users.nama, alat.nama_alat')
        ->join('users','users.id = peminjaman.user_id')
        ->join('alat','alat.id = peminjaman.alat_id')
        ->where('peminjaman.id',$id)
        ->first();

    if(!$peminjaman){
        return redirect()->back()->with('error','Data tidak ditemukan');
    }

    // ✅ HITUNG DENDA VIA FUNCTION
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

    $selisih = floor($denda / 5000);

    $peminjaman['denda'] = $denda;
    $data['peminjaman'] = $peminjaman;
    $data['selisih'] = $selisih;

    return view('admin/pengembalian/detail',$data);
}


    // ==============================
    // EDIT
    // ==============================
    public function edit($id)
{
    $db = \Config\Database::connect();

    // Ambil data peminjaman + relasi
    $peminjaman = $this->peminjamanModel
        ->select('peminjaman.*, users.nama, alat.nama_alat')
        ->join('users','users.id = peminjaman.user_id')
        ->join('alat','alat.id = peminjaman.alat_id')
        ->where('peminjaman.id',$id)
        ->first();

    if (!$peminjaman) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    // ✅ Ambil tarif dari settings (DINAMIS)
    $tarif = $this->settingModel->getValue('denda_per_hari') ?? 0;

    // ✅ Hitung denda real-time pakai FUNCTION DB
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

    $peminjaman['denda'] = $denda;

    return view('admin/pengembalian/edit', [
        'peminjaman' => $peminjaman,
        'tarif'      => $tarif
    ]);
}



    // ==============================
    // UPDATE PENGEMBALIAN
    // ==============================
    public function update($id)
{
    $db = \Config\Database::connect();
    $db->transStart();

    $peminjaman = $this->peminjamanModel->find($id);

    $tanggalDikembalikan = $this->request->getPost('tanggal_dikembalikan');
    $statusBaru = $this->request->getPost('status');
    $keterangan = $this->request->getPost('keterangan');

    // ❌ HAPUS HITUNG DENDA
    // ❌ HAPUS UPDATE STOK

    $this->peminjamanModel->update($id,[

        'tanggal_dikembalikan' => $tanggalDikembalikan,
        'status' => $statusBaru,
        'keterangan' => $keterangan

    ]);

    $db->transComplete();

    $user = db_connect()->table('users')
        ->where('id', $peminjaman['user_id'])
        ->get()
        ->getRowArray();

    $alat = $this->alatModel->find($peminjaman['alat_id']);

    logAktivitas(
        'Verifikasi Pengembalian',
        'Admin memverifikasi pengembalian alat: '.$alat['nama_alat'].' dari '.$user['nama']
    );
    
    return redirect()->to('/admin/pengembalian')
        ->with('success','Pengembalian berhasil diverifikasi');
}
}