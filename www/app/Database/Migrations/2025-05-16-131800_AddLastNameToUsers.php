<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLastNameToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'last_name');
    }
}