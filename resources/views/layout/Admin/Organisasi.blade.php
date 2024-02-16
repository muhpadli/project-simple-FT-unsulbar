@extends('Master')
@section('title')
    Organisasi | FT Unsulbar
@endsection
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endsection
@section('sidebar')
    @include('layout.Admin.SidebarAdmin')
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Daftar Organisasi<span class="badge"><a href="{{ route('manageOrganization.store') }}"
                                class="btn btn-info btn-sm">
                                <i class="fas fa-plus-square"></i> Tambah Organisasi
                            </a></span></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Daftar Organisasi</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <div class="card-title">
                                Daftar Organisasi
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-striped " id="datatable">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 15px">No.</th>
                                        <th class="col-4">Nama Organisasi</th>
                                        <th class="col-3 text-center">Jumlah Jabatan</th>
                                        <th class="d-flex justify-content-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr class="align-item-center">
                                            <td class="text-center" style="width: 15px">{{ $loop->index + 1 }}</td>
                                            <td class="col-4">{{ $item->name }}</td>
                                            <td class="col-3 text-center">
                                                {{ $item->jabatans->where('organisasi_id', '=', $item->id)->count() }}
                                            </td>
                                            <td class="d-flex justify-content-center align-items-center">
                                                <div class="badge bg-primary mr-2 p-1">
                                                    <a href="{{ route('viewJabatan', $item->id) }}">
                                                        <i class="fas fa-eye mr-1"></i>view
                                                    </a>
                                                </div>
                                                <div class="badge bg-info mr-2 p-1">
                                                    <a href="{{ route('manageOrganization.edit', $item->id) }}">
                                                        <i class="fas fa-edit mr-1"></i>edit
                                                    </a>
                                                </div>
                                                <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                    action="{{ route('manageOrganization.destroy', $item->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="badge bg-danger d-flex mr-2 p-1"
                                                        style="border: none"><i class="fas fa-trash-alt mr-2"></i> Remove
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
