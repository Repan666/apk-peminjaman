<?php

namespace App\Controllers\Peminjam;

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

   public function ajukan()
{
    $userId = session()->get('user_id');
    $alatId = $this->request->getPost('alat_id');

    $tanggalPinjam  = $this->request->getPost('tanggal_pinjam');
    $tanggalKembali = $this->request->getPost('tanggal_kembali');

    // CEK apakah user masih memiliki peminjaman aktif pada alat yang sama
    $cek = $this->peminjamanModel
        ->where('user_id', $userId)
        ->where('alat_id', $alatId)
        ->whereIn('status', ['pending','dipinjam','menunggu_verifikasi'])
        ->first();

    if($cek){
        return redirect()->back()
            ->with('error','Anda masih memiliki peminjaman aktif untuk alat ini');
    }

    // =========================
    // VALIDASI TANGGAL
    // =========================
    if($tanggalKembali < $tanggalPinjam){
        return redirect()->back()
            ->with('error','Tanggal kembali tidak boleh lebih kecil dari tanggal pinjam');
    }

    $data = [
        'user_id'         => $userId,
        'alat_id'         => $alatId,
        'tanggal_pinjam'  => $tanggalPinjam,
        'tanggal_kembali' => $tanggalKembali,
        'status'          => 'pending',
        'keterangan'      => $this->request->getPost('keterangan')
    ];

    $this->peminjamanModel->insert($data);
    $alat = $this->alatModel->find($alatId);
    $namaUser = session()->get('nama');

    logAktivitas(
        'Ajukan Peminjaman',
        'Peminjam ' . $namaUser . ' mengajukan peminjaman alat: ' . $alat['nama_alat']
    );

    return redirect()->to('/peminjam/riwayat')
        ->with('success','Pengajuan berhasil dikirim, menunggu persetujuan petugas');
}

    public function form($alat_id)
{
    $alat = $this->alatModel->find($alat_id);

    if (!$alat) {
        return redirect()->back()->with('error', 'Alat tidak ditemukan');
    }

    if ($alat['stok'] <= 0) {
        return redirect()->back()->with('error', 'Stok alat habis');
    }

    $data = [
        'alat' => $alat
    ];

    return view('peminjam/peminjaman/form', $data);
}

public function riwayat()
{
    $userId = session()->get('user_id');

    $riwayat = $this->peminjamanModel
        ->select('peminjaman.*, alat.nama_alat, alat.kode_alat, kategori.nama_kategori') // Tambah kategori biar informatif
        ->join('alat', 'alat.id = peminjaman.alat_id')
        ->join('kategori', 'kategori.id = alat.kategori_id', 'left')
        ->where('peminjaman.user_id', $userId)
        ->orderBy('peminjaman.id', 'DESC')
        ->findAll();

    $data = [
        'title'   => 'Riwayat Peminjaman',
        'riwayat' => $riwayat
    ];

    return view('peminjam/peminjaman/riwayat', $data);
}

public function aktif()
{
    $userId = session()->get('user_id');

    $data['peminjaman'] = $this->peminjamanModel
        ->select('peminjaman.*, alat.nama_alat')
        ->join('alat','alat.id = peminjaman.alat_id')
        ->where('peminjaman.user_id',$userId)
        ->where('peminjaman.status','dipinjam')
        ->findAll();

    return view('peminjam/peminjaman/pinjaman_aktif',$data);
}
public function ajukanPengembalian($id)
{
    $peminjaman = $this->peminjamanModel->find($id);

    if(!$peminjaman){
        return redirect()->back()->with('error','Data tidak ditemukan');
    }

    if($peminjaman['status'] != 'dipinjam'){
        return redirect()->back()->with('error','Status tidak valid');
    }

    $this->peminjamanModel->update($id,[
        'status' => 'menunggu_verifikasi',
        'tanggal_dikembalikan' => date('Y-m-d')
    ]);

    $alat = $this->alatModel->find($peminjaman['alat_id']);
    $namaUser = session()->get('nama');

    logAktivitas(
        'Ajukan Pengembalian',
        'Peminjam ' . $namaUser . ' mengajukan pengembalian alat: ' . $alat['nama_alat']
    );

    return redirect()->back()->with('success','Pengembalian diajukan, menunggu verifikasi petugas');
}
}