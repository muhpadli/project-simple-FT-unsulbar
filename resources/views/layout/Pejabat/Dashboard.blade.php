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
    Dashboard | SIMPLE
@endsection
@section('head')
    <style>
        .jabatan {
            background-position: center;
            background-size: cover;
            height: 62px;
            margin: 0
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
            @if ($level_user_id->tingkat > 1)
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-outline col-md-12">
                            <div class="card-body">
                                {!! $myTaskChart->container() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            @for ($i = 0; $i < count($icon); $i++)
                                <div class="col-md-6">
                                    <div class="info-box shadow-small">
                                        <span class="info-box-icon bg-{{ $color[$i] }}"><i
                                                class="fa {{ $icon[$i] }}"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ $title_tugas[$i] }}</span>
                                            <span class="info-box-number"><a
                                                    href="{{ route('detail-where-staus', $i + 1) }}"
                                                    style="color: black">{{ auth()->user()->tasks->where('status_id', '=', $i + 1)->count() }}</a></span>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-outline">
                        <div class="card-body">
                            {!! $taskDutiesChart->container() !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        @foreach ($dutiesName as $key => $item)
                            <div class="col-md-6">
                                <div class="info-box shadow-small">
                                    @if (!empty($item->image))
                                        <span class="info-box-icon shadow jabatan p-0 m-0"
                                            style="background-image: url({{ asset('storage/' . $item->image) }})">
                                        </span>
                                    @else
                                        <span class="info-box-icon shadow bg-info  p-0 m-0">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    @endif

                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ $item->name }} / {{ $name_jabatan[$key] }}</span>
                                        <span class="info-box-number"><a href="{{ route('getTask-byStaff', $item->id) }}"
                                                style="color: black">{{ $sumTask[$key] }}</a></span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ $myTaskChart->cdn() }}"></script>
    {{ $myTaskChart->script() }}
    <script src="{{ $taskDutiesChart->cdn() }}"></script>
    {{ $taskDutiesChart->script() }}
@endsection
