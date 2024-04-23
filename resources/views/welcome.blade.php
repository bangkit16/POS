@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Dashboard</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @can('admin')
            
        <div class="row">
            <div class="col-4">
                
                <div class="p-6 m-20 bg-white rounded shadow">
                    {!! $chartD->container() !!}
                </div>
            </div>
            <div class="col-8">
                
                <div class="p-6 m-20 bg-white rounded shadow">
                    {!! $chartB->container() !!}
                </div>
            </div>
        </div>
        @endcan
        
    </div>
</div>
<script src="{{ $chartD->cdn() }}"></script>
<script src="{{ $chartB->cdn() }}"></script>

{{ $chartD->script() }}
{{ $chartB->script() }}
@endsection