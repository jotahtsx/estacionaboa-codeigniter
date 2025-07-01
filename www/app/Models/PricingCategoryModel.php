<?php

namespace App\Models;

use CodeIgniter\Model;

class PricingCategoryModel extends Model
{
    protected $table            = 'pricing_categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'name',
        'active',
    ];

    protected $useTimestamps = true;
}
