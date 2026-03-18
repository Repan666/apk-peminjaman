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
        // Tangkap keyword dari form search (method GET)
        $keyword = $this->request->getGet('keyword');

        $query = $this->alatModel
            ->select('alat.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id = alat.kategori_id')
            ->where('alat.status', 1) 
            ->where('kategori.status', 1);

        // Jika ada keyword, lakukan pencarian berdasarkan nama atau kode alat
        if ($keyword) {
            $query->groupStart()
                  ->like('alat.nama_alat', $keyword)
                  ->orLike('alat.kode_alat', $keyword)
                  ->groupEnd();
        }

        $data = [
            'title'   => 'Daftar Alat Praktikum',
            'alat'    => $query->findAll(),
            'keyword' => $keyword // Kirim keyword balik ke view untuk isi input
        ];

        return view('peminjam/alat/index', $data);
    }
}