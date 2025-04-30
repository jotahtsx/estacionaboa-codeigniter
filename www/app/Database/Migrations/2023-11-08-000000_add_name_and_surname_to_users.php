<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNameAndSurnameToUsers extends Migration
{
    public function up()
    {
        // Adicionar os campos 'name' e 'surname' na tabela 'users'
        $this->forge->addColumn('users', [
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false, // Não vai permitir valores nulos
            ],
            'surname' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false, // Não vai permitir valores nulos
            ],
        ]);
    }

    public function down()
    {
        // Caso precise reverter a migration, remove os campos
        $this->forge->dropColumn('users', 'name');
        $this->forge->dropColumn('users', 'surname');
    }
}
