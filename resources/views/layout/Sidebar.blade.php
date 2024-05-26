<aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="{{ asset('AdminLTE-3.2.0') }}/index3.html" class="brand-link  text-center">
        <span class="brand-text font-weight-light protest-guerrilla-regular"><b>SIMPLE | Fakultas Teknik</b></span>
    </a>



    <!-- Sidebar -->
    <div class="sidebar ">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Menu</li>
                <li class="nav-item active">
                    <a href="{{ url('/users') }}" class="nav-link {{ $active === 'beranda' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard
                        </p>
                    </a>
                </li>
                @if ($level_user_id->tingkat  == 1)
                    <li class="nav-item">
                        <a href="{{ route('task-duties.index') }}"
                            class="nav-link {{ $active === 'task' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Task Duties</p>
                        </a>
                    </li>
                @elseif ($level_user_id->tingkat > 1 && $level_user_id->tingkat < 6)
                    <li class="nav-item">
                        <a href="{{ route('task-duties.index') }}"
                            class="nav-link {{ $active === 'task' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Task Duties</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('users/my-task') }}" class="nav-link {{ $active === 'my-task' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-pen"></i>
                            <p>My Tasks</p>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ url('users/my-task') }}" class="nav-link {{ $active === 'my-task' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-pen"></i>
                            <p>My Tasks</p>
                        </a>
                    </li>
                @endif
                <li class="nav-header">
                    Lainnya
                </li>
                <li class="nav-item active">
                    <a href="{{ url('/users') }}" class="nav-link">
                        <i class="nav-icon fa fa-settings"></i>
                        <p>Pengaduan
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
