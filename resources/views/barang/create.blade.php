@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('barang') }}" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <input type="hidden" name="barang_kode" value="">
                    <label class="col-1 control-label col-form-label">Barang Kode</label>
                    <div class="col-11">
                        <input type="text" class="form-control disabled" id="barang_kode_input" name="barang_kode"
                            value="{{ old('barang_kode') }} " disabled>
                        @error('barang_kode')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Barang Nama</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="barang_nama" name="barang_nama"
                            value="{{ old('barang_nama') }}" required>
                        @error('barang_nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Harga Jual</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="harga_jual" name="harga_jual"
                            value="{{ old('harga_jual') }}" required>
                        @error('harga_jual')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Harga Beli</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="harga_beli" name="harga_beli"
                            value="{{ old('harga_beli') }}" required>
                        @error('harga_beli')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Gambar</label>
                    <div class="col-11">
                        <input type="file" class="form-control" id="image" name="image" required>
                        @error('image')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kategori</label>
                    <div class="col-11">
                        <select class="form-control" id="kategori_id" name="kategori_id" required>
                            <option value="">- Pilih Kategori -</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->kategori_id }}" data-kategori-kode="{{ $item->kategori_kode }}">
                                    {{ $item->kategori_nama }}</option>
                            @endforeach
                        </select>
                        @error('level_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('user') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fungsi untuk mengisi otomatis kode barang
            function generateBarangKode(kategoriKode) {
                var randomCode = Math.floor(Math.random() * 100); // Kode acak 4 karakter
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
                var yyyy = today.getFullYear();
                var dateCode = dd + mm + yyyy; // Tanggal sekarang format (DDMMYYYY)

                var barangKode = kategoriKode + "0" + randomCode + dateCode;
                return barangKode;
            }
            // $('#barang_kode').prop('disabled', true);
            // Event ketika kategori dipilih
            $('#kategori_id').change(function() {
                var kategoriKode = $(this).find(':selected').data(
                    'kategori-kode'); // Ambil data kategori kode
                var barangKode = generateBarangKode(kategoriKode); // Buat kode barang
                $('#barang_kode_input').val(barangKode); // Isi input kode barang
                $('input[name="barang_kode"]').val(barangKode);
            });



            function validatePrice() {
                var hargaJual = parseFloat($('#harga_jual').val());
                var hargaBeli = parseFloat($('#harga_beli').val());

                if (hargaJual <= hargaBeli) {
                    alert('Harga jual harus lebih tinggi dari harga beli!');
                    return false; // Menghentikan pengiriman formulir
                }
                return true; // Lanjut pengiriman formulir
            }

            // Event ketika formulir disubmit
            $('form').submit(function() {
                return validatePrice();
            });
        });
        // $(document).ready(function() {
        //     var $kategoriSelect = $('#kategori_id');
        //     var $barangNamaInput = $('#barang_nama');
        //     var $hargaJualInput = $('#harga_jual');
        //     var $hargaBeliInput = $('#harga_beli');
        //     var $barangKodeInput = $('#barang_kode');

        //     var $inputs = [$kategoriSelect, $barangNamaInput, $hargaJualInput, $hargaBeliInput];

        //     $inputs.forEach(function($input) {
        //         $input.on('change', generateBarangKode);
        //     });

        //     function generateBarangKode() {
        //         if ($kategoriSelect.val() && $barangNamaInput.val() && $hargaJualInput.val() && $hargaBeliInput
        //             .val()) {
        //             var kategoriKode = $kategoriSelect.data();
        //             // getUniqueKode().done(function(uniqueKode) {
        //             var uniqueKode = Math.floor(Math.random() * 100);
        //             var today = new Date();
        //             var date = String(today.getDate()).padStart(2, '0');
        //             var month = String(today.getMonth() + 1).padStart(2, '0');
        //             var year = today.getFullYear();

        //             var barangKode = kategoriKode + uniqueKode + date + month + year;
        //             $barangKodeInput.val(barangKode);
        //             // });
        //         }
        //     }
        //     $hargaJualInput.on('change', function() {
        //         var hargaJual = parseFloat($hargaJualInput.val());
        //         var hargaBeli = parseFloat($hargaBeliInput.val());

        //         // Validasi harga jual harus lebih besar dari harga beli
        //         if (hargaJual <= hargaBeli) {
        //             alert('Harga jual harus lebih besar dari harga beli!');
        //             $hargaJualInput.val(''); // Menghapus nilai jika tidak valid
        //         }
        //     });

        //     // Event listener untuk perubahan pada input harga beli
        //     $hargaBeliInput.on('change', function() {
        //         var hargaJual = parseFloat($hargaJualInput.val());
        //         var hargaBeli = parseFloat($hargaBeliInput.val());

        //         // Validasi harga jual harus lebih besar dari harga beli
        //         if (hargaJual <= hargaBeli) {
        //             alert('Harga jual harus lebih besar dari harga beli!');
        //             $hargaBeliInput.val(''); // Menghapus nilai jika tidak valid
        //         }
        //     });

        //     // function getUniqueKode() {
        //     //     return $.ajax({
        //     //         url: '{{ url('barang/unique-kode') }}',
        //     //         method: 'GET',
        //     //         dataType: 'json'
        //     //     }).then(function(data) {
        //     //         return data.uniqueKode;
        //     //     }).catch(function(error) {
        //     //         console.error('Error fetching unique kode:', error);
        //     //         return '';
        //     //     });
        //     // }
        // });
    </script>
@endsection
@push('css')
@endpush
@push('js')
@endpush
