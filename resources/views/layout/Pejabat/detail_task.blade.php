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
                    <h1>Detail Task <span class="badge"><a href="{{ route('DetailTask.edit', $task->id) }}"
                                class="btn btn-info btn-sm "> <i class="fa fa-edit"></i> Edit</a></span></h1>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashoard-pimpinan') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard_pejabat.index') }}">List Tasks</a></li>
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
                            <div class="col-12 ">
                                <h5 style="font-weight: 700" class="ml-0">{{ $task->title_task }}</h5>
                                <div>
                                    <p class="small" style="margin: 0; line-height: 5px;">Author Staff by :
                                        {{ $task->name_user }}/
                                        {{ $task->name_jabatan }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body ">
                            <h5 class="subtitle pb-2" style="border-bottom: 1px solid rgba(0, 0, 0, 0.2); font-weight: 600">
                                Description
                            </h5>
                            <p class="ml-2">{!! $task->deksripsi !!}</p>
                            @if ($task->keterangan)
                                <p class="small pl-2 pt-0">Note : {{ $task->keterangan }}</p>
                            @endif
                            <div class="submitted">
                                <h5 class=" pb-2" style="border-bottom: 1px solid rgba(0,0,0,0.2); font-weight: 700">
                                    Submission status
                                </h5>
                                <table class="table table-bordered table-striped table-hover">
                                    <tr>
                                        <th class="col-3">Submission Status</th>
                                        <td class="col-9">{{ Str::ucfirst($task->name_status) }}</td>
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
                                            <td class="col-9"><a
                                                    href="{{ $tugas_terkirim->link_tugas }}">{{ $tugas_terkirim->link_tugas }}</a>
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
@endsection
