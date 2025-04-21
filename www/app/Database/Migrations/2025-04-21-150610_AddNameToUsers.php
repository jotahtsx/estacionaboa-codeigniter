<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNameToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'last_name'  => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'first_name');
        $this->forge->dropColumn('users', 'last_name');
    }
}
