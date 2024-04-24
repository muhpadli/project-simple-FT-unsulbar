@extends('Master')
@section('title')
    Dashboard | FT Unsulbar
@endsection
@section('head')
    <style>
        .info-box:hover {
            border-right: 5px solid #17a2b8;
        }
    </style>
@endsection
@section('sidebar')
    @include('layout.Admin.SidebarAdmin')
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
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box shadow-small">
                        <span class="info-box-icon bg-info"><i class="fas fa-sitemap"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Organisasi</span>
                            <span class="info-box-number"><a href="{{ route('organisasi') }}" style="color: black">{{ $Organization->count() }}</a></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>


                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box shadow-small">
                        <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total users</span>
                            <span class="info-box-number"><a href="{{ route('ManageUsers.index') }}" style="color: black">{{ $users->count() }}</a></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
