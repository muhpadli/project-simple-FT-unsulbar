@php
    $icon = ['fa-hourglass-start', 'fa-spinner', 'fa-step-forward', 'fa-pen-fancy', 'fa-check', 'fa-check-circle'];
    $color = ['maroon', 'info', 'gray-dark', 'warning', 'olive', 'primary'];
    $title_tugas = ['Tugas di-register', 'Tugas on-Progres', 'Tugas di-pending', 'Tugas di-revisi', 'Tugas di-selesaikan', 'Tugas di-terima'];
@endphp

@extends('Master')
@section('title')
    Dashboard Pimpinan| FT Unsulbar
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
                    <h1>Beranda</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Beranda</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Content Wrapper. Contains page content -->


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
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
    </section>
@endsection
