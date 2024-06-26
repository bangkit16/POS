<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\DetailPenjualanModel;
use App\Models\PenjualanModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    //
    public function index()
    {
        $breadcumb = (object) [
            'title' => 'Daftar penjualan',
            'list' => ['Home', 'penjualan']
        ];
        $page = (object) [
            'title' => 'Daftar penjualan yang terdaftar dalam sistem'
        ];
        $user = UserModel::all();

        $activeMenu = 'penjualan';

        // dd(penjualanModel::select('penjualan_id', 'penjualan_kode', 'penjualan_nama', 'harga_jual', 'harga_beli', 'kategori_id')->with('user')->where('kategori_id', 2));
        // dd(penjualanModel::all()->toArray());
        // dd($user);

        $penjualans = PenjualanModel::select('penjualan_id', 'user_id', 'penjualan_kode', 'pembeli', 'penjualan_tanggal')->with(['user', 'detail']);
        // dd($penjualans->get());
        return view('penjualan.index', ['breadcumb' => $breadcumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }
    public function create()
    {
        $breadcumb = (object) [
            'title' => 'Tambah penjualan',
            'list' => ['Home', 'penjualan', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah penjualan baru'
        ];

        $barang = BarangModel::all();
        $user = UserModel::all();

        $activeMenu = 'penjualan';

        return view('penjualan.create', ['breadcumb' => $breadcumb, 'page' => $page, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        // dd($request->penjualan_kode);
        // dd($request->member);
        $validated = $request->validate([
            //username harus diisi, berupa string, minimal 3 karakter dan bernilai unik di table m_user kolom username
            'pembeli' => 'required|string',
            'member' => 'required|integer',
            'penjualan_kode' => 'required',
            // 'barang' => 'required|integer',
            // 'jumlah' => 'required|integer',
            // 'total' => 'required|integer',
        ]);
        // dd($validated['member']);
        $validated['user_id'] = auth()->user()->user_id;
        $validated['penjualan_tanggal'] = now();
        $validated['harga'] = $request['total'];
        // $validated['member'] = $request['member'];

        
        $id = PenjualanModel::create($validated);
        // dd($id->get());

        for ($i = 0; $i < count($request->barang); $i++) {
            # code...
            // dump('j');
            DetailPenjualanModel::create([
                'penjualan_id' => $id->penjualan_id,
                'barang_id' => $request->barang[$i],
                'harga' => $request->total[$i],
                'jumlah' => $request->jumlah[$i],
            ]);
            $barang = StokModel::where('barang_id',$request->barang[$i])->first();
            $barang->update([
                'stok_jumlah' => $barang->stok_jumlah - $request->jumlah[$i],
            ]);
        }
        // dd("hop");



        // stokModel::create([
        //     'username' => $request->username,
        //     'nama' => $request->nama,
        //     'password' => bcrypt($request->password),
        //     'level_id' => $request->level_id
        // ]);

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil disimpan');
    }
    public function list(Request $request)
    {
        // $users = penjualanModel::all();
        $penjualans = PenjualanModel::select('penjualan_id', 'user_id', 'penjualan_kode', 'pembeli', 'member', 'penjualan_tanggal')->with(['user', 'detail']);
        // dd(penjualanModel::all()->toJson());
        if ($request->user_id) {
            $penjualans->where('user_id', $request->user_id);
        }

        return DataTables::of($penjualans)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi

                $btn = '<a href="' . url('/penjualan/' . $penjualan->penjualan_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' .
                //     url('/penjualan/' . $penjualan->penjualan_id) . '">'
                //     . csrf_field() . method_field('DELETE') .p
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->addColumn('harga', function ($penjualan) { // menambahkan kolom aksi

                $harga = $penjualan->detail->sum('harga');
                return $harga;
            })
            ->addColumn('harga_bayar', function ($penjualan) { // menambahkan kolom aksi
                if ($penjualan->member == 1)
                    $harga = ($penjualan->detail->sum('harga') * 90) / 100;
                else $harga = $penjualan->detail->sum('harga');
                return $harga;
            })
            ->rawColumns(['aksi', 'harga', 'harga_bayar']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    public function show(string $id)
    {
        $penjualan = PenjualanModel::with('user')->find($id);

        $penjualanDetail = DetailPenjualanModel::with('barang')->where('penjualan_id', $id)->get();

        // foreach ($penjualanDetail as $detail) {
        //     echo 'Nama Barang: ' . $detail->barang->barang_nama . ', Harga: ' . $detail->harga . '<br>';
        // }

        // dd($penjualanDetail::harga);


        // dd($penjualanDetail->get());

        // $detail = $penjualanDetail[]

        // dd($penjualanDetail[0]->penjualan_id);
        // foreach($penjualanDetail as $d){
        //     var_dump("kenek");
        // }
        // die();
        // dd($penjualanDetail->count());


        $breadcumb = (object)[
            'title' => 'Detail penjualan',
            'list' => ['Home', 'penjualan', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail penjualan'
        ];

        $activeMenu = 'penjualan'; // set menu yang aktif

        return view('penjualan.show', [
            'breadcumb' => $breadcumb,
            'page' => $page,
            'penjualan' => $penjualan,
            'detail' => $penjualanDetail,
            'activeMenu' => $activeMenu
        ]);
    }
    // public function edit(string $id)
    // {
    //     $penjualan = PenjualanModel::find($id);
    //     $kategori = KategoriModel::all();

    //     $breadcumb = (object)[
    //         'title' => 'Edit penjualan',
    //         'list' => ['Home', 'penjualan', 'Edit']
    //     ];

    //     $page = (object)[
    //         'title' => 'Edit penjualan'
    //     ];

    //     $activeMenu = 'penjualan';

    //     return view('penjualan.edit', [
    //         'breadcumb' => $breadcumb,
    //         'page' => $page,
    //         'penjualan' => $penjualan,
    //         'kategori' => $kategori,
    //         'activeMenu' => $activeMenu
    //     ]);
    // }

    // public function update(Request $request, string $id)
    // {
    //     $validated = $request->validate([
    //         // 'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
    //         // 'nama' => 'required|string|max:100',
    //         // 'password' => 'nullable|min:5',
    //         // 'level_id' => 'required|integer',
    //         'penjualan_kode' => 'required|unique:m_penjualan,penjualan_kode,' . $id . ',penjualan_id',
    //         'penjualan_nama' => 'required|string|max:100',
    //         'harga_jual' => 'required|integer',
    //         'harga_beli' => 'required|integer',
    //         'kategori_id' => 'required|integer'
    //     ]);

    //     PenjualanModel::find($id)->update($validated);

    //     // PenjualanModel::find($id)->update([
    //     //     'username' => $request->username,
    //     //     'nama' => $request->nama,
    //     //     'password' => $request->password ? bcrypt($request->password) : PenjualanModel::find($id)->password,
    //     //     'level_id' => $request->level_id
    //     // ]);

    //     return redirect('/penjualan')->with('success', 'Data berhasil diubah');
    // }
    // public function destroy(string $id)
    // {
    //     $check = PenjualanModel::find($id);
    //     if (!$check) {
    //         return redirect('/penjualan')->with('error', 'Data user tidak ditemukan');
    //     }
    //     try {
    //         PenjualanModel::destroy($id);

    //         return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
    //     } catch (\Illuminate\Database\QueryException $e) {

    //         return redirect('/penjualan')->with('error', 'Data penjualan gagal dihapus karena terdapat tabel lain yang terkait dengan data ini');
    //     }
    // }
}
