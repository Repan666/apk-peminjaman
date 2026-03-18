<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        helper(['form']);
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Kategori',
            'kategori' => $this->kategoriModel->findAll()
        ];

        return view('admin/kategori/index', $data);
    }

    public function create()
    {
        return view('admin/kategori/create', [
            'title' => 'Tambah Kategori'
        ]);
    }

    public function store()
    {
        $this->kategoriModel->save([
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'status'        => 1
        ]);

        // LOG AKTIVITAS
        logAktivitas(
            'Tambah Kategori',
            'Admin menambahkan kategori: ' . $this->request->getPost('nama_kategori')
        );


        return redirect()->to('/admin/kategori')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Kategori',
            'kategori' => $this->kategoriModel->find($id)
        ];

        return view('admin/kategori/edit', $data);
    }

    public function update($id)
    {
        $this->kategoriModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
        ]);

        // LOG AKTIVITAS
        logAktivitas(
            'Update Kategori',
            'Admin mengupdate kategori: ' . $this->request->getPost('nama_kategori')
        );

        return redirect()->to('/admin/kategori')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function nonaktif($id)
    {
        $this->kategoriModel->update($id, [
            'status' => 0
        ]);

        // LOG AKTIVITAS
        logAktivitas(
            'Nonaktifkan Kategori',
            'Admin menonaktifkan kategori: ' . $this->kategoriModel->find($id)['nama_kategori']
        );
        
        return redirect()->to('/admin/kategori')
            ->with('success', 'Kategori dinonaktifkan');
    }
}