<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'     => 'Administrator',
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
                'role'     => 'admin',
                'status'   => 1
            ],
            [
                'nama'     => 'Petugas 1',
                'username' => 'petugas',
                'password' => password_hash('petugas123', PASSWORD_BCRYPT),
                'role'     => 'petugas',
                'status'   => 1
            ],
            [
                'nama'     => 'Peminjam 1',
                'username' => 'peminjam',
                'password' => password_hash('peminjam123', PASSWORD_BCRYPT),
                'role'     => 'peminjam',
                'status'   => 1
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}