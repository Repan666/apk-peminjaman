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
    // Definisi Rules & Custom Error Messages agar UI/UX lebih informatif
    $rules = [
        'nama' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama lengkap harus diisi.'
            ]
        ],
        'username' => [
            'rules'  => 'required|is_unique[users.username]|min_length[4]',
            'errors' => [
                'required'   => 'Username tidak boleh kosong.',
                'is_unique'  => 'Username "@' . $this->request->getPost('username') . '" sudah terdaftar.',
                'min_length' => 'Username minimal 4 karakter.'
            ]
        ],
        'password' => [
            'rules'  => 'required|min_length[6]',
            'errors' => [
                'required'   => 'Password tidak boleh kosong.',
                'min_length' => 'Password terlalu pendek, minimal 6 karakter.'
            ]
        ],
        'role' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Pilih salah satu hak akses (role).'
            ]
        ]
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors()); // Kirim SEMUA error ke view
    }

    // Logika Simpan (Tetap Sama)
    $this->userModel->save([
        'nama'     => $this->request->getPost('nama'),
        'username' => $this->request->getPost('username'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        'role'     => $this->request->getPost('role'),
        'status'   => 1
    ]);

    logAktivitas(
        'Tambah User',
        'Admin menambahkan user: ' . $this->request->getPost('username')
    );

    return redirect()->to('/admin/users')
        ->with('success', 'User @' . $this->request->getPost('username') . ' berhasil ditambahkan');
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
    // Validasi dasar
    $rules = [
        'nama' => [
            'rules'  => 'required',
            'errors' => ['required' => 'Nama lengkap tidak boleh kosong.']
        ],
        'username' => [
            'rules'  => "required|is_unique[users.username,id,$id]|min_length[4]",
            'errors' => [
                'required'   => 'Username wajib diisi.',
                'is_unique'  => 'Username sudah digunakan user lain.',
                'min_length' => 'Username minimal 4 karakter.'
            ]
        ],
        'role' => [
            'rules'  => 'required',
            'errors' => ['required' => 'Pilih hak akses user.']
        ]
    ];

    // Jika input password diisi, tambahkan rule validasi password
    if ($this->request->getPost('password')) {
        $rules['password'] = [
            'rules'  => 'min_length[6]',
            'errors' => ['min_length' => 'Password baru minimal harus 6 karakter.']
        ];
    }

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $data = [
        'nama'     => $this->request->getPost('nama'),
        'username' => $this->request->getPost('username'),
        'role'     => $this->request->getPost('role'),
    ];

    // Masukkan password ke array update hanya jika diisi
    if ($this->request->getPost('password')) {
        $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
    }

    $this->userModel->update($id, $data);

    logAktivitas(
        'Update User',
        'Admin mengupdate data user: ' . $this->request->getPost('username')
    );

    return redirect()->to('/admin/users')
        ->with('success', 'Data user berhasil diperbarui');
}

    public function nonaktif($id)
{
    $user = $this->userModel->find($id);

    if ($user['role'] == 'admin') {
        return redirect()->to('/admin/users')
            ->with('error', 'Admin tidak dapat dinonaktifkan.');
    }

    $this->userModel->update($id, ['status' => 0]);
    // LOG AKTIVITAS
    logAktivitas(
        'Nonaktifkan User',
        'Admin menonaktifkan user: ' . $user['username']
    );

    return redirect()->to('/admin/users')
        ->with('success', 'User dinonaktifkan');
}
}