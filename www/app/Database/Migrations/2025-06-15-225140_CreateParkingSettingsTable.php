<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateParkingSettingsTable extends Migration
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
            'legal_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
            'trade_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
            'cnpj' => [
                'type'           => 'VARCHAR',
                'constraint'     => '18',
                'null'           => false,
            ],
            'state_registration' => [
                'type'           => 'VARCHAR',
                'constraint'     => '30',
                'null'           => false,
            ],
            'phone_number' => [
                'type'           => 'VARCHAR',
                'constraint'     => '20',
                'null'           => false,
            ],
            'zip_code' => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
                'null'           => false,
            ],
            'address' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
            'neighborhood' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => false,
            ],
            'number' => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
                'null'           => false,
            ],
            'city' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => false,
            ],
            'state' => [
                'type'           => 'VARCHAR',
                'constraint'     => '2',
                'null'           => false,
            ],
            'site_url' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => true,
            ],
            'instagram' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => true,
            ],
            'email' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
            'ticket_footer_text' => [
                'type'           => 'TEXT',
                'null'           => false,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('parking_settings');
    }

    public function down()
    {
        $this->forge->dropTable('parking_settings');
    }
}
