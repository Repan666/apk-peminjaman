<?php

use App\Models\LogAktivitasModel;

if (!function_exists('logAktivitas')) {

    function logAktivitas($aktivitas, $keterangan = null)
    {
        $session = session();

        $logModel = new LogAktivitasModel();

        $data = [
            'user_id'    => $session->get('user_id'),
            'aktivitas'  => $aktivitas,
            'keterangan' => $keterangan,
            'ip_address' => service('request')->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $logModel->insert($data);
    }

}