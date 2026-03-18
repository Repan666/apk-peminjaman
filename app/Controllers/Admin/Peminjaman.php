<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\AlatModel;
use App\Models\UserModel;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;
    protected $alatModel;
    protected $userModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->alatModel = new AlatModel();
        $this->userModel = new UserModel();
    }

    // =========================
    // LIST DATA
    // =========================
    public function index()
    {
        $data['title'] = 'Kelola Peminjaman';

        $data['peminjaman'] = $this->peminjamanModel
            ->select('peminjaman.*, users.nama, alat.nama_alat')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->orderBy('peminjaman.id','DESC')
            ->findAll();

        return view('admin/peminjaman/index',$data);
    }

    // =========================
    // DETAIL
    // =========================
    public function detail($id)
    {
        $data['peminjaman'] = $this->peminjamanModel
            ->select('peminjaman.*, users.nama, alat.nama_alat')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->where('peminjaman.id',$id)
            ->first();

        return view('admin/peminjaman/detail',$data);
    }

    // =========================
    // FORM CREATE
    // =========================
    public function create()
    {
        $data['users'] = $this->userModel
            ->where('role','peminjam')
            ->findAll();

        $data['alat'] = $this->alatModel
            ->where('status',1)
            ->findAll();

        return view('admin/peminjaman/create',$data);
    }

    // =========================
    // STORE
    // =========================
    public function store()
    {
        $alatId = $this->request->getPost('alat_id');
        $status = $this->request->getPost('status');

        $alat = $this->alatModel->find($alatId);

        if($status == 'dipinjam'){
            if($alat['stok'] <= 0){
                return redirect()->back()->with('error','Stok alat habis');
            }

            // kurangi stok
            $this->alatModel->update($alatId,[
                'stok' => $alat['stok'] - 1
            ]);
        }

        $this->peminjamanModel->insert([
            'user_id' => $this->request->getPost('user_id'),
            'alat_id' => $alatId,
            'tanggal_pinjam' => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status' => $status,
            'keterangan' => $this->request->getPost('keterangan')
        ]);

        // LOG AKTIVITAS
        $user = $this->userModel->find($this->request->getPost('user_id'));

        logAktivitas(
            'Tambah Peminjaman',
            'Admin membuat peminjaman alat: '.$alat['nama_alat'].' untuk '.$user['nama']
        );
      

        return redirect()->to('/admin/peminjaman')
            ->with('success','Peminjaman berhasil dibuat');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $data['peminjaman'] = $this->peminjamanModel
            ->select('peminjaman.*, users.nama, alat.nama_alat')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->where('peminjaman.id',$id)
            ->first();

        return view('admin/peminjaman/edit',$data);
    }

    // =========================
    // UPDATE DATA
    // =========================
    public function update($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $peminjaman = $this->peminjamanModel->find($id);

        $statusBaru = $this->request->getPost('status');
        $statusLama = $peminjaman['status'];

        $alat = $this->alatModel->find($peminjaman['alat_id']);

        // ======================
        // PENDING -> DIPINJAM
        // ======================
        if($statusLama == 'pending' && $statusBaru == 'dipinjam'){

            if($alat['stok'] <= 0){
                return redirect()->back()->with('error','Stok alat habis');
            }

            $this->alatModel->update($alat['id'],[
                'stok' => $alat['stok'] - 1
            ]);
        }

        // ======================
        // DIPINJAM -> DIBATALKAN
        // ======================
        if($statusLama == 'dipinjam' && $statusBaru == 'dibatalkan'){

            $this->alatModel->update($alat['id'],[
                'stok' => $alat['stok'] + 1
            ]);
        }

        // ======================
        // SELESAI TIDAK BOLEH DIUBAH
        // ======================
        if($statusLama == 'selesai'){
            return redirect()->back()->with('error','Transaksi sudah selesai');
        }

        $this->peminjamanModel->update($id,[

            'tanggal_pinjam' => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status' => $statusBaru,
            'keterangan' => $this->request->getPost('keterangan')

        ]);

        $db->transComplete();

        logAktivitas(
            'Update Peminjaman',
            'Admin mengubah status peminjaman alat: '.$alat['nama_alat'].' dari '.$statusLama.' menjadi '.$statusBaru
        );
        
        return redirect()->to('/admin/peminjaman')
            ->with('success','Data peminjaman berhasil diperbarui');
    }

    // =========================
    // APPROVE
    // =========================
    public function approve($id)
    {
        $peminjaman = $this->peminjamanModel->find($id);

        if($peminjaman['status'] != 'pending'){
            return redirect()->back()->with('error','Status tidak valid');
        }

        $alat = $this->alatModel->find($peminjaman['alat_id']);

        if($alat['stok'] <= 0){
            return redirect()->back()->with('error','Stok habis');
        }

        // kurangi stok
        $this->alatModel->update($alat['id'],[
            'stok' => $alat['stok'] - 1
        ]);

        $this->peminjamanModel->update($id,[
            'status' => 'dipinjam'
        ]);

        $user = $this->userModel->find($peminjaman['user_id']);

        logAktivitas(
            'Setujui Peminjaman',
            'Admin menyetujui peminjaman alat: '.$alat['nama_alat'].' untuk '.$user['nama']
        );

        return redirect()->back()->with('success','Peminjaman disetujui');
    }

    // =========================
    // REJECT
    // =========================
    public function reject($id)
    {
        $peminjaman = $this->peminjamanModel->find($id);

        if($peminjaman['status'] != 'pending'){
            return redirect()->back()->with('error','Status tidak valid');
        }

        $this->peminjamanModel->update($id,[
            'status' => 'ditolak'
        ]);

        $user = $this->userModel->find($peminjaman['user_id']);
        $alat = $this->alatModel->find($peminjaman['alat_id']);

        logAktivitas(
            'Tolak Peminjaman',
            'Admin menolak peminjaman alat: '.$alat['nama_alat'].' untuk '.$user['nama']
        );

        return redirect()->back()->with('success','Peminjaman ditolak');
    }

    // =========================
    // CANCEL
    // =========================
    public function cancel($id)
    {
        $peminjaman = $this->peminjamanModel->find($id);

        if($peminjaman['status'] != 'dipinjam'){
            return redirect()->back()->with('error','Status tidak valid');
        }

        $alat = $this->alatModel->find($peminjaman['alat_id']);

        // tambah stok kembali
        $this->alatModel->update($alat['id'],[
            'stok' => $alat['stok'] + 1
        ]);

        $this->peminjamanModel->update($id,[
            'status' => 'dibatalkan'
        ]);

        $user = $this->userModel->find($peminjaman['user_id']);

        logAktivitas(
            'Batalkan Peminjaman',
            'Admin membatalkan peminjaman alat: '.$alat['nama_alat'].' milik '.$user['nama']
        );

        return redirect()->back()->with('success','Peminjaman dibatalkan');
    }

}