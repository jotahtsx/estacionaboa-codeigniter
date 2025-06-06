<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User as ShieldUser;

class User extends ShieldUser
{
    protected $attributes = [
        'first_name' => null,
        'last_name'  => null,
        'image'      => null,
        'gender' => null,
    ];

    public function setImage($value)
    {
        $this->attributes['image'] = $value;
        return $this;
    }

    public function setGender(string $gender)
    {
        $this->attributes['gender'] = $gender;
    }

    public function getGender(): ?string
    {
        return $this->attributes['gender'];
    }

    public function getImage()
    {
        return $this->attributes['image'];
    }

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
}
