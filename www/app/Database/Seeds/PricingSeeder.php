<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\PricingCategoryModel;

class PricingSeeder extends Seeder
{
    public function run()
    {
        $categoryModel = new PricingCategoryModel();

        $categories = [
            'Carro' => $categoryModel->where('name', 'Veículo Pequeno')->first(),
            'Moto'  => $categoryModel->where('name', 'Veículo Médio')->first(),
            'SUV'   => $categoryModel->where('name', 'Veículo Pequeno')->first(), // ou crie uma nova categoria se necessário
        ];

        $data = [
            [
                'pricing_category_id'   => $categories['Carro']['id'],
                'pricing_by_hour'       => 5,
                'pricing_by_mensality'  => 200,
                'capacity'              => 30,
                'active'                => true,
            ],
            [
                'pricing_category_id'   => $categories['Moto']['id'],
                'pricing_by_hour'       => 2.5,
                'pricing_by_mensality'  => 120,
                'capacity'              => 15,
                'active'                => true,
            ],
            [
                'pricing_category_id'   => $categories['SUV']['id'],
                'pricing_by_hour'       => 6.5,
                'pricing_by_mensality'  => 250,
                'capacity'              => 10,
                'active'                => true,
            ],
        ];

        $this->db->table('pricings')->insertBatch($data);
    }
}
