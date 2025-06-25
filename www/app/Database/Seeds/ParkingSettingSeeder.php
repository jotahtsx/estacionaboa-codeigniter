<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ParkingSettingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'legal_name'         => 'Estacionamento',
            'trade_name'         => 'Estacionamento LTDA',
            'cnpj'               => '12.345.678/0001-99',
            'state_registration' => '1234567890',
            'phone_number'       => '(86) 99999-9999',
            'zip_code'           => '64000-000',
            'address'            => 'Av. Dos Parques',
            'number'             => '1234',
            'city'               => 'Teresina',
            'state'              => 'PI',
            'site_url'           => 'https://www.estacionamento.com',
            'instagram'          => 'estacionamento',
            'email'              => 'contato@estacionaboa.com.br',
            'ticket_footer_text' => 'Obrigado por utilizar nossos serviços!',
        ];

        $builder = $this->db->table('parking_settings');

        $exists = $builder->countAllResults();

        if ($exists === 0) {
            $builder->insert($data);
        }
    }
}
