<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAlatTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kode_alat' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'nama_alat' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'kategori_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'stok' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'kondisi' => [
                'type' => 'ENUM',
                'constraint' => ['baik','rusak ringan','rusak berat'],
                'default' => 'baik',
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at DATETIME default current_timestamp',
            'updated_at DATETIME default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('kode_alat');

        // FOREIGN KEY
        $this->forge->addForeignKey(
            'kategori_id',
            'kategori',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->forge->createTable('alat');
    }

    public function down()
    {
        $this->forge->dropTable('alat');
    }
}