@extends('layouts.app')


@section('subtitle' , 'Kategori')
@section('content_header_title' , 'Kategori')
@section('content_header_subtitle' , 'Create')


@section('content')

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Buat Kategori Baru</h3>
        </div>
        <form action="../kategori/store" method="POST">
            {{ csrf_field() }}
            <div class="card-body">
                <div class="form-group">
                    <label for="kodeKategori">Kode Kategori</label>
                    <input type="text" name="kodeKategori" id="kodeKategori" class="form-control @error('kategori_kode') is-invalid @enderror" placeholder="Kode Kategori">
                </div>
                {{-- @error('kategori_kode')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                @enderror --}}
                <div class="form-group">
                    <label for="namaKategori">Nama Kategori</label>
                    <input type="text" name="namaKategori" id="namaKategori" class="form-control" placeholder="Nama Kategori">
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- @if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif --}}

</div>
@endsection




