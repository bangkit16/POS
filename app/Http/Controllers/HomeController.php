<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function home(){
        return view('Pages.home');
    }
    public function penjualan(){
        return view('Pages.penjualan');
    }
}
