<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMonthlyPaymentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'monthly_payer_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => false,
            ],
            'pricing_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => false,
            ],
            'due_day' => [
                'type'       => 'INT',
                'constraint' => 2,
                'null'       => false,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'due_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'payment_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pendente', 'pago', 'atrasado'],
                'default'    => 'pendente',
            ],
            'payment_method' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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
        $this->forge->addForeignKey('monthly_payer_id', 'monthly_payers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pricing_id', 'pricings', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('monthly_payments');
    }

    public function down()
    {
        $this->forge->dropTable('monthly_payments');
    }
}
