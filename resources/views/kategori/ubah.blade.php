@extends('layout.app')


@section('subtitle' , 'Kategori')
@section('content_header_title' , 'Kategori')
@section('content_header_subtitle' , 'Ubah')


@section('content')

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Ubah Kategori</h3>
        </div>
        <form action="/kategori/ubah_simpan/ {{ $data->kategori_id}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="card-body">
                <div class="form-group">
                    <label for="kodeKategori">Kode Kategori</label>
                    <input type="text" name="kodeKategori" id="kodeKategori" class="form-control" value="{{$data->kategori_kode}}">
                </div>
                <div class="form-group">
                    <label for="namaKategori">Nama Kategori</label>
                    <input type="text" name="namaKategori" id="namaKategori" class="form-control" value="{{$data->kategori_nama}}">
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection




