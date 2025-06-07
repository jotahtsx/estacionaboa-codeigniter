<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyInfoModel extends Model
{
    protected $table            = 'company_info';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'corporate_name',
        'trade_name',
        'cnpj',
        'state_registration',
        'phone_main',
        'phone_optional',
        'email_contact',
        'website_url',
        'social_media_url',
        'logo_path',
        'address_zipcode',
        'address_street',
        'address_number',
        'address_complement',
        'address_neighborhood',
        'address_city',
        'address_state',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'corporate_name'     => 'required|max_length[255]',
        'trade_name'         => 'required|max_length[255]',
        'cnpj'               => 'required|exact_length[18]|is_unique[company_info.cnpj,id,{id}]',
        'email_contact'      => 'required|valid_email|max_length[255]',
        'address_zipcode'    => 'required|max_length[10]',
        'address_street'     => 'required|max_length[255]',
        'address_number'     => 'required|max_length[50]',
        'address_neighborhood' => 'required|max_length[255]',
        'address_city'       => 'required|max_length[255]',
        'address_state'      => 'required|exact_length[2]',
        'state_registration' => 'permit_empty|max_length[20]',
        'phone_main'         => 'permit_empty|max_length[20]',
        'phone_optional'     => 'permit_empty|max_length[20]',
        'website_url'        => 'permit_empty|valid_url|max_length[255]',
        'social_media_url'   => 'permit_empty', // TEXT não tem max_length
        'logo_path'          => 'permit_empty|max_length[255]',
        'address_complement' => 'permit_empty|max_length[255]',
    ];
    protected $validationMessages = [
        'corporate_name' => [
            'required'   => 'A Razão Social é obrigatória.',
            'max_length' => 'A Razão Social não pode exceder 255 caracteres.',
        ],
        'trade_name' => [
            'required'   => 'O Nome Fantasia é obrigatório.',
            'max_length' => 'O Nome Fantasia não pode exceder 255 caracteres.',
        ],
        'cnpj' => [
            'required'    => 'O CNPJ é obrigatório.',
            'exact_length' => 'O CNPJ deve ter 18 caracteres (incluindo pontos e barras).',
            'is_unique'   => 'Este CNPJ já está cadastrado.',
        ],
        'email_contact' => [
            'required'    => 'O Email de contato é obrigatório.',
            'valid_email' => 'Informe um Email de contato válido.',
            'max_length'  => 'O Email de contato não pode exceder 255 caracteres.',
        ],
        'address_zipcode' => [
            'required'   => 'O CEP é obrigatório.',
            'max_length' => 'O CEP não pode exceder 10 caracteres.',
        ],
        'address_street' => [
            'required'   => 'O Logradouro é obrigatório.',
            'max_length' => 'O Logradouro não pode exceder 255 caracteres.',
        ],
        'address_number' => [
            'required'   => 'O Número do endereço é obrigatório.',
            'max_length' => 'O Número não pode exceder 50 caracteres.',
        ],
        'address_neighborhood' => [
            'required'   => 'O Bairro é obrigatório.',
            'max_length' => 'O Bairro não pode exceder 255 caracteres.',
        ],
        'address_city' => [
            'required'   => 'A Cidade é obrigatória.',
            'max_length' => 'A Cidade não pode exceder 255 caracteres.',
        ],
        'address_state' => [
            'required'     => 'O Estado é obrigatório.',
            'exact_length' => 'O Estado deve ter 2 caracteres (UF).',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
