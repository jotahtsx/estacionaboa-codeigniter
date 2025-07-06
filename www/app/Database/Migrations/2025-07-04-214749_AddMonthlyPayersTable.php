<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMonthlyPayersTable extends Migration
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
            'first_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'last_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => false,
            ],
            'birth_date' => [
                'type'           => 'DATE',
                'null'           => false,
            ],
            'cpf' => [
                'type'           => 'VARCHAR',
                'constraint'     => 11, // Sem máscara
                'unique'         => true,
                'null'           => false,
            ],
            'rg' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'unique'         => true,
                'null'           => false,
            ],
            'email' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'unique'         => true,
                'null'           => false,
            ],
            'phone' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'null'           => false,
            ],
            'zip_code' => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
                'null'           => false,
            ],
            'street' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => false,
            ],
            'number' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'null'           => false,
            ],
            'neighborhood' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => false,
            ],
            'city' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => false,
            ],
            'state' => [
                'type'           => 'VARCHAR',
                'constraint'     => 2, // Ex: SP
                'null'           => false,
            ],
            'complement' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => true,
            ],
            'vehicle_plate' => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
                'unique'         => true,
                'null'           => false,
            ],
            'vehicle_type' => [
                'type'           => 'ENUM("carro", "moto", "outro")',
                'default'        => 'carro',
                'null'           => false,
            ],
            'active' => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'default'        => 1,
            ],
            'due_day' => [
                'type'           => 'TINYINT',
                'constraint'     => 2,
                'null'           => false,
            ],
            'notes' => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('monthly_payers');
    }

    public function down()
    {
        $this->forge->dropTable('monthly_payers');
    }
}
