<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form']);
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola User',
            'users' => $this->userModel->findAll()
        ];

        return view('admin/users/index', $data);
    }

    public function create()
    {
        return view('admin/users/create', [
            'title' => 'Tambah User'
        ]);
    }

    public function store()
    {
        $this->userModel->save([
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'     => $this->request->getPost('role'),
            'status'   => 1
        ]);

        return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
{
    $user = $this->userModel->find($id);

    // Cegah admin edit admin lain
    if ($user['role'] == 'admin' && $user['id'] != session()->get('user_id')) {
        return redirect()->to('/admin/users')
            ->with('error', 'Tidak boleh mengedit sesama admin.');
    }

    $data = [
        'title' => 'Edit User',
        'user'  => $user
    ];

    return view('admin/users/edit', $data);
}

    public function update($id)
    {
        $data = [
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/admin/users')->with('success', 'User berhasil diupdate');
    }

    public function nonaktif($id)
{
    $user = $this->userModel->find($id);

    if ($user['role'] == 'admin') {
        return redirect()->to('/admin/users')
            ->with('error', 'Admin tidak dapat dinonaktifkan.');
    }

    $this->userModel->update($id, ['status' => 0]);

    return redirect()->to('/admin/users')
        ->with('success', 'User dinonaktifkan');
}
}