<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddContactToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [

            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'nama'
            ],

            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'no_hp'
            ]

        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['no_hp', 'alamat']);
    }
}