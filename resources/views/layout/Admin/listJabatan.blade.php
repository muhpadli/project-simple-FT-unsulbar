@extends('Master')
@section('title')
    Manage User | FT Unsulbar
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
                    <h1>{{ $organisasi->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('organisasi') }}">Daftar Organisasi</a></li>
                        <li class="breadcrumb-item active">{{ $organisasi->name }}</li>
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
                    <div class="card-header">
                        <div class="card-title">Daftar Jabatan</div>
                        <button type="button" style="border: none" class="badge bg-info p-2 float-right"
                            data-toggle="modal" data-target="#modal-default">
                            <i class="fas fa-plus-square mr-2"></i> Tambah Jabatan
                        </button>
                    </div>
                    <div class="card-body p-0 ">
                        <div class="row p-3">
                            <div class="col-7 col-sm-9">
                                <div class="tab-content" id="vert-tabs-right-tabContent">
                                    <div class="tab-pane fade show active" id="vert-tabs-right-all" role="tabpanel"
                                        aria-labelledby="vert-tabs-right-all-tab">
                                        <div class="row">
                                            @forelse ($user as $us)
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div style="height: 220px; overflow:hidden;">
                                                            @if ($us->image)
                                                                <img class="card-img-top"
                                                                    src="{{ asset('storage/' . $us->image) }}"
                                                                    alt="Card image" style="height: 220px">
                                                            @else
                                                                <img class="card-img-top"
                                                                    src="https://source.unsplash.com/400x600/?user"
                                                                    alt="Card image">
                                                            @endif
                                                        </div>
                                                        <div class="card-body">
                                                            @php
                                                                $k = 0;
                                                            @endphp
                                                            <h4 class="card-title">{{ $us->name }}</h4>
                                                            <p class="card-text small">{{ $us->jabName }}</p>
                                                            <a href="{{ route('ManageUsers.show', $us->id) }}"
                                                                class="btn btn-info">See Profile</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="alert alert-danger col-12">
                                                    Daftar jabatan belum tersedia
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                    @forelse ($data as $item)
                                        <div class="tab-pane fade show" id="vert-tabs-right-{{ $item->id }}"
                                            role="tabpanel" aria-labelledby="vert-tabs-right-{{ $item->id }}-tab">
                                            <div class="row pt-0 m-0 mb-3">
                                                <div class="btn-group">
                                                    <a href="{{ route('add-jabatan.show', $item->id) }}"
                                                        class="btn btn-default btn-sm">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-default btn-sm"
                                                        data-toggle="modal" data-target="#modal-edit-{{ $item->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    {{-- modal edit jabatan --}}
                                                    <div class="modal fade" id="modal-edit-{{ $item->id }}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit Jabatan</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('add-jabatan.update', $item->id) }}"
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
                                                                            <label for="role">
                                                                                Pilih Role
                                                                            </label>
                                                                            <select class="form-control" name="role"
                                                                                id="role" value="{{ old('role') }}">
                                                                                <option>Pilih Role Jabatan
                                                                                </option>
                                                                                @forelse ($roles as $role)
                                                                                    <option value="{{ $role->id }}"
                                                                                        {{ $item->role_id === $role->id ? 'selected' : ' ' }}>
                                                                                        {{ $role->name_role }}</option>
                                                                                @empty
                                                                                @endforelse
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-info">submit</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @foreach ($user->where('jabatan_id', '=', $item->id) as $us)
                                                    <div class="col-md-3">
                                                        <div class="card">
                                                            <div style="max-height: 220px; overflow:hidden;">
                                                                @if ($us->image)
                                                                    <img class="card-img-top"
                                                                        src="{{ asset('storage/' . $us->image) }}"
                                                                        alt="Card image" style="height: 220px">
                                                                @else
                                                                    <img class="card-img-top"
                                                                        src="https://source.unsplash.com/400x600/?user"
                                                                        alt="Card image">
                                                                @endif
                                                            </div>
                                                            <div class="card-body">
                                                                @php
                                                                    $k = 0;
                                                                @endphp
                                                                <h4 class="card-title">{{ $us->name }}</h4>
                                                                <p class="card-text small">{{ $us->jabName }}</p>
                                                                <a href="{{ route('ManageUsers.show', $us->id) }}"
                                                                    class="btn btn-info">See Profile</a>
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
    {{-- modal tambah jabatan --}}
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Jabatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('add-jabatan.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="id_organisasi" value="{{ $organisasi->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jabatan">Nama Jabatan</label>
                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" required
                                name="jabatan" id="jabatan">
                            @error('jabatan')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">
                                Pilih Role
                            </label>
                            <select class="form-control" name="role" id="role" value="{{ old('role') }}">
                                <option selected>Pilih Role Jabatan
                                </option>
                                @forelse ($roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ $role->name_role }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
