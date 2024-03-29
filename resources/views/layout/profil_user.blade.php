@extends('Master')
@section('title')
    Detail User | FT Unsulbar
@endsection
@section('head')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0') }}/plugins/toastr/toastr.min.css">
@endsection
@section('sidebar')
    @if (auth()->user()->roles_id == 1)
        @include('layout.Admin.SidebarAdmin')
    @else
        @include('layout.Sidebar')
    @endif
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profil</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashoard-pimpinan') }}">Beranda</a></li>
                        <li class="breadcrumb-item active">Profil</li>
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
                    <div class="card card-outline card-info">
                        <form action="{{ route('profil.update', auth()->user()->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="oldImage" value="{{ $data->image }}">
                            <div class="card-header ">
                                Info User
                            </div>
                            <div class="card-body" style="max-height: 450px;">
                                <div class="col-3 float-left mr-3">
                                    <div style="max-height: 400px;">
                                        @if ($data->image)
                                            <img style="max-height: 360px; " class="card-img-top img-thumbnail"
                                                src="{{ asset('storage/' . $data->image) }}" alt="Card image">
                                        @else
                                            <img style="max-height: 360px;" class="card-img-top img-thumbnail"
                                                src="https://source.unsplash.com/400x600/?user" alt="Card image">
                                        @endif
                                    </div>
                                    <div class="row mt-3 ml-3">
                                        <input type="file" name="image">
                                    </div>
                                </div>
                                <div class="row">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success alert-dismissible small fade show col-12"
                                            role="alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <table class="table-striped col-md-12 p-0">
                                        <tr class="p-0">
                                            <td class="col-3">
                                                Nama Lengkap
                                            </td>
                                            <td>:</td>
                                            <td class="col float-left">
                                                <input type="text" name="nama"
                                                    class="form-control  @error('nama') is-invalid @enderror"
                                                    value="{{ $data->name }}">
                                                @error('nama')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">
                                                NIP
                                            </td>
                                            <td>:</td>
                                            @if ($data->NIP)
                                                <td class="col float-left"><input type="text"
                                                        class="form-control @error('nip') is-invalid @enderror"
                                                        value="{{ $data->NIP }}" name="nip">
                                                    @error('nip')
                                                        <div class="alert alert-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            @else
                                                <td class="col float-left"><input type="text" class="form-control"
                                                        value="-" name="nip">
                                                    @error('nip')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="col-3">
                                                Kontak
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            @if ($data->kontak)
                                                <td class="col"> <input
                                                        class="form-control @error('kontak') is-invalid @enderror"
                                                        type="text" value="{{ $data->kontak }}" name="kontak"
                                                        id="">
                                                    @error('kontak')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            @else
                                                <td class="col"> <input
                                                        class="form-control  @error('kontak') is-invalid @enderror"
                                                        type="text" name="kontak" id="">
                                                    @error('kontak')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="col-3">
                                                Email
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            @if ($data->email)
                                                <td class="col"> <input
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        type="email" value="{{ $data->email }}" name="email"
                                                        id="">
                                                    @error('email')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            @else
                                                <td class="col"> <input
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        type="text" name="kontak" id="">
                                                    @error('email')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="col-3">
                                                Jenis Kelamin
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            @if ($data->jk)
                                                <td class="col"> <input class="form-control" type="text"
                                                        value="{{ $data->jk }}" disabled></td>
                                            @else
                                                <td class="col"> <input class="form-control" type="text"
                                                        id=""></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="col-3">
                                                Organisasi
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            @if ($data->jabatan_id)
                                                <td class="col"> <input class="form-control" type="text"
                                                        value="{{ $data->nama_organisasi }}" disabled></td>
                                            @else
                                                <td class="col"> <input class="form-control" type="text"
                                                        id="" disabled></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="col-3">
                                                Jabatan
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            @if ($data->jabatan_id)
                                                <td class="col"> <input class="form-control" type="text"
                                                        value="{{ $data->nama_jabatan }}" disabled></td>
                                            @else
                                                <td class="col"> <input class="form-control" type="text"
                                                        id="" disabled></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="col-3">
                                                Alamat
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            @if ($data->alamat)
                                                <td class="col"> <input
                                                        class="form-control @error('alamat') is-invalid @enderror"
                                                        type="text" value="{{ $data->alamat }}" name="alamat"
                                                        id="">
                                                    @error('alamat')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            @else
                                                <td class="col"> <input
                                                        class="form-control @error('alamat') is-invalid @enderror"
                                                        type="text" name="alamat" id="">
                                                    @error('alamat')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            @endif
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="col">
                                    <button type="submit" class="btn bg-info float-right">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>

    <!-- /.content -->
@endsection

@section('script')
    <script src="{{ asset('AdminLTE-3.2.0') }}/plugins/jquery/jquery.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('AdminLTE-3.2.0') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous">
    </script>
    <script>
        //message with toastr

        $(document).ready(function() {
            // Function to set default values based on existing task data
            function setDefaultValues() {
                var organisasi_id = $('#organisasi').val();
                var jabatan_id = '{{ $data->jabatan_id ?? null }}';

                // Trigger change event to populate sub department and user dropdowns
                $('#organisasi').trigger('change');

                // Set default values for sub department and user
                $('#jabatan').val(jabatan_id).trigger('change');
            }

            // Event handler for change in department dropdown
            $('#organisasi').on('change', function() {
                var organisasi_id = $(this).val();

                if (organisasi_id) {
                    $.ajax({
                        url: '/user_pimpinan/DetailTask/create/' + organisasi_id,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                // Populate the department dropdown
                                var listJabatan = $('#jabatan');
                                listJabatan.empty();
                                listJabatan.append(
                                    '<option value="">Pilih Jabatan</option>');
                                $.each(data, function(key, jabatan) {
                                    var isSelected = (jabatan.id ==
                                            '{{ $data->jabatan_id ?? null }}') ?
                                        'selected' : '';
                                    listJabatan.append(
                                        '<option value="' + jabatan.id +
                                        '" ' + isSelected + '>' +
                                        jabatan.name + '</option>'
                                    )
                                });

                                // Trigger change event to populate user dropdown
                                $('#jabatan').trigger('change');
                            } else {}
                        }
                    });
                } else {
                    // Handle case when department is not selected
                }
            });

            // Call the function to set default values on document ready
            setDefaultValues();
        });
    </script>
@endsection
