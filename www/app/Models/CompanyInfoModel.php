<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyInfoModel extends Model
{
    protected $table            = 'company';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    // Campos preenchidos via insert/update
    protected $allowedFields = [
        'corporate_name', 'trade_name', 'cnpj', 'state_registration',
        'phone_main', 'phone_optional', 'email_contact', 'website_url',
        'social_media_url', 'address_zipcode', 'address_street',
        'address_number', 'address_complement', 'address_neighborhood',
        'address_city', 'address_state'
    ];

    // Timestamps automáticos
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Regras de validação
    protected $validationRules = [
        'corporate_name' => 'required|min_length[3]|max_length[255]',
        'cnpj'           => 'required|exact_length[18]|is_unique[company.cnpj,id,{id}]|regex_match[/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/]',
        'email_contact'  => 'permit_empty|valid_email|max_length[100]',
        'website_url'    => 'permit_empty|valid_url|max_length[255]',
        'phone_main'     => 'permit_empty|min_length[10]|max_length[20]',
        'address_zipcode'=> 'permit_empty|exact_length[10]|regex_match[/^\d{5}-\d{3}$/]',
    ];

    protected $validationMessages   = [
        'corporate_name' => [
            'required'   => 'A Razão Social é obrigatória.',
            'min_length' => 'A Razão Social deve ter no mínimo 3 caracteres.',
            'max_length' => 'A Razão Social deve ter no máximo 255 caracteres.',
        ],
        'cnpj' => [
            'required'     => 'O CNPJ é obrigatório.',
            'exact_length' => 'O CNPJ deve ter 14 dígitos (com formato XX.XXX.XXX/YYYY-ZZ).',
            'is_unique'    => 'Este CNPJ já está cadastrado.',
            'regex_match'  => 'O CNPJ deve estar no formato XX.XXX.XXX/YYYY-ZZ.',
        ],
        'email_contact' => [
            'valid_email' => 'O e-mail de contato deve ser um endereço de e-mail válido.',
        ],
        'website_url' => [
            'valid_url' => 'A URL do site deve ser um URL válido.',
        ],
        'phone_main' => [
            'min_length' => 'O telefone principal deve ter no mínimo 10 caracteres.',
            'max_length' => 'O telefone principal deve ter no máximo 20 caracteres.',
        ],
        'address_zipcode' => [
            'exact_length' => 'O CEP deve ter 8 dígitos (com formato XXXXX-XXX).',
            'regex_match'  => 'O CEP deve estar no formato XXXXX-XXX.',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}