@extends('Master')
@section('title')
    New Task | SIMPLE
@endsection
@section('head')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
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
                    <h1>New Task</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/users') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/users/task-duties') }}">Task Duties</a></li>
                        <li class="breadcrumb-item active">New Task</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Content Wrapper. Contains page content -->


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-info">
                        <form action="{{ route('DetailTask.store') }}" id="frm" method="post">
                            @csrf
                            <div class="card-body row">
                                <div class="col">
                                    <div class="form-group">
                                        @if ($level_user_id->tingkat < 5)
                                            <div class="col"> <!-- Tambahkan kelas mb-0 di sini -->
                                                <label class="col-form-label">Select
                                                    Department</label>
                                                <select class="form-control" id="department" name="department">
                                                    <option>Select Organization</option>
                                                    @foreach ($department as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            <input type="hidden" name="department" id="department"
                                                value="{{ $position->organisasi_id }}">
                                        @endif
                                        <div class="col">
                                            <label class="col-form-label">Select Position</label>
                                            <select class="form-control" id="sub_department" name="sub_department">
                                                <option>Select Position</option>
                                                @if ($level_user_id->tingkat == 5)
                                                    @foreach ($jabatan->where('organisasi_id', '=', $position->organisasi_id) as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                @else
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="col-form-label">Select User</label>
                                            <select class="form-control" id="user_id" name="user_id">
                                                <option>Select User</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="col-form-label">Priority</label>
                                            <select class="form-control" id="priority_id" name="priority_id">
                                                <option>Select Priority</option>
                                                @foreach ($priority as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="col" id="keterangan">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <div class="col">
                                            <label for="title" class="col-form-label">Title
                                                Task</label>
                                            <input type="text"
                                                class="form-control @error('title_task') is-invalid @enderror"
                                                name="title_task" id="title_task" placeholder="Enter your Title Task">
                                            @error('title_task')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <label for="deksripsi" class="col-form-label">Description</label>
                                            <textarea class="form-control  @error('deskripsi') is-invalid @enderror" name="deksripsi" id="editor" rows="6"
                                                placeholder="Enter your Description"></textarea>
                                            @error('deskripsi')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col my-3 text-right">
                                            <button type="reset"
                                                class="btn btn-rounded btn-secondary btn-sm">Reset</button>
                                            <button type="submit" class="btn btn-rounded btn-info btn-sm">Tugaskan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $('#department').on('change', function() {
                var departmentID = $(this).val();
                // console.log(organisasiID);
                if (departmentID) {
                    $.ajax({
                        url: '/users/task-duties/get-jabatan/' + departmentID,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data);
                            if (data) {
                                $('#sub_department').empty();
                                $('#user_id').empty();
                                $('#sub_department').append(
                                    '<option>Select Position</option>');
                                $('#user_id').append(
                                    '<option>Select User</option>');
                                $.each(data, function(key, sub_department) {
                                    $('select[name="sub_department"]').append(
                                        '<option value="' + sub_department.id +
                                        '">' +
                                        sub_department.name + '</option>'
                                    )
                                });
                            } else {}
                        }
                    });
                } else {

                }
            });
        });

        $(document).ready(function() {
            $('#sub_department').on('change', function() {
                var sub_departmentID = $(this).val();
                // console.log(organisasiID);
                if (sub_departmentID) {
                    $.ajax({
                        url: '/users/task-duties/get-user/' + sub_departmentID,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data);
                            if (data) {
                                $('#user_id').empty();
                                $('#user_id').append(
                                    '<option>Select User</option>');
                                $.each(data, function(key, user) {
                                    $('select[name="user_id"]').append(
                                        '<option value="' + user.id + '">' +
                                        user.name + '</option>'
                                    )
                                });
                            } else {}
                        }
                    });
                } else {

                }
            });
        });

        $(document).ready(function() {
            $('#priority_id').on('change', function() {
                var priorityID = $(this).val();
                if (priorityID == 4) {
                    $('#keterangan').empty();
                    $('#keterangan').append(
                        '<label for="catatan" class="col-form-label">Note</label>');
                    $('#keterangan').append(
                        '<input type="text" class="form-control" name="keterangan" id="note">'
                    );
                } else {
                    $('#keterangan').empty();
                }
            });
        });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
