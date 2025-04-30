<?php

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    // Campos permitidos para inserção/atualização
    protected $allowedFields = [
        'username',
        'email',
        'password_hash',
        'active',
        'last_login_at',
        'last_login_ip',
        'email_verified_at',
        'name',
        'surname',
    ];

    // Converte datas automaticamente
    protected $useTimestamps = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
}