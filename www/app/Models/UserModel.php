<?php namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    public function listUsers()
    {
        return $this->findAll();
    }
}
