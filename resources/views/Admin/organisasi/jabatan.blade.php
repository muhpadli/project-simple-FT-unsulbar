@extends('Master')
@section('title')
    Jabatan | FT SIMPLE
@endsection
@section('head')
    <style>
        .list-card {
            margin-left: 40px;
        }

        .list-card li {
            list-style: none;
            line-height: 6px;
        }

        .list-panduan li {
            list-style: none;

        }
    </style>
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Jabatan {{ $organisasi->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('users/organisasi') }}">Daftar Organisasi</a></li>
                        <li class="breadcrumb-item active">Jabatan {{ $organisasi->name }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.row -->
                <div class="card col-12 card-info card-outline">
                    {{-- Start List Button Navigation On Header Card  --}}
                    <div class="card-header">
                        <a href="{{ url('users/organisasi') }}" class="btn btn-sm bg-info" title="kembali">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <button type="button" class="btn btn-sm bg-info" data-toggle="modal" data-target="#modal-default">
                            <i class="fas fa-plus-square" title="tambah jabatan"></i>
                        </button>
                        <button type="button" class="btn btn-sm bg-info" data-toggle="modal" data-target="#modal-panduan">
                            <i class="fas fa-file" title="panduan pilih level jabatan"></i>
                        </button>
                    </div>
                    {{-- End List Button Navigation On Header Card  --}}

                    <div class="card-body p-0 ">
                        <div class="row p-3">
                            <div class="col-7 col-sm-9">
                                <div class="tab-content" id="vert-tabs-right-tabContent">
                                    <div class="tab-pane fade show active" id="vert-tabs-right-all" role="tabpanel"
                                        aria-labelledby="vert-tabs-right-all-tab">
                                        <div class="row">
                                            @forelse ($user as $us)
                                                <div class="col-md-12 col-lg-6 col-xl-6">
                                                    <div class="border mb-2" style="height: 90px;">
                                                        <div class="row">
                                                            <div class="col">
                                                                @if ($us->image)
                                                                    <img class="card-img-top"
                                                                        src="{{ asset('storage/' . $us->image) }}"
                                                                        alt="Card image"
                                                                        style="height: 90px; max-width: 70px"
                                                                        align="left">
                                                                @else
                                                                    <img class="card-img-top p-1 pt-3"
                                                                        src="{{ asset('storage/post-images/user.png') }}"
                                                                        alt="Card image"
                                                                        style="eight: 90px; max-width: 70px;"
                                                                        align="left">
                                                                @endif
                                                                <ul class="list-card mt-3">
                                                                    <li>
                                                                        <h6 class="text-primary ">{{ $us->name }}</h6>
                                                                    </li>
                                                                    <li class="small">
                                                                        NIP : {{ $us->NIP }}</p>
                                                                    </li>
                                                                    <li class="small" hspace="10">
                                                                        Jabatan : {{ $us->jabName }} </p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="alert alert-danger col-12">
                                                    Daftar pegawai belum ada
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                    @forelse ($data as $item)
                                        <div class="tab-pane fade show" id="vert-tabs-right-{{ $item->id }}"
                                            role="tabpanel" aria-labelledby="vert-tabs-right-{{ $item->id }}-tab">
                                            <div class="row pt-0 m-0 mb-3">
                                                {{-- Start Button Edit dan Hapus Jabatan --}}
                                                <button type="button" class="btn btn-info btn-sm mr-1" data-toggle="modal"
                                                    data-target="#modal-edit-{{ $item->id }}" title="edit jabatan">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus jabatan {{ $item->name }}?')"
                                                    action="{{ url('users/organisasi/jabatan/destroy', $item->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        title="hapus jabatan">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                {{-- End Button Edit dan Hapus Jabatan --}}
                                                {{-- Start Modal Edit Jabatan --}}
                                                <div class="modal fade" id="modal-edit-{{ $item->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Jabatan</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            {{-- Start Form Edit Jabatan --}}
                                                            <form
                                                                action="{{ url('/users/organisasi/jabatan/update', $item->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="id_organisasi"
                                                                    value="{{ $organisasi->id }}">
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="jabatan">Nama Jabatan</label>
                                                                        <input type="text"
                                                                            class="form-control @error('jabatan') is-invalid @enderror"
                                                                            required value="{{ $item->name }}"
                                                                            name="jabatan" id="jabatan">
                                                                        @error('jabatan')
                                                                            <div class="alert alert-danger mt-2">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="level_user">Level Jabatan</label>
                                                                        <select class="form-control select2"
                                                                            name="level_user" style="width: 100%;">
                                                                            <option selected="selected">Pilih Level
                                                                            </option>
                                                                            @foreach ($level_users as $lu)
                                                                                <option value="{{ $lu->id }}"
                                                                                    @if ($lu->id == $item->level_users_id) selected @endif>
                                                                                    {{ $lu->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('level_user')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-info">submit</button>
                                                                </div>
                                                            </form>
                                                            {{-- End Form Edit Jabatan --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- End Modal Edit Jabatan --}}
                                            </div>
                                            <div class="row">
                                                @foreach ($user->where('jabatan_id', '=', $item->id) as $us)
                                                    <div class="col-md-12 col-lg-6 col-xl-6">
                                                        <div class="card mb-2" style="height: 90px;">
                                                            <div class="row">
                                                                <div class="col">
                                                                    @if ($us->image)
                                                                        <img class="card-img-top"
                                                                            src="{{ asset('storage/' . $us->image) }}"
                                                                            alt="Card image"
                                                                            style="height: 90px; max-width: 70px"
                                                                            align="left">
                                                                    @else
                                                                        <img class="card-img-top p-1 pt-3"
                                                                            src="{{ asset('storage/post-images/user.png') }}"
                                                                            alt="Card image"
                                                                            style="eight: 90px; max-width: 70px;"
                                                                            align="left">
                                                                    @endif
                                                                    <ul class="list-card mt-3">
                                                                        <li>
                                                                            <h6 class="text-primary ">{{ $us->name }}
                                                                                </h5>
                                                                        </li>
                                                                        <li class="small">
                                                                            NIP : {{ $us->NIP }}</p>
                                                                        </li>
                                                                        <li class="small" hspace="10">
                                                                            Jabatan : {{ $us->jabName }} </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            <div class="col-5 col-sm-3 fixed">
                                <div class="nav flex-column nav-tabs nav-tabs-right h-100" id="vert-tabs-right-tab"
                                    role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active " id="vert-tabs-right-all-tab" data-toggle="pill"
                                        href="#vert-tabs-right-all" role="tab" aria-controls="vert-tabs-right-all"
                                        aria-selected="true">All
                                    </a>
                                    @forelse ($data as $item)
                                        <a class="nav-link" id="vert-tabs-right-{{ $item->id }}-tab"
                                            data-toggle="pill" href="#vert-tabs-right-{{ $item->id }}"
                                            role="tab" aria-controls="vert-tabs-right-{{ $item->id }}"
                                            aria-selected="true">{{ $item->name }}
                                        </a>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    {{-- Start Modal Tambah Jabatan --}}
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Jabatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="quickForm" action="{{ url('/users/organisasi/jabatan/store') }}" method="post">
                    @csrf
                    <input type="hidden" name="id_organisasi" value="{{ $organisasi->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jabatan">Nama Jabatan</label>
                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" required
                                name="jabatan" id="jabatan">
                            @error('jabatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="level_user">Level Jabatan</label>
                            <select class="form-control select2" name="level_user" style="width: 100%;">
                                <option selected="selected">Pilih Level</option>
                                @foreach ($level_users as $lu)
                                    <option value="{{ $lu->id }}">{{ $lu->name }}</option>
                                @endforeach
                            </select>
                            @error('level_user')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal Tambah Jabatan --}}


    <div class="modal fade" id="modal-panduan">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Panduan Pilih Level Jabatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table-striped table-bordered m-3">
                        <thead>
                            <tr>
                                <th class="text-center">Daftar Level Users</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>1. Dekan</th>
                            </tr>
                            <tr>
                                <td>Deskripsi : Level user khusus jabatan dekan </td>
                            </tr>
                            <tr>
                                <th>2. Ketua_senat&GPM</th>
                            </tr>
                            <tr>
                                <td>Deskripsi : Level user khusus jabatan ketua GPM dan ketua senat.</td>
                            </tr>
                            <tr>
                                <th>3. Wakil Dekan 1</th>
                            </tr>
                            <tr>
                                <td>Deskripsi : Level user khusus jabatan wakil dekan 1</td>
                            </tr>
                            <tr>
                                <th>4. Wakil Dekan 2</th>
                            </tr>
                            <tr>
                                <td>Deskripsi : Level user khusus jabatan wakil dekan 2</td>
                            </tr>
                            <tr>
                                <th>5. Koordinator</th>
                            </tr>
                            <tr>
                                <td>Deskripsi : Level user khusus Koordinator Prodi atau Sub Bagian</td>
                            </tr>
                            <tr>
                                <th>6. Staf</th>
                            </tr>
                            <tr>
                                <td>Deskripsi : Level user khusus Prodi Prodi atau Sub Bagian</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


@endsection
@section('script')
    <!-- jQuery -->
    <script src="{{ asset('AdminLTE-3.2.0') }}/plugins/jquery/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
