@extends('Master')
@section('title')
    Task Duties | SIMPLE
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
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1>Task Duties</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/users') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Task Duties</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="card card-outline card-info">
                        <!-- /.card-header -->
                        <div class="card-header">
                            <div class="left-header" style="float: left">
                                <ul>
                                    @foreach ($prioritas_tugas as $item)
                                        <li>
                                            <div class="text-{{ $item->bg_color }}"><i class="fas fa-square"></i>
                                                <span style="color: black">{{ Str::ucfirst($item->name) }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="right-header" style="float: right">
                                <div class="badge"><a href="{{ route('task-duties.create') }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-plus-square"></i> New Task
                                    </a></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" class="display" id="datatable">
                                    <thead>
                                        <tr>
                                            <th class="d-flex justify-content-center">Priority</th>
                                            <th>Title</th>
                                            <th>Task For</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($task as $key => $item)
                                            <tr>
                                                <td>
                                                    <span class="text-{{ $item->bg_warna }} d-flex justify-content-center">
                                                        <i class="fas fa-square"></i>
                                                    </span>
                                                </td>
                                                <td>{{ $item->title_task }}</td>
                                                </td>
                                                <td><span>{{ $item->nameUser }}</span></td>
                                                <td><span
                                                        class="badge bg-{{ $item->bg_color }} btn-sm align-item-center float-center p-1"
                                                        style="width: 75px">{{ $item->name_status }}</span>
                                                </td>
                                                <td>
                                                    <a class="badge badge-info btn-sm"
                                                        href="{{ route('task-duties.show', $item->id) }}">
                                                        <i class="fas fa-eye mr-1"></i>View
                                                    </a>
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
                <div class="col-md-3">
                    <div class="card card-outline card-info p-2">
                        <div class="card-header">
                            <div class="card-title"><i class="fa fa-filter"></i>FILTER</div>
                        </div>

                        <div class="card-body">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                                data-accordion="false">
                                <li class="nav-item {{ $open === 'filter-priority' ? 'menu-open' : ' ' }}">
                                    <a href=""
                                        class="nav nav-link {{ $open === 'filter-priority' ? 'active' : '' }}"
                                        style="font-weight: bold;">
                                        Priority <i class="right fas fa-angle-left"></i>
                                    </a>
                                    <ul class="nav nav-treeview"
                                        style="list-style-type: none; margin-left: 0; padding-left: 0; line-height: 0.2em">
                                        @foreach ($prioritas_tugas as $key => $item)
                                            <li>
                                                <a href="{{ route('get-task-by-priority', $key + 1) }}"
                                                    class="nav-link small ">
                                                    <span style="display: flexbox; justify-content: center;">
                                                        <p class="text-dark">{{ Str::ucfirst($item->name) }} @if ($priority === Str::lower($item->name))
                                                                <i class=' fa fa-check-circle'></i>
                                                            @endif
                                                        </p>
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="nav-item  {{ $open === 'filter-status' ? 'menu-open' : ' ' }}">
                                    <a href="" class="nav-link {{ $open === 'filter-status' ? 'active' : '' }}"
                                        style="font-weight: bold;">
                                        status
                                        <i class="right fas fa-angle-left"></i>
                                    </a>
                                    <ul class="nav nav-treeview"
                                        style="list-style-type: none; margin-left: 0; padding-left: 0; line-height: 0.2em">
                                        @foreach ($prioritas_status as $key => $item)
                                            <li>
                                                <a href="{{ route('get-task-by-status', $key + 1) }}"
                                                    class="nav-link small">
                                                    <span style="display: flexbox; justify-content: center;">
                                                        <p class="text-dark">{{ Str::ucfirst($item->name_status) }}
                                                            @if ($priority === $item->name_status)
                                                                <i class='fa fa-check-circle'></i>
                                                            @endif
                                                        </p>
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
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
