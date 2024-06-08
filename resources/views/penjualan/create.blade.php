@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('penjualan') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama Pembeli</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="pembeli" name="pembeli"
                            value="{{ old('pembeli') }}" required>
                        @error('pembeli')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Member</label>
                    <div class="col-11">
                        <select class="form-control" id="member" name="member" required>
                            <option value="0" selected>Tidak Member</option>
                            <option value="1">Member</option>
                        </select>
                        {{-- @error('level_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror --}}
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" name="penjualan_kode" id="penjualan_kode" value="">
                    <label class="col-1 control-label col-form-label">Kode Penjualan</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="penjualan_kode_input" name="penjualan_kode_input"
                            value="{{ old('penjualan_kode_input') }}" disabled>
                        @error('penjualan_kode')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                {{-- <div class="form-group row">
          <label class="col-1 control-label col-form-label">Tanggal Penjualan</label>
          <div class="col-11">
            <input type="datetime-local" class="form-control" id="penjualan_tanggal" name="penjualan_tanggal" required>
            @error('penjualan_tanggal')
              <small class="form-text text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div> --}}

                {{-- <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Detail Penjualan</label>
                    <div class="col-11">
                        <div id="items">
                            <div class="form-group row item-row">
                                <div class="col-md-4">
                                    <label for="barang">Barang</label>
                                    <select name="barang[]" class="form-control barang-select" required>
                                        <option value="">- Pilih Barang -</option>
                                        @foreach ($barang as $b)
                                            <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}"
                                                data-nama="{{ $b->barang_nama }}">{{ $b->barang_nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('barang[]')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" name="jumlah[]" class="form-control jumlah" required>
                                    @error('jumlah[]')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label for="harga">Harga</label>
                                    <input type="text" name="harga[]" class="form-control harga" readonly>
                                    @error('harga[]')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger mt-4 remove-item">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-item" class="btn btn-primary">Tambah Barang</button>
                    </div>
                </div> --}}
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Detail Penjualan</label>
                    <div class="col-11">
                        <div id="items">
                            <div class="form-group row item-row">
                                <div class="col-md-4">
                                    <label for="barang">Barang</label>
                                    <select name="barang[]" class="form-control barang-select" required>
                                        <option value="">- Pilih Barang -</option>
                                        @foreach ($barang as $b)
                                            <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}"
                                                data-nama="{{ $b->barang_nama }}">{{ $b->barang_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" name="jumlah[]" class="form-control jumlah" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="harga">Harga</label>
                                    <input type="text" name="harga[]" class="form-control harga" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label for="total">Total</label>
                                    <input type="text" name="total[]" class="form-control total" readonly>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger mt-4 remove-item">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-item" class="btn btn-primary">Tambah Barang</button>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('penjualan') }}">Kembali</a>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        $(document).ready(function() {

            function populateBarangOptions() {
                var selectedItems = [];
                $('.barang-select').each(function() {
                    var selectedValue = $(this).val();
                    if (selectedValue) {
                        selectedItems.push(selectedValue);
                    }
                });

                $('.barang-select').each(function() {
                    var currentValue = $(this).val();
                    $(this).find('option').each(function() {
                        var optionValue = $(this).val();
                        if (optionValue && selectedItems.includes(optionValue) && optionValue !==
                            currentValue) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                });
            }

            $('#member').on('change', function() {
                // Mendapatkan nilai opsi yang dipilih
                var memberValue = $(this).val();
                // Mendapatkan tanggal sekarang
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
                var yy = String(today.getFullYear()); // Ambil 2 digit terakhir tahun

                // Jika opsi "Member" dipilih
                if (memberValue == 1) {
                    // Mengisi input "penjualan_kode" dengan format MPJ + RANDOMNUMBER + TANGGAL SEKARANG (DD-MM-YY)
                    var randomCode = Math.floor(Math.random() * 100);
                    var penjualanKode = "MPJ" + randomCode + dd + mm + yy;
                    $('#penjualan_kode').val(penjualanKode);
                    $('#penjualan_kode_input').val(penjualanKode);
                    
                } else { // Jika opsi "Tidak Member" dipilih
                    // Mengisi input "penjualan_kode" dengan format PJ + RANDOMNUMBER + TANGGAL SEKARANG (DD-MM-YY)
                    var randomCode = Math.floor(Math.random() * 100);
                    var penjualanKode = "PJ" + randomCode + dd + mm + yy;
                    $('#penjualan_kode').val(penjualanKode);
                    $('#penjualan_kode_input').val(penjualanKode);
                }

                // Recalculate totals with discount if necessary
                $('.item-row').each(function() {
                    calculateTotal($(this));
                });
            });
            $('#kategori_id').change(function() {
                var kategoriKode = $(this).find(':selected').data(
                    'kategori-kode'); // Ambil data kategori kode
                var barangKode = generateBarangKode(kategoriKode); // Buat kode barang
                 // Isi input kode barang
                $('input[name="barang_kode"]').val(barangKode);
            });
            // Update harga and calculate total when barang is selected
            $(document).on('change', '.barang-select', function() {
                var harga = $(this).find(':selected').data('harga');
                var itemRow = $(this).closest('.item-row');
                itemRow.find('.harga').val(harga);
                calculateTotal(itemRow);
                populateBarangOptions();
            });

            // Calculate total when jumlah is changed
            $(document).on('input', '.jumlah', function() {
                var itemRow = $(this).closest('.item-row');
                calculateTotal(itemRow);
            });

            // Add new item row
            $('#add-item').click(function() {
                var newItem = $('.item-row:first').clone();
                newItem.find('input').val('');
                newItem.find('.harga').val('');
                newItem.find('.total').val('');
                newItem.find('select').val('');
                $('#items').append(newItem);
                populateBarangOptions();
            });

            // Remove item row
            $(document).on('click', '.remove-item', function() {
                if ($('.item-row').length > 1) {
                    $(this).closest('.item-row').remove();
                    populateBarangOptions();
                } else {
                    alert('Minimal satu barang diperlukan.');
                }
            });

            // Function to calculate total
            function calculateTotal(itemRow) {
                var harga = parseFloat(itemRow.find('.harga').val());
                var jumlah = parseInt(itemRow.find('.jumlah').val());
                var total = harga * jumlah;

                // Check if member is selected and apply 10% discount
                var isMember = $('#member').val() == 1;
                if (isMember) {
                    total = total - (total * 0.1); // Apply 10% discount
                }

                itemRow.find('.total').val(total.toFixed(2));
            }

            // Initial population of barang options
            populateBarangOptions();
            // Function to populate barang select options
            // function populateBarangOptions() {
            //     var selectedItems = [];
            //     $('.barang-select').each(function() {
            //         var selectedValue = $(this).val();
            //         if (selectedValue) {
            //             selectedItems.push(selectedValue);
            //         }
            //     });

            //     $('.barang-select').each(function() {
            //         var currentValue = $(this).val();
            //         $(this).find('option').each(function() {
            //             var optionValue = $(this).val();
            //             if (optionValue && selectedItems.includes(optionValue) && optionValue !==
            //                 currentValue) {
            //                 $(this).hide();
            //             } else {
            //                 $(this).show();
            //             }
            //         });
            //     });
            // }
            // $('#member').on('change', function() {
            //     // Mendapatkan nilai opsi yang dipilih
            //     var memberValue = $(this).val();
            //     // Mendapatkan tanggal sekarang
            //     var today = new Date();
            //     var dd = String(today.getDate()).padStart(2, '0');
            //     var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
            //     var yy = String(today.getFullYear()); // Ambil 2 digit terakhir tahun

            //     // Jika opsi "Member" dipilih
            //     if (memberValue == 1) {
            //         // Mengisi input "penjualan_kode" dengan format MPJ + RANDOMNUMBER + TANGGAL SEKARANG (DD-MM-YY)
            //         var randomCode = Math.floor(Math.random() * 100);
            //     // .toUpperCase(); // Kode acak 4 karakter
            //         var penjualanKode = "MPJ" + randomCode + dd + mm + yy;
            //         $('#penjualan_kode').val(penjualanKode);
            //     } else { // Jika opsi "Tidak Member" dipilih
            //         // Mengisi input "penjualan_kode" dengan format PJ + RANDOMNUMBER + TANGGAL SEKARANG (DD-MM-YY)
            //         var randomCode = Math.floor(Math.random() * 100);
            //     // .toUpperCase(); // Kode acak 4 karakter
            //         var penjualanKode = "PJ" + randomCode + dd + mm + yy;
            //         $('#penjualan_kode').val(penjualanKode);
            //     }
            // });

            // // Update harga and calculate total when barang is selected
            // $(document).on('change', '.barang-select', function() {
            //     var harga = $(this).find(':selected').data('harga');
            //     var itemRow = $(this).closest('.item-row');
            //     itemRow.find('.harga').val(harga);
            //     calculateTotal(itemRow);
            //     populateBarangOptions();
            // });

            // // Calculate total when jumlah is changed
            // $(document).on('input', '.jumlah', function() {
            //     var itemRow = $(this).closest('.item-row');
            //     calculateTotal(itemRow);
            // });

            // // Add new item row
            // $('#add-item').click(function() {
            //     var newItem = $('.item-row:first').clone();
            //     newItem.find('input').val('');
            //     newItem.find('.harga').val('');
            //     newItem.find('.total').val('');
            //     newItem.find('select').val('');
            //     $('#items').append(newItem);
            //     populateBarangOptions();
            // });

            // // Remove item row
            // $(document).on('click', '.remove-item', function() {
            //     if ($('.item-row').length > 1) {
            //         $(this).closest('.item-row').remove();
            //         populateBarangOptions();
            //     } else {
            //         alert('Minimal satu barang diperlukan.');
            //     }
            // });

            // // Function to calculate total
            // function calculateTotal(itemRow) {
            //     var harga = itemRow.find('.harga').val();
            //     var jumlah = itemRow.find('.jumlah').val();
            //     var total = harga * jumlah;
            //     itemRow.find('.total').val(total);
            // }

            // // Initial population of barang options
            // populateBarangOptions();
        });
    </script>
@endpush
