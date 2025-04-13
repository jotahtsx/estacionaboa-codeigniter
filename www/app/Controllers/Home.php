<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data['active_page'] = 'home';
        $data['titlePage'] = 'Visão Geral';
        return view('dashboard', $data);
    }
}