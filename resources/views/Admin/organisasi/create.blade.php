@extends('Master')
@section('title')
    Tambah Organisasi| SIMPLE
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Organisasi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('organisasi.index') }}">Daftar Organisasi</a></li>
                        <li class="breadcrumb-item active">Tambah Organisasi</li>
                    </ol>
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
                        <!-- form start -->
                        <form method="post" action="{{ route('organisasi.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nameOrganization">Nama Organisasi</label>
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
                                <a href="{{ route('organisasi.index') }}" class="btn btn-sm btn-info" title="kembali"><i
                                        class="fa fa-arrow-left"></i></a>
                                <button type="submit" class="btn btn-sm btn-info" title="tambah data">Tambah</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
@endsection
