<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentMethodModel extends Model
{
    protected $table            = 'payment_methods';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = ['name', 'description', 'active'];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name'        => 'required|min_length[3]|max_length[100]|is_unique[payment_methods.name,id,{id}]',
        'description' => 'permit_empty|max_length[255]',
        'active'      => 'required|in_list[0,1]',
    ];
    protected $validationMessages = [
        'name' => [
            'is_unique' => 'O nome da forma de pagamento já existe.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
