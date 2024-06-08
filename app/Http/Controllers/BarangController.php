<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\StokModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    //
    public function index()
    {
        $breadcumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];
        $page = (object) [
            'title' => 'Daftar Barang yang terdaftar dalam sistem'
        ];
        $kategori = KategoriModel::all();

        $activeMenu = 'barang';

        // dd(BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_jual', 'harga_beli', 'kategori_id')->with('kategori')->where('kategori_id', 2));
        // dd(BarangModel::all()->toArray());
        // dd($kategori);

        return view('barang.index', ['breadcumb' => $breadcumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }
    public function list(Request $request)
    {
        // $users = BarangModel::all();
        $barangs = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_jual', 'harga_beli', 'kategori_id', 'image')->with('kategori');
        // dd(BarangModel::all()->toJson());
        if ($request->kategori_id) {
            $barangs->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($barangs)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($barang) { // menambahkan kolom aksi

                $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' .
                    url('/barang/' . $barang->barang_id) . '">'
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
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah barang baru'
        ];

        $kategori = KategoriModel::all();

        $activeMenu = 'barang';

        return view('barang.create', ['breadcumb' => $breadcumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            //username harus diisi, berupa string, minimal 3 karakter dan bernilai unik di table m_user kolom username
            'barang_kode' => 'required|unique:m_barang|min:3',
            'barang_nama' => 'required|string|max:100',
            'harga_jual' => 'required|integer',
            'harga_beli' => 'required|integer',
            'kategori_id' => 'required|integer',
            'image' => 'image|nullable'
        ]);

        if ($request->file('image')) {
            $validated['image'] = $request->file('image')->store('barangimage');
        }
        // dd($validated);

        $id = BarangModel::create($validated);
        StokModel::create([
            'barang_id' => $id->barang_id,
            'user_id' => auth()->user()->user_id,
            'stok_tanggal' => now(),
            'stok_jumlah' => 100,
        ]);

        // BarangModel::create([
        //     'username' => $request->username,
        //     'nama' => $request->nama,
        //     'password' => bcrypt($request->password),
        //     'level_id' => $request->level_id
        // ]);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    public function show(string $id)
    {
        $barang = BarangModel::with('kategori')->find($id);

        $breadcumb = (object)[
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail barang'
        ];

        $activeMenu = 'barang'; // set menu yang aktif

        return view('barang.show', [
            'breadcumb' => $breadcumb,
            'page' => $page,
            'barang' => $barang,
            'activeMenu' => $activeMenu
        ]);
    }
    public function edit(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();

        $breadcumb = (object)[
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit barang'
        ];

        $activeMenu = 'barang';

        return view('barang.edit', [
            'breadcumb' => $breadcumb,
            'page' => $page,
            'barang' => $barang,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
        // dd($request->image);
        $validated = $request->validate([
            // 'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            // 'nama' => 'required|string|max:100',
            // 'password' => 'nullable|min:5',
            // 'level_id' => 'required|integer',
            'barang_kode' => 'required|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string|max:100',
            'harga_jual' => 'required|integer',
            'harga_beli' => 'required|integer',
            'kategori_id' => 'required|integer',
            'image' => 'nullable',
        ]);

        // $image = null;

        if (!empty($request->image)) {
            if (BarangModel::find($id)->image) {
                Storage::delete(BarangModel::find($id)->image);
            }
            $validated['image'] = $request->file('image')->store('barangimage');
            BarangModel::find($id)->update([
                'image' => $validated['image']
            ]);
        }
        // $validated['image'] = null;

        BarangModel::find($id)->update([
            'barang_kode' => $validated['barang_kode'],
            'barang_nama' => $validated['barang_nama'] ,
            'harga_jual' => $validated['harga_jual'] ,
            'harga_beli' => $validated['harga_beli'] ,
            'kategori_id' => $validated['kategori_id'] ,
        ]);

        // BarangModel::find($id)->update([
        //     'username' => $request->username,
        //     'nama' => $request->nama,
        //     'password' => $request->password ? bcrypt($request->password) : BarangModel::find($id)->password,
        //     'level_id' => $request->level_id
        // ]);

        return redirect('/barang')->with('success', 'Data berhasil diubah');
    }
    public function destroy(string $id)
    {
        $check = BarangModel::find($id);
        if (!$check) {
            return redirect('/barang')->with('error', 'Data user tidak ditemukan');
        }
        try {
            BarangModel::destroy($id);

            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
