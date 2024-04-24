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
                    <a @if (auth()->user()->roles_id == 2) href="{{ route('dashoard-pimpinan') }}" @else  href="{{ route('user_staf.index') }}" @endif
                        class="nav-link {{ $active === 'beranda' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard
                        </p>
                    </a>
                </li>
                @if (auth()->user()->level_user_id == 1)
                    <li class="nav-item">
                        <a href="{{ route('dashboard_pejabat.index') }}"
                            class="nav-link {{ $active === 'task' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Task Duties</p>
                        </a>
                    </li>
                @elseif (auth()->user()->level_user_id == 2)
                    <li class="nav-item">
                        <a href="{{ route('dashboard_pejabat.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Task Duties</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('details-tugas-staf') }}" class="nav-link">
                            <i class="nav-icon fas fa-pen"></i>
                            <p>My Tasks</p>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('details-tugas-staf') }}"
                            class="nav-link {{ $active === 'task' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-pen"></i>
                            <p>My Tasks</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
