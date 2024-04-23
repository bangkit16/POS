<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('register.index');
    }
    public function store(Request $request)
    {
        // return $request->file('image')->store('post-images');

        $validated = $request->validate([
            'nama' => 'required|max:255',
            'username' => 'required|unique:m_user|min:5',
            'password' => 'required|min:3',
            'image' => 'image',
            // 'level_id' => 'required'
        ]);

        if($request->file('image')){
            $validated['image'] = $request->file('image')->store('images');
        }
        $validated['level_id'] = 3;
        $validated['password'] = Hash::make($validated['password']);

        UserModel::create($validated);

        // $request->session()->flash('success', 'Registrasi selesai silahkan login');

        return redirect('/login');
    }
}
