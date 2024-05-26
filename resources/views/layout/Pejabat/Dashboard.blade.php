@php
    $icon = ['fa-hourglass-start', 'fa-spinner', 'fa-step-forward', 'fa-pen-fancy', 'fa-check', 'fa-check-circle'];
    $color = ['maroon', 'info', 'gray-dark', 'warning', 'olive', 'primary'];
    $title_tugas = [
        'Tugas di-register',
        'Tugas on-Progres',
        'Tugas di-pending',
        'Tugas di-revisi',
        'Tugas di-selesaikan',
        'Tugas di-terima',
    ];
@endphp

@extends('Master')
@section('title')
    Dashboard Pimpinan| FT Unsulbar
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
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Content Wrapper. Contains page content -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <div class="card-title">
                        Task Duties By Status
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-md-start">
                        @for ($i = 0; $i < count($icon); $i++)
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box bg-gradient-{{ $color[$i] }}">
                                    <span class="info-box-icon"><i class="fa {{ $icon[$i] }}"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ $title_tugas[$i] }}</span>
                                        <span class="info-box-number"><a style="text-decoration: none; color: white"
                                                href="{{ route('get-task-by-status', $i + 1) }}">{{ $task->where('status_id', '=', $i + 1)->count() }}</a></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            @if ($level_user_id->tingkat > 1)
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <div class="card-title">
                            My Task By Status
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-md-start">
                            @for ($i = 0; $i < count($icon); $i++)
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="info-box bg-gradient-{{ $color[$i] }}">
                                        <span class="info-box-icon"><i class="fa {{ $icon[$i] }}"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ $title_tugas[$i] }}</span>
                                            <span class="info-box-number"><a style="text-decoration: none; color: white"
                                                    href="{{ route('detail-where-staus', $i + 1) }}">{{ auth()->user()->tasks->where('status_id', '=', $i + 1)->count() }}</a></span>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
