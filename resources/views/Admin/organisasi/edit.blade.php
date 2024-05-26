@extends('Master')
@section('title')
    Edit Organisasi| FT Unsulbar
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Organisasi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('organisasi.index') }}">Daftar Organisasi</a></li>
                        <li class="breadcrumb-item active">Edit Organisasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card">
                        <!-- form start -->
                        <form method="post" action="{{ route('organisasi.update', $organisasi->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nameOrganization">Organization</label>
                                            <div class="input-group">
                                                <input type="text" name="organisasi"
                                                    class="form-control @error('organisasi') is-invalid @enderror"
                                                    placeholder="name organization"
                                                    value="{{ old('organisasi', $organisasi->name) }}" required autofocus>
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
                                <button type="submit" class="btn btn-info">Update</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
@endsection
