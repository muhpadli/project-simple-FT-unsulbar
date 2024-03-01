@extends('Master')
@section('title')
    Manage User | FT Unsulbar
@endsection
@section('sidebar')
    @include('layout.Admin.SidebarAdmin')
@endsection
@section('organisasiStatus')
    active
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1>Tambah User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('ManageUsers.index') }}">Daftar User</a></li>
                        <li class="breadcrumb-item active">Tambah User</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header ">
                            <h3 class="card-title">
                                Informasi User
                            </h3>
                        </div>
                        <form action="{{ route('ManageUsers.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    {{-- form nama lengkap --}}
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="namaLengkap">Nama Lengkap</label>
                                            <input type="text"
                                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                                placeholder="Enter your name" name="nama_lengkap" id="namaLengkap"
                                                value="{{ old('nama_lengkap') }}" autofocus required>
                                            @error('nama_lengkap')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- form NIP --}}
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="NIP">NIP</label>
                                            <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                                placeholder="Enter your NIP (Opsional)" name="nip" id="NIP"
                                                value="{{ old('nip') }}">
                                            @error('nip')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- form kontak --}}
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="kontak">Kontak</label>
                                            <input type="text" class="form-control @error('kontak') is-invalid @enderror"
                                                placeholder="Example : +6287908456123" id="kontak" name="kontak"
                                                value="{{ old('kontak') }}" required>
                                            @error('kontak')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- Form Gender --}}
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="gender">Jenis Kelamin</label>
                                            <select class="form-control" name="gender" id="gender"
                                                value="{{ old('gender') }}">
                                                @forelse ($genders as $jk)
                                                    <option value="{{ $jk->id }}">{{ $jk->namaGender }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="exampleEmail">Email</label>
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Enter your email" id="exampleEmail"
                                                value="{{ old('email') }}">
                                            @error('email')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Form Alamat --}}
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="exampleAlamat">Alamat</label>
                                            <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                                                placeholder="Enter your alamat" name="alamat" id="exampleAlamat"
                                                value="{{ old('alamat') }}">
                                            @error('alamat')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header card-outline card-info">
                                <h3 class="card-title ">
                                    Keamanan User
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- Form Role --}}
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="role">
                                                Role
                                            </label>
                                            <select class="form-control" name="role" id="role"
                                                value="{{ old('role') }}">
                                                <option selected>---Pilih Role User---</option>
                                                @forelse ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name_role }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    {{-- Form Username --}}
                                    <div class="col">
                                        <div class="form-group @error('username') is-invalid @enderror">
                                            <label for="Username">Username</label>
                                            <input type="text" class="form-control" placeholder="Enter your Username"
                                                value="{{ old('username') }}" id="Username" name="username">
                                            @error('username')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Form Password --}}
                                    <div class="col">
                                        <div class="form-group @error('password') is-invalid @enderror">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" placeholder="Enter your password"
                                                id="password" name="password">
                                            @error('password')
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
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $('#organisasi').on('change', function() {
                var organisasiID = $(this).val();
                // console.log(organisasiID);
                if (organisasiID) {
                    $.ajax({
                        url: '/jabatan/' + organisasiID,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data);
                            if (data) {
                                $('#jabatan').empty();
                                $('#jabatan').append(
                                    '<option value"">---pilih jabatan---</option>');
                                $.each(data, function(key, jabatan) {
                                    $('select[name="jabatan"]').append(
                                        '<option value="' + jabatan.id + '">' +
                                        jabatan.name + '</option>'
                                    )
                                });
                            } else {

                            }
                        }
                    });
                } else {

                }
            });
        });
    </script>
@endsection
