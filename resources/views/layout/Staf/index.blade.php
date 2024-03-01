@extends('Master')
@section('title')
    Dashboard Staf | FT Unsulbar
@endsection
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <style>
        .card-header ul {
            margin: 0;
            padding-left: 0;
        }

        .card-header ul li {
            list-style: none;
            display: inline-block;
            margin-right: 10px;
        }
    </style>
@endsection
@section('sidebar')
    @include('layout.Sidebar')
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Tugas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('user_staf.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item active">Daftar Tugas</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-info ">
                        <!-- /.card-header -->
                        <div class="card-header">
                            <ul>
                                @foreach ($prioritas_status as $item)
                                    <li>
                                        <div class="text-{{ $item->bg_color }}"><i class="fas fa-square"></i>
                                            <span style="color: black">{{ Str::ucfirst($item->name_status) }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-body ">
                            <table class="table table-striped table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul</th>
                                        <th>Deksripsi</th>
                                        <th>Tugas dari</th>
                                        <th>Prioritas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($task as $item)
                                        {{-- table row --}}
                                        <tr>
                                            {{-- table data --}}
                                            <td>
                                                <span class="text-{{ $item->bg_color }}">
                                                    <i class="fas fa-square"></i>
                                                </span>
                                            </td>
                                            <td>{{ $item->title_task }}</td>
                                            <td>{{ $item->excerpt }}</td>
                                            <td>{{ $item->department_name }}</td>
                                            <td><span class="badge bg-{{ $item->bg_warna }} p-1"
                                                    style="width: 75px;">{{ $item->name }}</span></td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <div class="dropdown">
                                                        <button class="btn p-1 btn-xs" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item"
                                                                href="{{ route('user_staf.show', $item->id) }}">
                                                                <i class="fas fa-info-circle mr-2"></i> Detail
                                                            </a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                                data-target="#hapusModal{{ $item->id }}">
                                                                <i class="fas fa-trash-alt mr-2"></i> Hapus
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal untuk konfirmasi penghapusan -->
                                                <div class="modal fade" id="hapusModal{{ $item->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="hapusModalLabel{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="hapusModalLabel{{ $item->id }}">Konfirmasi
                                                                    Penghapusan</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus data ini?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Batal</button>
                                                                <!-- Tambahkan form untuk melakukan penghapusan dengan method DELETE -->
                                                                <form action="{{ route('DetailTask.destroy', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#myTable');
    </script>
@endsection
