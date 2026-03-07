<?php

namespace App\Controllers\Peminjam;

use App\Controllers\BaseController;
use App\Models\AlatModel;

class Alat extends BaseController
{
    protected $alatModel;

    public function __construct()
    {
        $this->alatModel = new AlatModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Alat Praktikum',
            // Menampilkan semua alat yang statusnya aktif (1)
            'alat' => $this->alatModel
                ->select('alat.*, kategori.nama_kategori')
                ->join('kategori', 'kategori.id = alat.kategori_id')
                ->where('alat.status', 1) 
                ->where('kategori.status', 1)
                ->findAll()
        ];

        return view('peminjam/alat/index', $data);
    }
}