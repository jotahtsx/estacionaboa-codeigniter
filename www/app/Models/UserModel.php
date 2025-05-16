<?php

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    // Define a entidade personalizada que inclui o campo first_name
    protected $returnType = \App\Entities\User::class;

    // Campos permitidos para inserção/atualização
    protected $allowedFields = [
        'username',
        'active',
        'last_login_at',
        'last_login_ip',
        'email_verified_at',
        'test_field', 
        'first_name',
        'last_name',
    ];

    // Desativa timestamps automáticos
    protected $useTimestamps = false;
}
