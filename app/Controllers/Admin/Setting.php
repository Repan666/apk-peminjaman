<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Setting extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $denda = $this->settingModel->getValue('denda_per_hari');

        return view('admin/settings/index', [
            'denda' => $denda
        ]);
    }

    public function update()
    {
        $denda = $this->request->getPost('denda');

        if ($denda === null || $denda === '' || !is_numeric($denda)) {
            return redirect()->back()->with('error', 'Nominal denda harus berupa angka');
        }

        if ($denda < 0) {
            return redirect()->back()->with('error', 'Nominal denda tidak boleh kurang dari 0');
        }

        $this->settingModel->setValue('denda_per_hari', (int)$denda);

        logAktivitas(
            'Update Setting',
            'Admin mengubah denda menjadi Rp ' . number_format($denda, 0, ',', '.')
        );

        return redirect()->back()
            ->with('success', 'Denda berhasil diubah menjadi Rp ' . number_format($denda, 0, ',', '.'));
    }
}