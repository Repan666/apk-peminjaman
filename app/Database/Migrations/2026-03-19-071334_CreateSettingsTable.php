<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
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
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
            ],
            'value' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'default' => null,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('settings');

        // ✅ insert default value
        $this->db->table('settings')->insert([
            'nama'  => 'denda_per_hari',
            'value' => '5000'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}