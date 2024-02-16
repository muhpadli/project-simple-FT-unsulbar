@extends('Master')
@section('title')
    Manage Organization | FT Unsulbar
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
                    <h1>Organisasi Baru</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Organisasi Baru</h3>
                        </div>
                        <!-- form start -->
                        <form method="post" action="{{ route('manageOrganization.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nameOrganization">Organisasi</label>
                                            <div class="input-group">
                                                <input type="text" name="organisasi"
                                                    class="form-control @error('organisasi') is-invalid @enderror"
                                                    placeholder="name organization" required autofocus>
                                            </div>
                                            @error('organisasi')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">Create</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
@endsection
