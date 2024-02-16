@extends('Master')
@section('title')
    Edit Tugas| FT Unsulbar
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
                    <h1>Edit Tugas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashoard-pimpinan') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard_pejabat.index') }}">Daftar Tugas</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('DetailTask.show', $task->id) }}">Detail Tugas</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Tugas</li>
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
                        <form action="{{ route('DetailTask.update', $task->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="col"> <!-- Tambahkan kelas mb-0 di sini -->
                                            <label class="col-form-label">Pilih
                                                Organisasi</label>
                                            <select class="form-control" id="department" name="department">
                                                <option>Pilih Organisasi</option>
                                                @foreach ($department as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $task->id_departement ? 'selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="col-form-label">Pilih Jabatan</label>
                                            <select class="form-control" id="sub_department" name="sub_department">
                                                <option>Pilih Jabatan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="col">
                                                <label class="col-form-label">Pilih User</label>
                                                <select class="form-control" id="user_id" name="user_id">
                                                    <option>pilih User</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col">
                                                <label class="col-form-label">Prioritas</label>
                                                <select class="form-control" id="priority_id" name="priority_id">
                                                    <option>Pilih Prioritas</option>
                                                    @foreach ($priority as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $item->id == $task->id_prioritas ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
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
                                            <label for="title" class="col-form-label">Judul Tugas</label>
                                            <input type="text"
                                                class="form-control @error('title_task') is-invalid @enderror"
                                                name="title_task" id="title_task"
                                                value="{{ old('title_task', $task->title_task) }}"
                                                placeholder="Enter your Title Task">
                                            @error('title_task')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <label for="deksripsi" class="col-form-label">Deskripsi</label>
                                            <textarea class="form-control  @error('deskripsi') is-invalid @enderror" name="deksripsi" id="deksripsi" rows="6">{{ $task->deksripsi }}</textarea>
                                            @error('deksripsi')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col my-3 text-right">
                                            <button type="submit" class="btn btn-rounded btn-info btn-sm">Update</button>
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
            // Function to set default values based on existing task data
            function setDefaultValues() {
                var departmentID = $('#department').val();
                var subDepartmentID = '{{ $task->id_jabatan ?? null }}'; // Ambil nilai dari instance $task
                var priorityID = $('#priority_id').val();

                // Trigger change event to populate sub department and user dropdowns
                $('#department').trigger('change');

                // Set default values for sub department and user
                $('#sub_department').val(subDepartmentID).trigger('change');
                $('#priority_id').val(priorityID).trigger('change');
            }

            // Event handler for change in department dropdown
            $('#department').on('change', function() {
                var departmentID = $(this).val();

                if (departmentID) {
                    $.ajax({
                        url: '/user_pimpinan/DetailTask/create/' + departmentID,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                // Populate the department dropdown
                                var departmentDropdown = $('#sub_department');
                                departmentDropdown.empty();
                                departmentDropdown.append(
                                    '<option value="">Pilih Jabatan</option>');
                                $.each(data, function(key, sub_department) {
                                    var isSelected = (sub_department.id ==
                                            '{{ $task->id_jabatan ?? null }}') ?
                                        'selected' : '';
                                    departmentDropdown.append(
                                        '<option value="' + sub_department.id +
                                        '" ' + isSelected + '>' +
                                        sub_department.name + '</option>'
                                    )
                                });

                                // Trigger change event to populate user dropdown
                                $('#sub_department').trigger('change');
                            } else {}
                        }
                    });
                } else {
                    // Handle case when department is not selected
                }
            });

            // Event handler for change in sub department dropdown
            $('#sub_department').on('change', function() {
                var sub_departmentID = $(this).val();

                if (sub_departmentID) {
                    $.ajax({
                        url: '/user_pimpinan/DetailTask/createUser/' + sub_departmentID,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                // Populate the user dropdown
                                var userDropdown = $('#user_id');
                                userDropdown.empty();
                                userDropdown.append('<option value="">Pilih User</option>');
                                $.each(data, function(key, user) {
                                    var isSelectedUser = (user.id ==
                                            '{{ $task->id_user ?? null }}') ?
                                        'selected' : '';
                                    userDropdown.append(
                                        '<option value="' + user.id + '" ' +
                                        isSelectedUser + '>' +
                                        user.name + '</option>'
                                    )
                                });
                            } else {}
                        }
                    });
                } else {
                    // Handle case when sub department is not selected
                }
            });

            // Event handler for change in priority dropdown
            $('#priority_id').on('change', function() {
                var priorityID = $(this).val();
                if (priorityID == 4) {
                    $('#keterangan').empty();
                    $('#keterangan').append('<label for="catatan" class="col-form-label">Catatan</label>');
                    $('#keterangan').append(
                        '<input type="text" class="form-control" name="keterangan" value="{{ $task->keterangan }}" id="note">'
                    );
                } else {
                    // Handle other priority values, if needed
                }
            });

            // Call the function to set default values on document ready
            setDefaultValues();
        });
    </script>
@endsection
