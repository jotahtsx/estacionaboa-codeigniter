<?php

namespace App\Models;

use CodeIgniter\Model;

class MonthlyPayerModel extends Model
{
    protected $table            = 'monthly_payers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'first_name',
        'last_name',
        'birth_date',
        'cpf',
        'rg',
        'email',
        'phone',
        'zip_code',
        'street',
        'number',
        'neighborhood',
        'city',
        'state',
        'complement',
        'vehicle_plate',
        'vehicle_type',
        'active',
        'due_day',
        'notes',
    ];
}