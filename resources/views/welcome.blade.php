@extends('layout.app')


@section('subtitle' , 'welcome')
@section('content_header_title' , 'Home')
@section('content_header_subtitle' , 'Welcome')


@section('content_body')

<p>Welcome to this beautiful admimn panel.</p>

@stop

@push('css')

    
@endpush

@push('js')
    <script>console.log("Hi, Im using the laravel-AdminLTE package!");</script>
@endpush
