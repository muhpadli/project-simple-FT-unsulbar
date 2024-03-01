@extends('Master')
@section('title')
    Detail Tugas | FT Unsulbar
@endsection
@section('head')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
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
                        <div class="card-header d-flex justify-content-space-beween">
                            <div class="col-11">
                                <h5>{{ $task->title_task }}</h5>
                                <p class="small" style="margin: 0; line-height: 5px;">created by :
                                    {{ $task->name_user }} /
                                    {{ $task->name_jabatan }}</p>
                            </div>
                            <div class="col-1">
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
                        <!-- /.card-header -->
                        <div class="card-body p-3 ml-3">
                            <h5 style="margin: 0; border-bottom: 1px solid rgba(0,0,0,0.2)" class="pb-2">Deskripsi</h5>
                            <p style="text-align: justify">{{ $task->deksripsi }}</p>
                            @if ($task->keterangan)
                                <p class="small">Catatan : {{ $task->keterangan }}</p>
                            @endif

                            <div class="mt-3 ">
                                @if ($task->name_status == 'register')
                                    {{-- aksi saat status masih register --}}
                                    <div class="" style="display: inline-flex">
                                        <form action="{{ route('pending_tugas', $task->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-warning mr-2">Pending</button>
                                        </form>
                                        <form action="{{ route('start_working_task', $task->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary">Start Working</button>
                                        </form>
                                    </div>
                                @elseif ($task->name_status == 'on progres')
                                    <form action="{{ route('riwayat_tugas.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="tugas_id" value="{{ $task->id }}">
                                        <div class="form-group">
                                            <label for="taskDescription" class="form-label">Link Google Drive</label>
                                            <input class="form-control @error('link_tugas') is-invalid @enderror "
                                                id="link_tugas" name="link_tugas" placeholder="Link Google Drive" required>
                                            @error('link_tugas')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Isi Keterangan</label>
                                            <textarea class="form-control @error('content') is-invalid @enderror" id="editor" name="content" rows="5"
                                                placeholder="Tambahkan keterangan (opsional)"></textarea>

                                            <!-- error message untuk content -->
                                            @error('content')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-info mt-3">Submit Tugas</button>
                                    </form>
                                @elseif ($task->name_status == 'pending')
                                    <a href="" class="btn btn-primary">Start Working</a>
                                @else
                                    <div class=""></div>
                                @endif
                            </div>
                            <h5 class="mt-3" style="border-bottom: 1px solid rgba(0,0,0,0.2)">Detail Submitted</h5>
                            <div class="col-md-12">
                                <table class=" table table-striped table-bordered ml-0 ">
                                    <tbody>
                                        <tr>
                                            <td class="col-3">Link Tugas</td>
                                            <td class="col-9">
                                                @if ($task->name_status === 'register' || $task->name_status === 'on progres' || $task->name_status == 'pending')
                                                    {{ 'belum ada' }}
                                                @else
                                                    {{ $tugas_terkirim->link_tugas }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">Status</td>
                                            <td class="col-9">
                                                {{ $task->name_status }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">Tanggal Dimulai</td>
                                            <td class="col-9">
                                                @if ($task->name_status == 'register' || $task->name_status == 'pending')
                                                    {{ 'belum dimulai' }}
                                                @else
                                                    {{ $task->date_start }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">Tanggal Selesai</td>
                                            <td class="col-9">
                                                @if ($task->name_status == 'finish' || $task->name_status == 'accepted')
                                                    {{ $tugas_terkirim->waktu_selesai }}
                                                @else
                                                    {{ 'belum selesai' }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#myTable');
    </script>
@endsection
