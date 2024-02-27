<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function baby()
    {
        return view('Product.baby');
    }
    public function beauty()
    {
        return view('Product.beauty');
    }
    public function food()
    {
        return view('Product.food');
    }
    public function homecare()
    {
        return view('Product.homecare');
    }
}
