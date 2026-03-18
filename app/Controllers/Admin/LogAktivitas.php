<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LogAktivitasModel;

class LogAktivitas extends BaseController
{

    protected $logModel;

    public function __construct()
    {
        $this->logModel = new LogAktivitasModel();
    }


    // ===============================
    // LIST LOG AKTIVITAS
    // ===============================
    public function index()
    {

        $data['logs'] = $this->logModel
            ->select('log_aktivitas.*, users.nama, users.role')
            ->join('users','users.id = log_aktivitas.user_id')
            ->orderBy('log_aktivitas.created_at','DESC')
            ->findAll();

        return view('admin/log_aktivitas/index', $data);
    }

}