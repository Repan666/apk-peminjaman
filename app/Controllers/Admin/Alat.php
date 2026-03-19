<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AlatModel;
use App\Models\KategoriModel;

class Alat extends BaseController
{
    protected $alatModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->alatModel = new AlatModel();
        $this->kategoriModel = new KategoriModel();
        helper(['form']);
    }

    // ==============================
    // AUTO GENERATE KODE ALAT
    // ==============================
    private function generateKodeAlat()
    {
        $last = $this->alatModel
            ->select('kode_alat')
            ->orderBy('id', 'DESC')
            ->first();

        if (!$last) {
            return 'ALT-001';
        }

        // Ambil angka dari kode terakhir
        $lastNumber = (int) substr($last['kode_alat'], 4);

        $newNumber = $lastNumber + 1;

        return 'ALT-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    // ==============================
    // LIST DATA
    // ==============================
    public function index()
    {
        $data = [
            'title' => 'Kelola Alat',
            'alat' => $this->alatModel
                ->select('alat.*, kategori.nama_kategori')
                ->join('kategori', 'kategori.id = alat.kategori_id')
                ->findAll()
        ];

        return view('admin/alat/index', $data);
    }

    // ==============================
    // FORM CREATE
    // ==============================
    public function create()
    {
        $data = [
            'title' => 'Tambah Alat',
            'kategori' => $this->kategoriModel
                ->where('status', 1)
                ->findAll()
        ];

        return view('admin/alat/create', $data);
    }

    // ==============================
    // STORE DATA
    // ==============================
    public function store()
    {
        $nama_alat = $this->request->getPost('nama_alat');

        // ✅ AUTO GENERATE KODE
        $kode = $this->generateKodeAlat();

        $this->alatModel->save([
            'kode_alat'   => $kode,
            'nama_alat'   => $nama_alat,
            'kategori_id' => $this->request->getPost('kategori_id'),
            'stok'        => $this->request->getPost('stok'),
            'kondisi'     => $this->request->getPost('kondisi'),
            'status'      => 1
        ]);

        // LOG
        logAktivitas(
            'Tambah Alat',
            'Admin menambahkan alat: ' . $nama_alat . ' (' . $kode . ')'
        );

        return redirect()->to('/admin/alat')
            ->with('success', 'Alat berhasil ditambahkan dengan kode ' . $kode);
    }

    // ==============================
    // FORM EDIT
    // ==============================
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Alat',
            'alat' => $this->alatModel->find($id),
            'kategori' => $this->kategoriModel
                ->where('status', 1)
                ->findAll()
        ];

        return view('admin/alat/edit', $data);
    }

    // ==============================
    // UPDATE DATA
    // ==============================
    public function update($id)
    {
        $nama_alat = $this->request->getPost('nama_alat');

        // ❗ kode_alat TIDAK DIUBAH (biar konsisten)
        $this->alatModel->update($id, [
            'nama_alat'   => $nama_alat,
            'kategori_id' => $this->request->getPost('kategori_id'),
            'stok'        => $this->request->getPost('stok'),
            'kondisi'     => $this->request->getPost('kondisi'),
        ]);

        // LOG
        logAktivitas(
            'Update Alat',
            'Admin mengubah data alat: ' . $nama_alat
        );

        return redirect()->to('/admin/alat')
            ->with('success', 'Alat berhasil diupdate');
    }

    // ==============================
    // NONAKTIFKAN
    // ==============================
    public function nonaktif($id)
    {
        $alat = $this->alatModel->find($id);

        $this->alatModel->update($id, ['status' => 0]);

        // LOG
        logAktivitas(
            'Nonaktifkan Alat',
            'Admin menonaktifkan alat: ' . $alat['nama_alat']
        );

        return redirect()->to('/admin/alat')
            ->with('success', 'Alat dinonaktifkan');
    }
}