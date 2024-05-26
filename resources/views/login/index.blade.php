<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page | SIMPLE FT Unsulbar</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0') }}/dist/css/adminlte.min.css">
    <style>
        main {
            display: flex;
            width: 100%;
            height: 100vh;
            margin-left: 0;
        }


        .protest-guerrilla-regular {
            font-family: "Protest Guerrilla", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .form-login {
            margin: auto;
            align-self: stretch;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body class="hold-transition sidebar-collapse">
    @include('sweetalert::alert')
    <div class="wrapper ">
        <!-- Content Wrapper. Contains page content -->
        <div class="content">
            <!-- Main content -->
            <div class="content m-0">
                <main class="row d-flex ">
                    <img class="col-md-8 d-none d-md-block" src="{{ asset('storage/post-images/perpustakaan.jpg') }}"
                        alt="">
                    <div class="form-login  border rounded-3 p-5">
                        <h4 class="protest-guerrilla-regular">SIMPLE | Fakultas Teknik</h4>
                        <p class="login-box-msg">Sign in to start your session</p>
                        <form action="{{ url('login/store') }}" method="POST">
                            @csrf
                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session()->has('loginError'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('loginError') }}
                                </div>
                            @endif
                            <div class="input-group mb-3">

                                <input type="text" name="username"
                                    class="form-control @error('username') is-invalid @enderror" placeholder="Username"
                                    autofocus required value="{{ old('username') }}">
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
                            <div class="input-group mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required placeholder="Password">
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
                            <div class="row">
                                <!-- /.col -->
                                <div class="col">
                                    <button type="submit" class="btn btn-block bg-info">Sign
                                        In</button>
                                </div>
                                <!-- /.col -->
                            </div>
                            <div class="row">
                                <div class="col mt-2">
                                    <p class="login-box-msg text-sm">created by <br>
                                        <a href=""><strong>KPI Prodi Informatika 2024</strong></a>
                                    </p>
                                </div>
                            </div>
                        </form>
                </main>
            </div>
        </div>
        <!-- /.content -->
    </div>

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('AdminLTE-3.2.0') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('AdminLTE-3.2.0') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE-3.2.0') }}/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('AdminLTE-3.2.0') }}/dist/js/demo.js"></script>

</body>

</html>
