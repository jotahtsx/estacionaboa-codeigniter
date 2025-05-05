<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User as ShieldUser;

class User extends ShieldUser
{
    // Adiciona o campo que você quer salvar
    protected $attributes = [
        'first_name' => null,
    ];

    public function setFirstName($value)
    {
        $this->attributes['first_name'] = $value;
        return $this;
    }

    public function getFirstName()
    {
        return $this->attributes['first_name'];
    }
}
