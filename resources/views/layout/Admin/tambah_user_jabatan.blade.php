@extends('Master')
@section('title')
    Manage Organization | FT Unsulbar
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
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
                    <h1>Tambah User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('organisasi') }}">Daftar Organisasi</a></li>
                        <li class="breadcrumb-item active">
                            {{ $organisasi[$jabatan->organisasi_id - 1]->name }}
                        </li>
                        <li class="breadcrumb-item active">{{ $jabatan->name }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            Pilihlah user dibawah
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive mailbox-messages p-0">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                        @forelse ($users as $user)
                                            <tr class="align-self-center">
                                                <td style="width: 5rem">
                                                    <div class="icheck-primary ">
                                                        <input type="checkbox" value="{{ $user->id }}"
                                                            id="check{{ $loop->index + 1 }}">
                                                        <label for="check{{ $loop->index + 1 }}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($user->image)
                                                        <div class="image rounded elevation-1" style="max-width: 50px">
                                                            <img src="{{ asset('storage/' . $user->image) }}" height="60px"
                                                                width="50px" alt="">
                                                        </div>
                                                    @else
                                                        <div class="image rounded elevation-1" style="max-width: 50px">
                                                            <img src="https://source.unsplash.com/400x600/?user"
                                                                height="60px" width="50px" alt="">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="mailbox-name ">
                                                    <p>{{ $user->name }}</p>
                                                </td>
                                                <td class="mailbox-subject">{{ $user->email }}
                                                </td>
                                                <td class="mailbox-subject">{{ $user->alamat }}
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
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
