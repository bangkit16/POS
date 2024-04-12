@extends('layouts.app')


@section('subtitle' , 'Kategori')
@section('content_header_title' , 'Home')
@section('content_header_subtitle' , 'Kategori')


@section('content')

<div class="container-fluid">
    <a href="/kategori/create" class="mb-3 btn btn-primary">Add Kategori</a>
    
    <div class="card">
        <div class="card-header">Manage Kategori</div>
        <div class="card-body">
            {{$dataTable->table()}}
        </div>
    </div>
</div>
@endsection



@push('css')

    
@endpush

@push('scripts')
    {{$dataTable->scripts()}}
@endpush

