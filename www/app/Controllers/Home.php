<?php

namespace App\Controllers;

class Home extends BaseController
{


    public function index(): string
    {

        $data = [
            'tituloPagina' => 'Página Inicial'
        ];

        return view('dashboard', $data);
    }
}
