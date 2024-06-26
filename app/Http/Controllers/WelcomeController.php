<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SalesForecastController;
use App\Charts\AcceptedUser;
use App\Charts\Peramalan;
use App\Charts\Sell;
use App\Models\BarangModel;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //
    public function index(AcceptedUser $chartD ,Sell $chartB , Peramalan $chartP)
    {   
        // $sales = SalesForecastController::forecast();
        // dd($sales);
        $breadcumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home' , 'Welcome']
        ];

        $activeMenu = 'dashboard';

        return view('welcome' , ['breadcumb' => $breadcumb,'activeMenu' => $activeMenu , 'chartP' => $chartP->build(),'chartD' => $chartD->build(),'chartB' => $chartB->build()]);
    }
}
