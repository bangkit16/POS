@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('user/create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <label class="col-1 control-label col-form-label">Filter:</label>
                <div class="col-3">
                    <select class="form-control" id="level_id" name="level_id" required>
                        <option value="">- Semua -</option>
                        @foreach ($level as $item)
                            <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Level Pengguna</small>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Level Pengguna</th>
                        <th>Status</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            var dataUser = $('#table_user').DataTable({
                pageLength: 25,
                processing: true,

                serverSide: true, // serverSide: true, jika ingin menggunakan server side processing

                dom: '<"html5buttons">Blfrtip',
                language: {
                    buttons: {
                        colvis: 'show / hide', // label button show / hide colvisRestore: "Reset Kolom" //lael untuk reset kolom ke default
                    }

                },
                buttons: [{
                        extend: 'colvis',
                        postfixButtons: ['colvisRestore']
                    },
                    {
                        extend: 'csv',
                        title: 'Tabel User',
                        // exportOptions : columns: [0,1,2,3,4]
                        exportOptions : { columns: [0,1,2,3,4]}
                    },
                    {
                        extend: 'pdf',
                        title: 'Tabel User',
                        // exportOptions : columns: [0,1,2,3,4]
                        exportOptions : { columns: [0,1,2,3,4]}
                    },
                    {
                        extend: 'excel',
                        title: 'Tabel User',
                        // exportOptions : columns: [0,1,2,3]
                        exportOptions : { columns: [0,1,2,3,4]}
                    },
                    {
                        extend: 'print',
                        title: 'Tabel User',
                        exportOptions : { columns: [0,1,2,3,4]}
                    },
                ],
                // buttons: 

                ajax: {
                    "url": "{{ url('user/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.level_id = $('#level_id').val();
                    }
                },
                columns: [{
                    data: "DT_RowIndex", // nomor urut dari laravel datatable addIndexColumn()
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "username",
                    className: "",
                    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                }, {
                    data: "nama",
                    className: "",
                    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                }, {
                    data: "level.level_nama",
                    className: "",
                    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                }, {
                    data: "status",
                    className: "",
                    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: true, // searchable: true, jika ingin kolom ini bisa dicari
                    render: function(data) {
                        if (data == 1) {
                            return '<span class="badge bg-success">Accepted</span>';
                        } else {
                            return '<span class="badge bg-secondary">Unaccepted</span>';
                        }
                    }
                }, {
                    data: "image",
                    className: "",
                    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: true, // searchable: true, jika ingin kolom ini bisa dicari
                    render: function(data) {
                        var url = '/storage/' + data;
                        return '<img src="' + url + '" class="img-thumbnail" >';
                    }
                }, {
                    data: "aksi",
                    className: "",
                    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: false, // searchable: true, jika ingin kolom ini bisa dicari
                    exportable: false
                }]
            });
            $('#level_id').on('change', function() {
                dataUser.ajax.reload();
            })
        });
    </script>
@endpush
