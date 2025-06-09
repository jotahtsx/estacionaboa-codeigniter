<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        if (! auth()->loggedIn()) {
            return redirect()->to('/login');
        } else {
            return redirect()->to('/dashboard');
        }
    }

    public function dashboard()
    {
        return view('dashboard', ['active_page' => 'home', 'titlePage'  
    => 'Visão geral']);
    }
}