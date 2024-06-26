<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\User;
use App\Models\m_user;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    //

    public function index()
    {
        $breadcumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];
        $page = (object) [
            'title' => 'Daftar User yang terdaftar dalam sistem'
        ];
        $level = LevelModel::all();

        $activeMenu = 'user';
        return view('user.index', ['breadcumb' => $breadcumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    public function list(Request $request)
    {
        // $users = UserModel::all();
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id', 'status', 'image')->with('level');
        // dd(UserModel::all()->toJson());
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }
        return DataTables::of($users)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi

                $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' .
                    url('/user/' . $user->user_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                if ($user->status == 0) {
                    // $btn .= '<a href="' . url('/user/acc' . $user->user_id) . '" class="ml-1 btn btn-primary btn-sm" onclick="return confirm(\'Apakah Anda yakin Konfirmasi user ini?\');">Accept</a> ';
                    $btn .= '<form class="d-inline-block" method="POST" action="' .
                        url('/user/acc/' . $user->user_id) . '">'
                        . csrf_field() . method_field('PUT') .
                        '<button type="submit" class="ml-1 btn btn-primary btn-sm" onclick="return confirm(\'Apakah Anda yakin konfirmasi user ini?\');">Accept</button></form>';
                } else {
                    $btn .= '<form class="d-inline-block" method="POST" action="' .
                        url('/user/unacc/' . $user->user_id) . '">'
                        . csrf_field() . method_field('PUT') .
                        '<button type="submit" class="ml-1 btn btn-secondary btn-sm" onclick="return confirm(\'Apakah Anda yakin batal konfirmasi user ini?\');">Unaccept</button></form>';
                
                }
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create()
    {
        $breadcumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all();

        $activeMenu = 'user';

        return view('user.create', ['breadcumb' => $breadcumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        // dd($request)
        $validated = $request->validate([
            //username harus diisi, berupa string, minimal 3 karakter dan bernilai unik di table m_user kolom username
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer',
            'image' => 'image'
        ]);
        if ($request->file('image')) {
            $validated['image'] = $request->file('image')->store('images');
        }

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
            'status' => 0,
            'image' => $validated['image']
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcumb = (object)[
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail user'
        ];

        $activeMenu = 'user'; // set menu yang aktif

        return view('user.show', [
            'breadcumb' => $breadcumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcumb = (object)[
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit user'
        ];

        $activeMenu = 'user';

        return view('user.edit', [
            'breadcumb' => $breadcumb,
            'page' => $page,
            'user' => $user,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer',
            'image' => 'nullable|image'
        ]);


        if (!empty($request->image)) {
            if (UserModel::find($id)->image) {
                Storage::delete(UserModel::find($id)->image);
            }
            $validated['image'] = $request->file('image')->store('images');
            UserModel::find($id)->update([
                'image' => $validated['image']
            ]);
        }

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id,
            // 'image' => $validated['image']
        ]);


        return redirect('/user')->with('success', 'Data berhasil diubah');
    }
    public function acc(string $id)
    {

        // dd($id);
        UserModel::find($id)->update([
            'status' => 1,
        ]);
        return redirect('/user')->with('success', 'User berhasil dikonfirmasi');
    }
    public function unacc(string $id)
    {

        // dd($id);
        UserModel::find($id)->update([
            'status' => 0,
        ]);
        return redirect('/user')->with('success', 'User berhasil ditolak');
    }
    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        // dd($check->image);
        // die();
        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }
        try {
            // Storage::delete(UserModel::);
            if (!$check->image == null) Storage::delete($check->image);
            UserModel::destroy($id);

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            return redirect('/user')->with('error', 'Data user gagal dihapus karena terdapat tabel lain yang terkait dengan data ini');
        }
    }


    // public function tambah()
    // {
    //     return view('user_tambah');
    // }
    // public function tambah_simpan(Request $request)
    // {
    //     UserModel::create([
    //         'username' => $request->username,
    //         'nama' => $request->nama,
    //         'password' => Hash::make($request->password),
    //         'level_id' => $request->level_id,
    //     ]);

    //     return redirect('/user');
    // }
    // public function ubah($id)
    // {
    //     $user = UserModel::find($id);
    //     return view('user_ubah', ['data' => $user]);
    // }
    // public function ubah_simpan($id, Request $request)
    // {
    //     $user = UserModel::find($id);

    //     $user->username = $request->username;
    //     $user->nama = $request->nama;
    //     $user->password = Hash::make($request->password);
    //     $user->level_id = $request->level_id;

    //     $user->save();

    //     return redirect('/user');
    // }
    // public function hapus($id)
    // {
    //     $user = UserModel::find($id);
    //     $user->delete();

    //     return redirect('/user');
    // }
}
