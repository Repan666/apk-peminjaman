<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePeminjamanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'alat_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'tanggal_pinjam' => [
                'type' => 'DATE',
            ],

            'tanggal_kembali' => [
                'type' => 'DATE',
            ],

            'tanggal_dikembalikan' => [
                'type' => 'DATE',
                'null' => true,
            ],

            'denda' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],

            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['dipinjam', 'dikembalikan'],
                'default'    => 'dipinjam',
            ],

            'created_at DATETIME default current_timestamp',
            'updated_at DATETIME default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addKey('id', true);

        // Foreign Keys
        $this->forge->addForeignKey(
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'alat_id',
            'alat',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('peminjaman', true);
    }

    public function down()
    {
        $this->forge->dropTable('peminjaman', true);
    }
}