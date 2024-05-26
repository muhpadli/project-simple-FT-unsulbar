@extends('Master')
@section('title')
    Detail Task | FT Unsulbar
@endsection
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
@endsection
@section('content')
    @php
        $user_id = auth()->user()->id;
        $level_user_id = DB::table('users')
            ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('level_users', 'level_users.id', '=', 'jabatans.level_users_id')
            ->select('level_users.tingkat')
            ->where('users.id', '=', $user_id)
            ->get()
            ->first();
    @endphp
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Task </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('users') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('users/task-duties') }}">Task Duties</a></li>
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
                        <div class="card-header " style="margin-bottom: 0; line-height: 5px">
                            <div class="header-left" style="float: left">
                                <h5 style="font-weight: 700" class="ml-0">{{ $task->title_task }}</h5>
                                <div>
                                    <p class="small" style="margin: 0; line-height: 5px;">Task for :
                                        {{ $task->name_user }}/
                                        {{ $task->name_jabatan }}</p>
                                </div>
                            </div>
                            @if ($task->name_status != 'accepted')
                                <div class="header-right" style="float: right">
                                    <div class="badge"><a href="{{ route('task-duties.edit', $task->id) }}"
                                            class="btn btn-info btn-sm "> <i class="fa fa-edit"></i> Edit</a></div>
                                </div>
                            @endif

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="detail_task">
                                <h5 class="subtitle pb-2"
                                    style="border-bottom: 1px solid rgba(0, 0, 0, 0.2); font-weight: 600">
                                    Description
                                </h5>
                                <p>{!! $task->deksripsi !!}</p>
                                @if ($task->keterangan)
                                    <p class="small pl-2 pt-0">Note : {{ $task->keterangan }}</p>
                                @endif
                            </div>
                            <div class="aksi-validasi d-flex">
                                @if ($task->name_status == 'finish')
                                    <form action="{{ route('accepted_task', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary mr-2">Accepted</button>
                                    </form>
                                    <form action="{{ route('revision_task') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="tugas_id" value="{{ $task->id }}">
                                        @if ($task->name_status == 'finish')
                                            <input type="hidden" name="riwayat_tugas_id"
                                                value="{{ $tugas_terkirim->id }}">
                                        @endif
                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                            data-target="#modal-default">Revision</button>
                                        {{-- modal revision --}}
                                        <div class="modal fade" id="modal-default">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Revision submissions</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="">Comment Revision</label>
                                                            <textarea name="revision" id="editor" cols="30" rows="10" placeholder="berikan komentar revisi"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Revision</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    </form>
                                @else
                                @endif
                            </div>
                            <div class="submitted mt-3">
                                <h5 class=" pb-2" style="border-bottom: 1px solid rgba(0,0,0,0.2); font-weight: 700">
                                    Submission status
                                </h5>
                                @if ($task->name_status == 'finish')
                                    <div class="alert alert-warning d-flex align-items-center">
                                        <div><i class="fas fa-exclamation-circle mr-2"></i></div>
                                        <div>Submission Not Validated</div>
                                    </div>
                                @elseif ($task->name_status == 'accepted')
                                    <div class="alert alert-success d-flex align-items-center">
                                        <div><i class="fas fa-check-circle mr-2"></i></div>
                                        <div>Submission Was Approved</div>
                                    </div>
                                @endif
                                <table class="table table-bordered table-striped table-hover">
                                    <tr>
                                        <th class="col-3">Submission Status</th>
                                        <td class="col-9">{{ Str::ucfirst($task->name_status) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-3">Submission Priority</th>
                                        <td class="col-9">{{ Str::ucfirst($task->name) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-3">Date Started</th>
                                        @if ($task->name_status == 'register' || $task->name_status == 'pending')
                                            <td class="col-9">Not Started</td>
                                        @else
                                            <td class="col-9">{{ $task->date_start }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th class="col-3">Completed Time</th>
                                        @if ($task->name_status == 'finish' || $task->name_status == 'accepted')
                                            <td class="col-9">{{ $tugas_terkirim->waktu_selesai }}</td>
                                        @else
                                            <td class="col-9">Not Completed</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th class="col3">Link Task</th>
                                        @if ($task->name_status == 'finish' || $task->name_status == 'accepted')
                                            <td class="col-9"><a href="{{ $tugas_terkirim->link_tugas }}"
                                                    target="_blank">{{ $tugas_terkirim->link_tugas }}</a>
                                            </td>
                                        @else
                                            <td class="col-9">{{ 'Not Link Task' }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th class="col-3">Description Task</th>
                                        @if ($task->name_status == 'finish' || $task->name_status == 'accepted')
                                            <td class="col-9">{!! $tugas_terkirim->keterangan !!}</td>
                                        @else
                                            <td class="col-9">{{ 'Not Link Task' }}</td>
                                        @endif
                                    </tr>

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
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#datatable');
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
