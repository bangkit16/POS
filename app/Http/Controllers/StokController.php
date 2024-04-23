<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    //
    public function index()
    {
        $breadcumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'stok']
        ];
        $page = (object) [
            'title' => 'Daftar stok yang terdaftar dalam sistem'
        ];
        $barang = BarangModel::all();

        $activeMenu = 'stok';

        // dd(stokModel::select('stok_id', 'stok_kode', 'stok_nama', 'harga_jual', 'harga_beli', 'kategori_id')->with('barang')->where('kategori_id', 2));
        // dd(stokModel::all()->toArray());
        // dd($barang);

        return view('stok.index', ['breadcumb' => $breadcumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }
    public function list(Request $request)
    {
        // $users = stokModel::all();
        $stoks = StokModel::select('stok_id','barang_id', 'user_id', 'stok_tanggal' , 'stok_jumlah')->with(['barang' , 'user']);
        // dd(stokModel::all()->toJson());
        if ($request->barang_id) {
            $stoks->where('barang_id', $request->barang_id);
        }

        return DataTables::of($stoks)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($stok) { // menambahkan kolom aksi

                $btn = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' .
                    url('/stok/' . $stok->stok_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create()
    {
        $breadcumb = (object) [
            'title' => 'Tambah stok',
            'list' => ['Home', 'stok', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah stok baru'
        ];

        $barang = BarangModel::all();
        $user = UserModel::all();

        $activeMenu = 'stok';

        return view('stok.create', ['breadcumb' => $breadcumb, 'page' => $page, 'barang' => $barang,'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            //username harus diisi, berupa string, minimal 3 karakter dan bernilai unik di table m_user kolom username
            'barang_id' => 'required|integer', 
            'user_id' => 'required|integer', 
            'stok_tanggal' => 'required' , 
            'stok_jumlah' => 'required|integer'
        ]);

        // dd($validated);

        StokModel::create($validated);

        // stokModel::create([
        //     'username' => $request->username,
        //     'nama' => $request->nama,
        //     'password' => bcrypt($request->password),
        //     'level_id' => $request->level_id
        // ]);

        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }

    public function show(string $id)
    {
        $stok = StokModel::with('barang')->find($id);

        $breadcumb = (object)[
            'title' => 'Detail stok',
            'list' => ['Home', 'stok', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail stok'
        ];

        $activeMenu = 'stok'; // set menu yang aktif

        return view('stok.show', [
            'breadcumb' => $breadcumb,
            'page' => $page,
            'stok' => $stok,
            'activeMenu' => $activeMenu
        ]);
    }
    public function edit(string $id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::all();
        $user = UserModel::all();

        $breadcumb = (object)[
            'title' => 'Edit stok',
            'list' => ['Home', 'stok', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit stok'
        ];

        $activeMenu = 'stok';

        return view('stok.edit', [
            'breadcumb' => $breadcumb,
            'page' => $page,
            'stok' => $stok,
            'barang' => $barang,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            // 'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            // 'nama' => 'required|string|max:100',
            // 'password' => 'nullable|min:5',
            // 'level_id' => 'required|integer',
            'barang_id' => 'required|integer', 
            'user_id' => 'required|integer', 
            'stok_tanggal' => 'required' , 
            'stok_jumlah' => 'required|integer'
        ]);

        StokModel::find($id)->update($validated);

        // stokModel::find($id)->update([
        //     'username' => $request->username,
        //     'nama' => $request->nama,
        //     'password' => $request->password ? bcrypt($request->password) : stokModel::find($id)->password,
        //     'level_id' => $request->level_id
        // ]);

        return redirect('/stok')->with('success', 'Data berhasil diubah');
    }
    public function destroy(string $id)
    {
        $check = StokModel::find($id);
        if (!$check) {
            return redirect('/stok')->with('error', 'Data user tidak ditemukan');
        }
        try {
            StokModel::destroy($id);

            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            return redirect('/stok')->with('error', 'Data stok gagal dihapus karena terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
