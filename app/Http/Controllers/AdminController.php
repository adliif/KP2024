<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $data =[
            'title' => 'Dahboard',
        ];
        return view('roleAdmin.dashboard', $data);
    }
}