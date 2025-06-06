<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'last_name',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'image');
    }
}
