@extends('Master')
@section('title')
    Detail User | FT Unsulbar
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
                    <h1>Detail User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('ManageUsers.index') }}">Daftar User</a></li>
                        <li class="breadcrumb-item active">Detail User</li>
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
                                Info User
                            </div>
                            <div class="card-body" style="max-height: 450px;">
                                <div class="col-3 float-left mr-3">
                                    <div style="max-height: 400px;">
                                        @if ($user->image)
                                            <img style="max-height: 360px; " class="card-img-top img-thumbnail"
                                                src="{{ asset('storage/' . $user->image) }}" alt="Card image">
                                        @else
                                            <img style="max-height: 360px;" class="card-img-top img-thumbnail"
                                                src="https://source.unsplash.com/400x600/?user" alt="Card image">
                                        @endif
                                    </div>
                                    <div class="row mt-3 ml-3">
                                        <input type="file" name="" id="">
                                    </div>
                                </div>
                                <div class="row">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success alert-dismissible small fade show col-12"
                                            role="alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <table class="table-striped col-md-12">
                                        <tr>
                                            <td class="col-2">
                                                Nama Lengkap
                                            </td>
                                            <td>:</td>
                                            <td class="col float-left">
                                                <input type="text"
                                                    class="form-control @error('nama') is-invalid @enderror" name="nama"
                                                    value="{{ $user->name }}" required>
                                                @error('nama')
                                                    <div class="alert alert-danger mt-2">
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
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            @else
                                                <td class="col float-left">
                                                    <input type="text" class="form-control @error('nip') @enderror"
                                                        name="nip" value="-">
                                                    @error('nip')
                                                        <div class="alert alert-danger mt-2">
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
                                                    <input class="form-control @error('kontak') is-invalid @enderror"
                                                        type="text" value="{{ $data->kontak }}" name="kontak"
                                                        id="">
                                                    @error('kontak')
                                                        <div
                                                            class="alert alert-danger mt-2 @error('kontak') is-invalid @enderror">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            @else
                                                <td class="col"> <input class="form-control" type="text"
                                                        name="kontak" id="">
                                                    @error('kontak')
                                                        <div
                                                            class="alert alert-danger mt-2 @error('kontak') is-invalid @enderror">
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
                                                        value="{{ $data->email }}" name="email" id=""></td>
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
                                                    <select class="form-control @error('gender') is-invalid @enderror"
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
                                                            class="alert alert-danger mt-2 @error('kontak') is-invalid @enderror">
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
                                                    <option selected>---Pilih Jabatan---</option>
                                                </select>
                                                @error('jabatan')
                                                    <div
                                                        class="alert alert-danger mt-2 @error('kontak') is-invalid @enderror">
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
                                                    <input class="form-control @error('alamat') is-invalid @enderror"
                                                        type="text" value="{{ $data->alamat }}" name="alamat"
                                                        id="">
                                                    @error('alamat')
                                                        <div
                                                            class="alert alert-danger mt-2 @error('kontak') is-invalid @enderror">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            @else
                                                <td class="col">
                                                    <input class="form-control @error('alamat') is-invalid @enderror"
                                                        type="text" name="alamat" id="">
                                                    @error('alamat')
                                                        <div
                                                            class="alert alert-danger mt-2 @error('kontak') is-invalid @enderror">
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
                        </div>
                    </form>
                </div>
            </div>
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous">
    </script>
    <script>
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
                                        '" ' + isSelected + ' >' +
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
