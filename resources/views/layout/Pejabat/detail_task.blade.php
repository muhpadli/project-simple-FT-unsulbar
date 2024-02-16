@extends('Master')
@section('title')
    Detail Task | FT Unsulbar
@endsection
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endsection
@section('sidebar')
    @include('layout.Sidebar')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Tugas <span class="badge"><a href="{{ route('DetailTask.edit', $task->id) }}"
                                class="btn btn-info btn-sm "> <i class="fa fa-edit"></i> Edit</a></span></h1>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashoard-pimpinan') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard_pejabat.index') }}">Daftar Tugas</a></li>
                        <li class="breadcrumb-item active">Detail Tugas</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Content Wrapper. Contains page content -->


    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-info">
                        <div class="card-header d-flex justify-content-between">
                            <div class="col-md-6">
                                <div class="card-title">{{ $task->title_task }}
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                <span
                                    class="badge badge-pill bg-{{ $task->bg_warna }} p-2 pr-3 pl-3">{{ $task->name_status }}</span>

                                <span class="ml-2">Priority : {{ $task->name }}</span>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body ">
                            <p class="pl-2">
                                {{ $task->deksripsi }}
                            </p>
                            @if ($task->keterangan)
                                <p class="small pl-2 pt-0">Catatan : {{ $task->keterangan }}</p>
                            @endif

                        </div>
                        <div class="card-footer d-md-flex justify-content-between">
                            <div class="col-md-6">
                                <p class="mb-0 small">
                                    Nama/jabatan: {{ $task->name_user }}/ {{ $task->name_jabatan }}<br>
                                    @php
                                        if ($task->name == $priority->name) {
                                            echo 'Date Started : -';
                                        } else {
                                            echo 'Date Started : ' . $task->date_start;
                                        }
                                    @endphp
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <div class="card-title">Tugas diserahkan
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped " id="datatable">
                                <thead>
                                    <tr>
                                        <th class="col-2">Link Tugas</th>
                                        <th class="col-7">Waktu Selesai</th>
                                        <th class="col-3 text-center">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tugas_terkirim as $item)
                                        <tr>
                                            <td class="col-2"><a href="">{{ $item->link_tugas }}</a></td>
                                            <td class="col-7">{{ $item->waktu_selesai }}</td>
                                            <td class="col-3">
                                                <div class="d-flex justify-content-center mt-2">
                                                    <div class="dropdown">
                                                        <button class="btn p-1 btn-xs" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenuButton">
                                                            @foreach ($status as $item)
                                                                <form
                                                                    action="{{ route('dashboard_pejabat.update', $task->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" value="{{ $item->id }}"
                                                                        name="status_id">
                                                                    <button type="submit"
                                                                        class="dropdown-item">{{ $item->name_status }}
                                                                        @if ($loop->index < 2)
                                                                            <div class="dropdown-divider"></div>
                                                                        @endif
                                                                    </button>
                                                                </form>
                                                            @endforeach
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
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
