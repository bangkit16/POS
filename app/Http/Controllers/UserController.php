<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function user($id, $nama)
    {
        return view('User.user', ['id' => $id, 'nama' => $nama]);
    }

    public function index()
    {
        $data = [
            'username' => 'customer-1',
            'nama' => 'Pelanggan',
            'password' => Hash::make('12345'),
            'level_id' => 3,
        ];
        UserModel::insert($data);
        $user = UserModel::all();
        return view('user', ['data' => $user]);
    }
}
