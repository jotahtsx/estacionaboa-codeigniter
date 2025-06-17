<?php

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = \App\Entities\User::class;

    protected $allowedFields = [
        'id',
        'username',
        'active',
        'last_login_at',
        'last_login_ip',
        'email_verified_at',
        'first_name',
        'last_name',
        'image',
        'gender',
    ];

    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
}
