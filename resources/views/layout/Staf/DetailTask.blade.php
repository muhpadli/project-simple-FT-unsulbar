@extends('Master')
@section('title')
    Detail Tugas | FT Unsulbar
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
                    <h1>Detail Tugas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('user_staf.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('details-tugas-staf') }}">Daftar Tugas</a></li>
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
                        <div class="card-header d-flex">
                            <div class="col-md-6 align-items-center">
                                <div class="card-title">
                                    <h5>{{ $task->title_task }}</h5>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end  align-items-center">
                                <span
                                    class="badge badge-pill bg-{{ $task->bg_color }} p-2 pl-3 pr-3">{{ $task->name_status }}</span>
                                <span class="ml-2">Priority: {{ $task->name }}</span>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-3 ml-3">
                            {{ $task->deksripsi }}
                            @if ($task->keterangan)
                                <p class="small">Catatan : {{ $task->keterangan }}</p>
                            @endif

                        </div>

                        <div class="card-footer d-flex">
                            <div class="col-md-6">
                                Nama Pimpinan / Jabatan: {{ $task->name_user }} / {{ $task->name_jabatan }}<br>
                                @php
                                    if ($task->name == $priority->name) {
                                        echo 'Tanggal dimulai : -';
                                    } else {
                                        echo 'Tanggal dimulai : ' . $task->date_start;
                                    }
                                @endphp
                            </div>
                            <div class="col-md-6  d-flex justify-content-end align-items-center">
                                <div class="dropdown">
                                    <button class="btn p-1 btn-sm" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        style="color: blue">
                                        ubah status
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        @foreach ($status as $item)
                                            <form action="{{ route('user_staf.update', $task->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" value="{{ $item->id }}" name="status_id">
                                                <button type="submit" class="dropdown-item">{{ $item->name_status }}
                                                    @if ($loop->index < 2)
                                                        <div class="dropdown-divider"></div>
                                                    @endif
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"><!-- /.card-body -->
                            <div class="card card-outline card-info">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">Kirim Tugas</h4>
                                </div>
                                <!-- /.card-header -->
                                <form action="{{ route('riwayat_tugas.store') }}" method="post">
                                    @csrf
                                    <div class="card-body p-3">
                                        <div class="mb-3">
                                            <input type="hidden" name="tugas_id" value="{{ $task->id }}">
                                            <label for="taskDescription" class="form-label">Link Google Drive</label>
                                            <input
                                                class="form-control @error('linnk_tugas') is-invalid                                        
                                        @enderror"
                                                id="link_tugas" name="link_tugas" placeholder="Link Google Drive"
                                                {{ $task->name_status == 'register' ? 'disabled' : '' }} required
                                                autofocus>
                                            @error('link_tugas')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-info float-right">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-6">

                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h4 class="card-title">Riwayat Tugas Terkirim</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered" id="myTable">
                                        <thead>
                                            <tr>
                                                <th class="col-4">Link Tugas</th>
                                                <th class="col-6">Waktu Selesai</th>
                                                <th class="col-2 text-center">action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($tugas_terkirim as $item)
                                                <tr>
                                                    <td class="col-4"><a href="">{{ $item->link_tugas }}</a></td>
                                                    <td class="col-6">{{ $item->waktu_selesai }}</td>
                                                    <td class="col-4">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="dropdown">
                                                                <button class="btn btn-xs" type="button"
                                                                    id="dropdownMenuButton" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right"
                                                                    aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item" href=" ">
                                                                        <i class="fas fa-info-circle mr-2"></i> Detail
                                                                    </a>
                                                                    <a class="dropdown-item" href="#"
                                                                        data-toggle="modal"
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
                                                                            id="hapusModalLabel{{ $item->id }}">
                                                                            Konfirmasi
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
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
        new DataTable('#myTable');
    </script>
@endsection
