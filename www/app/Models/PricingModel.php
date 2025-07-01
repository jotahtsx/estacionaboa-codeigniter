<?php

namespace App\Models;

use CodeIgniter\Model;

class PricingModel extends Model
{
    protected $table            = 'pricings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'pricing_category',
        'pricing_by_hour',
        'pricing_by_mensality',
        'capacity',
        'active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
