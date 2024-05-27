@extends('Master')
@section('title')
    Page Profile | SIMPLE
@endsection
@section('head')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0') }}/plugins/toastr/toastr.min.css">
@endsection
@section('content')
    @php
        $user_id = auth()->user()->id;
        $level_user_id = DB::table('users')
            ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('level_users', 'level_users.id', '=', 'jabatans.level_users_id')
            ->select('level_users.tingkat')
            ->where('users.id', '=', $user_id)
            ->get()
            ->first();
    @endphp
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/users') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
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
                        {{-- Start Form Update Profil --}}
                        <form action="{{ route('profil.update', auth()->user()->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="oldImage" value="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div>
                                            @if ($data && $data->image !== null)
                                                <img class="card-img-top img-thumbnail"
                                                    src="{{ asset('storage/' . $data->image) }}" alt="Card image">
                                            @else
                                                <img style="max-height: 360px;" class="card-img-top p-4 img-thumbnail"
                                                    src="{{ asset('storage/post-images/user.png') }}" alt="Card image">
                                            @endif
                                        </div>
                                        <div class="row mt-3 ml-3">
                                            <input type="file" name="image">
                                            @error('image')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        @if (session()->has('success'))
                                            <div class="alert alert-success alert-dismissible small fade show col-12"
                                                role="alert">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        <table class="table-striped col-md-12 p-0">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">
                                                        Info User
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="col-3">
                                                        Nama Lengkap
                                                    </td>
                                                    <td>:</td>
                                                    <td class="col float-left">
                                                        <input type="text" name="nama"
                                                            class="form-control  @error('nama') is-invalid @enderror"
                                                            value="{{ $data->nama }}">
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
                                                        <td class="col float-left"><input type="text"
                                                                class="form-control" value="-" name="nip">
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
                                                                type="text" value="{{ $data->alamat }}"
                                                                name="alamat" id="">
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
                                            </tbody>
                                        </table>
                                        <table class="table-striped mt-3  ">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">Riwayat Pendidikan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="p-0">
                                                    <td class="col-3">Strata-1</td>
                                                    <td>:</td>
                                                    <td class="col ">
                                                        <input class="form-control @error('strata_1') is-invalid @enderror"
                                                            type="text"
                                                            @if ($story_study != null) value="{{ $data->strata_1 }}" @else value="" @endif
                                                            name="strata_1" id="">
                                                        @error('strata_1')
                                                            <div class="alert alert-danger mt-2">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="p-0">
                                                    <td class="col-3 ">Strata-2</td>
                                                    <td>:</td>
                                                    <td class="col">
                                                        <input class="form-control @error('strata_2') is-invalid @enderror"
                                                            type="text"
                                                            @if ($story_study != null) value="{{ $data->strata_2 }}" @else value="" @endif
                                                            name="strata_2" id="">
                                                        @error('strata_2')
                                                            <div class="alert alert-danger mt-2">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="p-0">
                                                    <td class="col-md-3">Strata-3</td>
                                                    <td>:</td>
                                                    <td class="col">
                                                        <input
                                                            class="form-control @error('strata_3') is-invalid @enderror"
                                                            type="text"
                                                            @if ($story_study != null) value="{{ $data->strata_3 }}" @else value="" @endif
                                                            name="strata_3" id="">
                                                        @error('strata_3')
                                                            <div class="alert alert-danger mt-2">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="col">
                                    <button type="submit" class="btn bg-info float-right">Update</button>
                                </div>
                            </div>
                        </form>
                        {{-- End Form Update Profil --}}
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
