<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePricingCategoriesTable extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'active' => [
                'type'       => 'BOOLEAN',
                'default'    => true,
                'null'       => false,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('pricing_categories');
    }

    public function down()
    {
        $this->forge->dropTable('pricing_categories');
    }
}
