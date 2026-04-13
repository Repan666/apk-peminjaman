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
    $keyword = $this->request->getGet('keyword');
    $status  = $this->request->getGet('status'); // filter tambahan

    $query = $this->userModel;

    // FILTER STATUS (optional)
    if ($status !== null && $status !== '') {
        $query = $query->where('status', $status);
    }

    // SEARCH
    if ($keyword) {
        $query = $query
            ->groupStart()
                ->like('nama', $keyword)
                ->orLike('username', $keyword)
            ->groupEnd();
    }

    $data = [
        'title'   => 'Kelola User',
        'users'   => $query->orderBy('id', 'DESC')->findAll(),
        'keyword' => $keyword,
        'status'  => $status
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
    // Definisi Rules 
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
        ],
        'no_hp' => [
            'rules' => 'required|numeric|min_length[10]',
            'errors' => [
                'required' => 'No HP wajib diisi.',
                'numeric' => 'No HP harus berupa angka.',
                'min_length' => 'No HP minimal 10 digit.'
            ]
        ],
        'alamat' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Alamat wajib diisi.'
            ]
        ]
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors()); // Kirim SEMUA error ke view
    }

    // Logika Simpan 
    $this->userModel->save([
    'nama'     => $this->request->getPost('nama'),
    'username' => $this->request->getPost('username'),
    'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
    'role'     => $this->request->getPost('role'),
    'no_hp'    => $this->request->getPost('no_hp'),   // ✅ baru
    'alamat'   => $this->request->getPost('alamat'),  // ✅ baru
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
        ],
        'no_hp' => [
        'rules' => 'required|numeric|min_length[10]',
        'errors' => [
            'required' => 'No HP wajib diisi.',
            'numeric' => 'No HP harus angka.',
            'min_length' => 'Minimal 10 digit.'
        ]
    ],
    'alamat' => [
        'rules' => 'required',
        'errors' => [
            'required' => 'Alamat tidak boleh kosong.'
        ]
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
    'no_hp'    => $this->request->getPost('no_hp'),   // ✅
    'alamat'   => $this->request->getPost('alamat'),  // ✅
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