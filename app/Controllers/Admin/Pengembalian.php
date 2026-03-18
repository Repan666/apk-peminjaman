<?php

namespace App\Controllers\Admin;

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

    // ==============================
    // LIST DATA
    // ==============================
    public function index()
    {

        $data['pengembalian'] = $this->peminjamanModel
            ->select('peminjaman.*, users.nama, alat.nama_alat')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->whereIn('peminjaman.status',['menunggu_verifikasi','selesai'])
            ->orderBy('peminjaman.id','DESC')
            ->findAll();

        return view('admin/pengembalian/index',$data);
    }


    // ==============================
    // DETAIL
    // ==============================
    public function detail($id)
    {

        $data['peminjaman'] = $this->peminjamanModel
            ->select('peminjaman.*, users.nama, alat.nama_alat')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->where('peminjaman.id',$id)
            ->first();

        return view('admin/pengembalian/detail',$data);
    }


    // ==============================
    // EDIT
    // ==============================
    public function edit($id)
    {

        $data['peminjaman'] = $this->peminjamanModel
            ->select('peminjaman.*, users.nama, alat.nama_alat')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->where('peminjaman.id',$id)
            ->first();

        return view('admin/pengembalian/edit',$data);
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

        $tanggalKembali = $peminjaman['tanggal_kembali'];

        // =========================
        // HITUNG SELISIH HARI
        // =========================

        $tgl1 = new \DateTime($tanggalKembali);
        $tgl2 = new \DateTime($tanggalDikembalikan);

        $selisih = $tgl2->diff($tgl1)->days;

        if($tgl2 <= $tgl1){
            $denda = 0;
        }else{
            $denda = $selisih * 5000;
        }

        // =========================
        // JIKA STATUS DIUBAH KE SELESAI
        // =========================

        if($peminjaman['status'] == 'menunggu_verifikasi' && $statusBaru == 'selesai'){

            $alat = $this->alatModel->find($peminjaman['alat_id']);

            // tambah stok alat
            $this->alatModel->update($alat['id'],[
                'stok' => $alat['stok'] + 1
            ]);
        }

        $this->peminjamanModel->update($id,[

            'tanggal_dikembalikan' => $tanggalDikembalikan,
            'denda' => $denda,
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
            'Admin memverifikasi pengembalian alat: '.$alat['nama_alat'].' dari '.$user['nama'].' dengan denda Rp'.$denda
        );
        
        return redirect()->to('/admin/pengembalian')
            ->with('success','Pengembalian berhasil diverifikasi');
    }
}