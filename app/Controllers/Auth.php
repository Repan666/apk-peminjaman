<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form']);
    }

    public function login()
    {
        return view('auth/login');
    }

    public function process()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel
                     ->where('username', $username)
                     ->where('status', 1)
                     ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        session()->set([
            'user_id'   => $user['id'],
            'nama'      => $user['nama'],
            'role'      => $user['role'],
            'logged_in' => true
        ]);

        switch ($user['role']) {
            case 'admin':
                return redirect()->to('/admin/dashboard');
            case 'petugas':
                return redirect()->to('/petugas/dashboard');
            case 'peminjam':
                return redirect()->to('/peminjam/dashboard');
            default:
                return redirect()->to('/');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}