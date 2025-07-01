<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PricingCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Veículo Pequeno', 'active' => true],
            ['name' => 'Veículo Médio', 'active' => true],
        ];

        $this->db->table('pricing_categories')->insertBatch($data);
    }
}
