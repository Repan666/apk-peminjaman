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

    public function store()
    {
        $this->alatModel->save([
            'kode_alat'   => $this->request->getPost('kode_alat'),
            'nama_alat'   => $this->request->getPost('nama_alat'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'stok'        => $this->request->getPost('stok'),
            'kondisi'     => $this->request->getPost('kondisi'),
            'status'      => 1
        ]);

        return redirect()->to('/admin/alat')
            ->with('success', 'Alat berhasil ditambahkan');
    }

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

    public function update($id)
    {
        $this->alatModel->update($id, [
            'kode_alat'   => $this->request->getPost('kode_alat'),
            'nama_alat'   => $this->request->getPost('nama_alat'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'stok'        => $this->request->getPost('stok'),
            'kondisi'     => $this->request->getPost('kondisi'),
        ]);

        return redirect()->to('/admin/alat')
            ->with('success', 'Alat berhasil diupdate');
    }

    public function nonaktif($id)
    {
        $this->alatModel->update($id, ['status' => 0]);

        return redirect()->to('/admin/alat')
            ->with('success', 'Alat dinonaktifkan');
    }
}