@extends('Master')
@section('title')
    User | FT Unsulbar
@endsection
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Pegawai</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Daftar Pegawai</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <a class="btn btn-info btn-sm mr-1" href="{{ route('pegawai.create') }}" title="tambah user">
                        <i class="fas fa-plus-square"></i>
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Jabatan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr onclick="return {{ route('pegawai.show', $user->id) }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->NIP }}</td>
                                    <td>{{ $user->nama_jabatan }}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('pegawai.show', $user->id) }}" class="btn btn-sm bg-cyan mr-2">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form
                                            onsubmit="return confirm('Apakah anda yakin ingin menghapus user? \nsemua data terkait user tersebut akan ikut terhapus.') "
                                            action="{{ route('pegawai.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm  bg-danger" style="border: none">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
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
