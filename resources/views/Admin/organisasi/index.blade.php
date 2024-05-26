@extends('Master')
@section('title')
    Organisasi | FT Unsulbar
@endsection
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Daftar Organisasi</h1>
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
                        <div class="card-header d-flex">
                            <a href="{{ route('organisasi.create') }}" class="btn btn-info btn-sm mr-1">
                                <i class="fas fa-plus-square"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover" id="datatable">
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
                                                <div class="btn btn-sm bg-primary mr-2">
                                                    <a href="{{ url('users/organisasi/jabatan', $item->id) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                                <div class="btn btn-sm bg-info mr-2">
                                                    <a href="{{ route('organisasi.edit', $item->id) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                                <form
                                                    onsubmit="return confirm('Semua data jabatan dan user yang terkait dengan organisasi ini akan ikut terhapus. Apakah Anda Yakin ?');"
                                                    action="{{ route('organisasi.destroy', $item->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm bg-danger mr-2"
                                                        style="border: none"><i class="fas fa-trash-alt"></i>
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
