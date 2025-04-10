<?php

namespace App\Controllers;

class Home extends BaseController
{


    public function index(): string
    {

        $data = [
            'titlePage' => 'Página Inicial'
        ];

        return view('dashboard', $data);
    }
}
