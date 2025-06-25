<?php

namespace App\Models;

use CodeIgniter\Model;

class ParkingSettingModel extends Model
{
    protected $table            = 'parking_settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'legal_name',
        'trade_name',
        'cnpj',
        'state_registration',
        'phone_number',
        'zip_code',
        'address',
        'number',
        'city',
        'state',
        'site_url',
        'instagram',
        'email',
        'ticket_footer_text'
    ];
}
