<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <style>
        .bg-default {
            background: #6477DB;
            color: white;
        }

        .protest-guerrilla-regular {
            font-family: "Protest Guerrilla", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
    </style>


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0') }}/dist/css/adminlte.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet"
        href="{{ asset('AdminLTE-3.2.0') }}/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0') }}/plugins/select2/css/select2.min.css">
    {{-- <link rel="stylesheet"
        href="{{ asset('AdminLTE-3.2.0') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css"> --}}
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="{{ asset('AdminLTE-3.2.0') }}/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="style.css">
    @yield('head')
</head>

<body class="hold-transition sidebar-mini  layout-fixed">
    @include('sweetalert::alert')


    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar lins -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link user-panel d-flex align-items-center" data-toggle="dropdown" href="#">
                        <div class="info">
                            <span class="d-block">{{ auth()->user()->name }}</span>
                        </div>
                        <div class="icon">
                            <i class="fa fa-caret-down"></i>
                        </div>

                    </a>
                    <div class="dropdown-menu  dropdown-menu-right">
                        <a href="{{ route('profil.index') }}" class="dropdown-item m-0">
                            <i class="fas fa-user-circle mr-2"></i> Profil
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item btn gap-2"><i
                                    class="fa fa-arrow-alt-circle-right mr-2"></i>
                                Logout</button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        @if (auth()->user()->roles_id == 2)
            <!-- Main Sidebar Container -->
            @include('layout.Sidebar')
        @else
            @include('Admin.layout.SidebarAdmin')
        @endif



        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>Copyright &copy; 2024<a href=""> KPI Prodi Informatika 2024</a>.</strong> All
            rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->


    </div>


    <!-- ./wrapper -->
    @yield('script')
    <!-- jQuery -->
    <script src="{{ asset('AdminLTE-3.2.0') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('AdminLTE-3.2.0') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE-3.2.0') }}/dist/js/adminlte.min.js"></script>

</body>

</html>
