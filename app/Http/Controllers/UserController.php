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
        // $data = [
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ];
        // UserModel::create($data);
        // $user = UserModel::find(1);
        // $user = UserModel::where('level_id', 1)->first();
        // $user = UserModel::firstWhere('level_id', 2);
        // $user = UserModel::findOr(1,function () {

        // });
        // $user = UserModel::where('level_id','>',3)->firstOr(function () {

        // });
        // $user = UserModel::findOr(1, ['username', 'nama'], function () {
        //     abort(404);
        // });
        // $user = UserModel::findOrFail(1);
        // $user = UserModel::where('username', 'manager9')->firstOrFail();
        $user = UserModel::where('level_id' ,2)->count();
        // dd($user);
        return view('user', ['data' => $user]);
    }
}
