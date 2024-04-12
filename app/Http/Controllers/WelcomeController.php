<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //
    public function index()
    {

        $breadcumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home' , 'Welcome']
        ];

        $activeMenu = 'dashboard';

        return view('welcome' , ['breadcumb' => $breadcumb,'activeMenu' => $activeMenu]);
    }
}
