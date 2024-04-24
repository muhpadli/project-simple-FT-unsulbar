@php
    $icon = ['fa-hourglass-start', 'fa-spinner', 'fa-step-forward', 'fa-pen-fancy', 'fa-check', 'fa-check-circle'];
    $color = ['maroon', 'info', 'gray-dark', 'warning', 'olive', 'primary'];
    $title_tugas = ['Task Not Register', 'Task On-progress', 'Task Pending', 'Task Revised', 'Task Submitted', 'Task Approved'];
@endphp

@extends('Master')
@section('title')
    Dashboard | FT Unsulbar
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
        </div>
    </section>
@endsection
