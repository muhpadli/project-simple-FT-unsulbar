@extends('Master')
@section('title')
    Detail Task | FT Unsulbar
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
                    <h1>Detail Task</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('user_staf.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('details-tugas-staf') }}">My Tasks</a></li>
                        <li class="breadcrumb-item active">Detail Task</li>
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
                        <div class="card-header">
                            <div class="col-12">
                                <h5 style="font-weight: 700">{{ $task->title_task }}</h5>
                                <p class="small" style="margin: 0; line-height: 5px;">created by :
                                    {{ $task->name_user }} /
                                    {{ $task->name_jabatan }}
                                </p>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-3 ml-3">
                            <h5 style="margin: 0; border-bottom: 1px solid rgba(0,0,0,0.2); font-weight: 700"
                                class="pb-2">Description</h5>
                            <p style="text-align: justify">{!! $task->deksripsi !!}</p>
                            @if ($task->keterangan)
                                <p class="small">Note : {{ $task->keterangan }}</p>
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
                                            <button type="submit" class="btn btn-primary">Register</button>
                                        </form>
                                    </div>
                                @elseif ($task->name_status == 'on progres' || $task->name_status == 'revisi')
                                    <form action="{{ route('riwayat_tugas.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="tugas_id" value="{{ $task->id }}">
                                        <div class="form-group">
                                            <label for="taskDescription" class="form-label">Link Drive Task</label>
                                            <input class="form-control @error('link_tugas') is-invalid @enderror "
                                                id="link_tugas" name="link_tugas" placeholder="Link Google Drive" required>
                                            @error('link_tugas')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Description Link Task</label>
                                            <textarea class="form-control @error('content') is-invalid @enderror" id="editor" name="keterangan" rows="5"
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
                                    <form action="{{ route('start_working_task', $task->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary">Register</button>
                                    </form>
                                @endif
                            </div>
                            <h5 class="mt-3" style="border-bottom: 1px solid rgba(0,0,0,0.2); font-weight: 700">Submission
                                Status</h5>
                            <div class="col-md-12">
                                {{-- alert by status --}}
                                @if ($task->name_status == 'finish')
                                    <div class="alert alert-info d-flex align-items-center">
                                        <div><i class="fas fa-exclamation-circle mr-2"></i></div>
                                        <div>Submission Not Validated</div>
                                    </div>
                                @elseif ($task->name_status == 'accepted')
                                    <div class="alert alert-success d-flex align-items-center">
                                        <div><i class="fas fa-check-circle mr-2"></i></div>
                                        <div>Submission Was Approved</div>
                                    </div>
                                @elseif ($task->name_status == 'revisi')
                                    <div class="alert alert-warning d-flex align-items-center">
                                        <div><i class="fas fa-exclamation-circle mr-2"></i></div>
                                        <div>submission needs to be revised</div>
                                    </div>
                                @endif
                                <table class=" table table-striped table-bordered table-hover ml-0 ">
                                    <tbody>
                                        <tr>
                                            <th class="col-3">Submission Status</th>
                                            <td class="col-9">
                                                {{ Str::ucfirst($task->name_status) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="col-3">Submission Priority</th>
                                            <td class="col-9">
                                                {{ Str::ucfirst($task->name) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="col-3">Date Started</th>
                                            <td class="col-9">
                                                @if ($task->name_status == 'register' || $task->name_status == 'pending')
                                                    {{ 'Not Started' }}
                                                @else
                                                    {{ $task->date_start }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="col-3">Due Date</th>
                                            <td class="col-9">
                                                @if ($task->name_status == 'finish' || $task->name_status == 'accepted')
                                                    {{ $tugas_terkirim->waktu_selesai }}
                                                @else
                                                    {{ 'Not Completed' }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="col-3">Link Task</th>
                                            <td class="col-9">
                                                @if ($task->name_status === 'register' || $task->name_status === 'on progres' || $task->name_status == 'pending')
                                                    {{ 'Not Link Task' }}
                                                @else
                                                    {{ $tugas_terkirim->link_tugas }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="col-3">Description Link Task</th>
                                            <td class="col-9">
                                                @if ($task->name_status == 'finish' || $task->name_status == 'accepted')
                                                    {!! $tugas_terkirim->keterangan !!}
                                                @else
                                                    {{ '-' }}
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($task->name_status == 'revisi')
                                            <tr>
                                                <th class="col-3">Revision</th>
                                                <td class="col-9">{!! $tugas_terkirim->revision !!}</td>
                                            </tr>
                                        @endif
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
