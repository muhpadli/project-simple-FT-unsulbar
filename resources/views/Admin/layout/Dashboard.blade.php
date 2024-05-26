@extends('Master')
@section('title')
    Beranda Admin
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            {!! $Chart->container() !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="info-box shadow-small">
                                <span class="info-box-icon bg-fuchsia"><i class="fas fa-sitemap"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Organisasi</span>
                                    <span class="info-box-number"><a href="{{ url('/users/organisasi') }}"
                                            style="color: black">{{ $Organization->count() }}</a></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-12">
                            <div class="info-box shadow-small">
                                <span class="info-box-icon bg-indigo"><i class="fas fa-user-tie"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Pegawai</span>
                                    <span class="info-box-number"><a href="{{ url('/users/pegawai') }}"
                                            style="color: black">{{ $countPegawai }}</a></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
@section('script')
    <script src="{{ $Chart->cdn() }}"></script>
    {{ $Chart->script() }}
@endsection
