<?php

namespace App\Http\Controllers;

use App\Charts\AcceptedUser;
use App\Charts\Sell;
use App\Models\BarangModel;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //
    public function index(AcceptedUser $chartD ,Sell $chartB)
    {   

        $breadcumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home' , 'Welcome']
        ];

        $activeMenu = 'dashboard';

        return view('welcome' , ['breadcumb' => $breadcumb,'activeMenu' => $activeMenu , 'chartD' => $chartD->build(),'chartB' => $chartB->build()]);
    }
}
