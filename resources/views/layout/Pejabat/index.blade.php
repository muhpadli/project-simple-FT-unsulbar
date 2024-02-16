@extends('Master')
@section('title')
    Dashboard Pejabat | FT Unsulbar
@endsection
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endsection
@section('sidebar')
    @include('layout.Sidebar')
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1>Daftar Tugas
                        <span class="badge"><a href="{{ route('DetailTask.create') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-plus-square"></i> Buat Tugas
                            </a></span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashoard-pimpinan') }}">Beranda</a></li>
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
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="datatable">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No.</th>
                                            <th>Judul tugas</th>
                                            <th>Deskripsi</th>
                                            <th>Organisasi</th>
                                            <th class="text-center">status</th>
                                            <th class="text-center">Prioritas</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($task as $key => $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $item->title_task }}</td>
                                                <td><span>{{ $item->excerpt }}</span>
                                                </td>
                                                <td><span>{{ $item->department }}</span></td>
                                                <td><span
                                                        class="badge bg-{{ $item->bg_color }} align-item-center float-center p-2"
                                                        style="width: 75px">{{ $item->name_status }}</span>
                                                </td>
                                                <td class="d-flex">
                                                    <span><span class="badge bg-{{ $item->bg_warna }} p-2"
                                                            style="width: 75px">{{ $item->name }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center mt-2">
                                                        <div class="dropdown">
                                                            <button class="btn p-1 btn-xs" type="button"
                                                                id="dropdownMenuButton" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-h"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right"
                                                                aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('DetailTask.show', $item->id) }}">
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
                                                    <div class="modal fade" id="hapusModal{{ $item->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="hapusModalLabel{{ $item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="hapusModalLabel{{ $item->id }}">Konfirmasi
                                                                        Penghapusan</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
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
                                                                    <form
                                                                        action="{{ route('DetailTask.destroy', $item->id) }}"
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
        new DataTable('#datatable');
    </script>
@endsection
