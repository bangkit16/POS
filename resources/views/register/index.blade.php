<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>Register</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Register your account</p>

                <form action="/register " method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3 form-floating">
                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                            placeholder="Nama" id="nama" value="{{ old('nama') }}" name="nama">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-group mb-3 form-floating">
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            placeholder="Username" id="username" value="{{ old('username') }}" name="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-group mb-3 form-floating">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" id="password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-group mb-3 form-floating">
                        <div class="input-group-append">
                            <input type="file" class="custom-file-input" name="image" id="customFile" @error('image') is-invalid @enderror>
                            <label class="custom-file-label" for="customFile">Gambar</label>
                            {{-- <label for="image">Gambar</label>
                            <input type="file" class="form-label form-control @error('image') is-invalid @enderror"
                                placeholder="" id="image" name="image"> --}}
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <script>
                      $(document).ready(function() {
                          $('#customFile').on('change', function() {
                              var fileName = $(this).val().split('\\').pop();
                              $(this).next('.custom-file-label').addClass("selected").html(fileName);
                          });
                      });
                  </script>
                    <div class="row justify-content-center">

                        <!-- /.col -->
                        {{-- <input type="hidden" value="3" name="level_id"> --}}
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


                <p class="mb-0 d-block mt-3">
                    <a href="/login" class="text-center">Login to your account</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src=" {{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
