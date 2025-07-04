<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\PricingCategoryModel;

class PricingSeeder extends Seeder
{
    public function run()
    {
        $categoryModel = new PricingCategoryModel();

        // Busca os IDs das categorias que foram inseridas pelo PricingCategorySeeder
        // É crucial que PricingCategorySeeder seja executado ANTES deste.
        $categoryPequeno = $categoryModel->where('name', 'Veículo Pequeno')->first();
        $categoryMedio   = $categoryModel->where('name', 'Veículo Médio')->first();

        // Verifica se as categorias foram encontradas para evitar erros
        if (!$categoryPequeno || !$categoryMedio) {
            log_message('error', 'Categorias de precificação não encontradas. Execute PricingCategorySeeder primeiro.');
            return; // Sai da função se as categorias não existirem
        }

        $data = [
            [
                'pricing_category_id'  => $categoryPequeno['id'], // Carro mapeado para Veículo Pequeno
                'pricing_by_hour'      => 5.00,
                'pricing_by_mensality' => 200.00,
                'capacity'             => 30,
                'active'               => true,
            ],
            [
                'pricing_category_id'  => $categoryMedio['id'], // Moto mapeado para Veículo Médio
                'pricing_by_hour'      => 2.50,
                'pricing_by_mensality' => 120.00,
                'capacity'             => 15,
                'active'               => true,
            ],
            [
                'pricing_category_id'  => $categoryPequeno['id'], // SUV mapeado para Veículo Pequeno
                'pricing_by_hour'      => 6.50,
                'pricing_by_mensality' => 250.00,
                'capacity'             => 10,
                'active'               => true,
            ],
        ];

        // Insere os dados na tabela 'pricings'
        $this->db->table('pricings')->insertBatch($data);
    }
}