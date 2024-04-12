<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Http\Requests\StorePostRequest;
use App\Models\KategoriModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class KategoriController extends Controller
{
    //
    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('kategori.index');
    }

    public function create(): View
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        // $validated = $request->validated();

        // $validated = $request->safe()->only(['kategori_kode', 'kategori_nama' ]);
        // $validated = $request->safe()->except(['kategori_kode', 'kategori_nama' ]);
        // // dd($validated);
        KategoriModel::create([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori
        ]);
        return redirect('/kategori');
    }
    public function ubah($id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.ubah', ['data' => $kategori]);
    }
    public function ubah_simpan($id, Request $request)
    {
        $kategori = KategoriModel::find($id);

        $kategori->kategori_kode = $request->kodeKategori;
        $kategori->kategori_nama = $request->namaKategori;


        $kategori->save();

        return redirect('/kategori');
    }
    public function hapus($id)
    {
        $kategori = KategoriModel::find($id);
        $kategori->delete();
        return redirect('/kategori');
    }
}
