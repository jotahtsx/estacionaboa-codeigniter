<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User as ShieldUser;

class User extends ShieldUser
{
    protected $attributes = [
        'first_name' => null,
        'last_name'  => null,
        'test_field' => null,
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

    public function setLastName($value)
    {
        $this->attributes['last_name'] = $value;
        return $this;
    }

    public function getLastName()
    {
        return $this->attributes['last_name'];
    }

    public function setTestField($value)
    {
        $this->attributes['test_field'] = $value;
        return $this;
    }

    public function getTestField()
    {
        return $this->attributes['test_field'];
    }
}
