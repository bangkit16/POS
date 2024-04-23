<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required|min:3',
        ]);

        if (Auth::attempt($credentials)) {
            // if(auth())
            if(auth()->user()->status == 0){
                // dd("kenek");
                auth()->logout();
                // dd(auth()->check());
                return redirect('/login')->with('nonValid' , 'Akun anda belum tervalidasi. Mohon menunggu admin untuk validasi');

            };

            $request->session()->regenerate();
            
            return redirect()->intended('/');
        }


        return back()->with('loginError', 'Login Gagal');
    }
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
