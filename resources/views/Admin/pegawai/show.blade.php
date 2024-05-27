@extends('Master')
@section('title')
    Detail User | SIMPLE
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Pegawai</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Daftar Pegawai</a></li>
                        <li class="breadcrumb-item active">Detail Pegawai</li>
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
                    <form action="{{ route('update_user', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_profil" value="{{ $user->profil_id }}">
                        <input type="hidden" name="oldImage" value="{{ $user->image }}">
                        <div class="card card-outline card-info">
                            <div class="card-header ">
                                <a href="{{ route('pegawai.index') }}" class="btn btn-info btn-sm" title="kembali">
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div style="max-height: 360px;">
                                            @if ($user->image)
                                                <img class="card-img-top img-thumbnail" style="max-height: 360px"
                                                    src="{{ asset('storage/' . $user->image) }}" alt="Card image">
                                            @else
                                                <img class="card-img-top p-4 img-thumbnail"
                                                    src="{{ asset('storage/post-images/user.png') }}" alt="Card image">
                                            @endif
                                        </div>
                                        <div class="row mt-3 ml-3">
                                            <input type="file" name="image" id="">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        @if (session()->has('success'))
                                            <div class="alert alert-success alert-dismissible small fade show col-12"
                                                role="alert">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        <table class="table-striped col-md-12">
                                            <tbody>
                                                <tr>
                                                <tr>
                                                    <th colspan="2">Info Pegawai</th>
                                                </tr>
                                                <td class="col-2">
                                                    Nama Lengkap
                                                </td>
                                                <td>:</td>
                                                <td class="col float-left">
                                                    <input type="text"
                                                        class="form-control @error('nama') is-invalid @enderror"
                                                        name="nama" value="{{ $user->name }}" required>
                                                    @error('nama')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-2">
                                                        NIP
                                                    </td>
                                                    <td>:</td>
                                                    @if ($data->NIP)
                                                        <td class="col float-left">
                                                            <input type="text"
                                                                class="form-control @error('nip') is-invalid @enderror"
                                                                value="{{ $data->NIP }}" name="nip">
                                                            @error('nip')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </td>
                                                    @else
                                                        <td class="col float-left">
                                                            <input type="text"
                                                                class="form-control @error('nip') @enderror" name="nip"
                                                                value="-">
                                                            @error('nip')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td class="col-2">
                                                        Kontak
                                                    </td>
                                                    <td>
                                                        :
                                                    </td>
                                                    @if ($data->kontak)
                                                        <td class="col">
                                                            <input
                                                                class="form-control @error('kontak') is-invalid @enderror"
                                                                type="text" value="{{ $data->kontak }}" name="kontak"
                                                                id="">
                                                            @error('kontak')
                                                                <div
                                                                    class="invalid-feedback @error('kontak') is-invalid @enderror">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </td>
                                                    @else
                                                        <td class="col"> <input class="form-control" type="text"
                                                                name="kontak" id="">
                                                            @error('kontak')
                                                                <div
                                                                    class="invalid-feedback @error('kontak') is-invalid @enderror">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td class="col-2">
                                                        Email
                                                    </td>
                                                    <td>
                                                        :
                                                    </td>
                                                    @if ($data->email)
                                                        <td class="col"> <input class="form-control" type="email"
                                                                value="{{ $data->email }}" name="email" id="">
                                                        </td>
                                                    @else
                                                        <td class="col"> <input class="form-control" type="text"
                                                                name="kontak" id=""></td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td class="col-2">
                                                        Jenis Kelamin
                                                    </td>
                                                    <td>
                                                        :
                                                    </td>
                                                    @if ($data->namaGender)
                                                        <td class="col">
                                                            <select
                                                                class="form-control @error('gender') is-invalid @enderror"
                                                                name="gender">
                                                                @forelse ($gender as $value)
                                                                    <option value="{{ $value->id }}"
                                                                        {{ $value->id == $data->genders_id ? 'selected' : '' }}>
                                                                        {{ $value->namaGender }} </option>
                                                                @empty
                                                                @endforelse
                                                            </select>
                                                            @error('gender')
                                                                <div
                                                                    class="invalid-feedback @error('kontak') is-invalid @enderror">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td class="col-2">
                                                        Organisasi
                                                    </td>
                                                    <td>
                                                        :
                                                    </td>
                                                    <td class="col">
                                                        <select class="form-control" name="organisasi" id="organisasi"
                                                            value="{{ old('organisasi') }}">
                                                            <option selected>---Pilih Organisasi---</option>
                                                            @forelse ($organisasi as $org)
                                                                <option value="{{ $org->id }}"
                                                                    @if ($data->jabatan_id != null) {{ $org->id == $data2->organisasi_id ? 'selected' : '' }} @endif>
                                                                    {{ $org->name }}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-2">
                                                        Jabatan
                                                    </td>
                                                    <td>
                                                        :
                                                    </td>
                                                    <td class="col">
                                                        <select class="form-control @error('jabatan') is-invalid @enderror"
                                                            name="jabatan" id="jabatan" value="{{ old('jabatan') }}">
                                                        </select>
                                                        @error('jabatan')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-2">
                                                        Alamat
                                                    </td>
                                                    <td>
                                                        :
                                                    </td>
                                                    @if ($data->alamat)
                                                        <td class="col">
                                                            <input
                                                                class="form-control @error('alamat') is-invalid @enderror"
                                                                type="text" value="{{ $data->alamat }}"
                                                                name="alamat" id="">
                                                            @error('alamat')
                                                                <div
                                                                    class="invalid-feedback @error('kontak') is-invalid @enderror">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </td>
                                                    @else
                                                        <td class="col">
                                                            <input
                                                                class="form-control @error('alamat') is-invalid @enderror"
                                                                type="text" name="alamat" id="">
                                                            @error('alamat')
                                                                <div
                                                                    class="invalid-feedback @error('kontak') is-invalid @enderror">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table-striped mt-3">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">Riwayat Pendidikan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="p-0">
                                                    <td class="col-2">S-1</td>
                                                    <td>:</td>
                                                    <td class="col ">
                                                        <input
                                                            class="form-control @error('strata_1') is-invalid @enderror"
                                                            type="text"
                                                            @if ($story_study != null) value="{{ $data->strata_1 }}" @else value="" @endif
                                                            name="strata_1" id="">
                                                        @error('strata_1')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="p-0">
                                                    <td class="col-2 ">S-2</td>
                                                    <td>:</td>
                                                    <td class="col">
                                                        <input
                                                            class="form-control @error('strata_2') is-invalid @enderror"
                                                            type="text"
                                                            @if ($story_study != null) value="{{ $data->strata_2 }}" @else value="" @endif
                                                            name="strata_2" id="">
                                                        @error('strata_2')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="p-0">
                                                    <td class="col-md-2">S-3</td>
                                                    <td>:</td>
                                                    <td class="col">
                                                        <input
                                                            class="form-control @error('strata_3') is-invalid @enderror"
                                                            type="text"
                                                            @if ($story_study != null) value="{{ $data->strata_3 }}" @else value="" @endif
                                                            name="strata_3" id="">
                                                        @error('strata_3')
                                                            <div class="invalid-feedback">
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
                        url: '/users/pegawai/jabatan_user/' + organisasi_id,
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
