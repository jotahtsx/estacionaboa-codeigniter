<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGenderToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'gender' => [
                'type'       => 'ENUM',
                'constraint' => ['male', 'female', 'other'],
                'null'       => true,
                'after'      => 'last_name',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'gender');
    }
}
