@extends('Master')
@section('title')
    Manage User | FT Unsulbar
@endsection
@section('sidebar')
    @include('layout.Admin.SidebarAdmin')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar User
                        <span class="badge"><a href="{{ route('ManageUsers.create') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-plus-square"></i> Tambah User
                            </a>
                        </span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Daftar User</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @foreach ($users as $us)
                    <div class="col-md-2">
                        <div class="card">
                            <div style="height: 220px; overflow:hidden;">
                                @if ($us->image)
                                    <img class="card-img-top" style="height: 220px"
                                        src="{{ asset('storage/' . $us->image) }}" alt="Card image">
                                @else
                                    <img class="card-img-top" style="height: 220px"
                                        src="https://source.unsplash.com/400x600/?user" alt="Card image">
                                @endif
                            </div>
                            <div class="card-body">
                                @php
                                    $k = 0;
                                @endphp
                                <h4 class="card-title">{{ $us->name }}</h4>
                                @foreach ($user as $use)
                                    @if ($us->jabatan_id == $use->jabId)
                                        <p class="card-text small">{{ $use->jabName }}</p>
                                        @php
                                            $k = 1;
                                            break;
                                        @endphp
                                    @endif
                                @endforeach
                                @if ($k == 0)
                                    <p class="card-text small">-</p>
                                @endif
                                <a href="{{ route('ManageUsers.show', $us->id) }}" class="btn btn-info">See Profile</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
