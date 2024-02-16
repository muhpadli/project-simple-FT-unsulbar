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
                        <p>Beranda
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a @if (auth()->user()->roles_id == 2) href="{{ route('dashboard_pejabat.index') }}" @else  href="{{ route('details-tugas-staf') }}" @endif
                        class="nav-link {{ $active === 'task' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>List Tugas
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ $active === 'filter-priority' ? 'menu-open' : ' ' }}">
                    <a class="nav-link {{ $active === 'filter-priority' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-filter"></i>
                        <p>
                            Filter By Prioritas
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-gray">
                        @foreach ($prioritas_tugas as $key => $item)
                            <li class="nav-item">
                                <a @if (auth()->user()->roles_id == 2) href="{{ route('get-task-by-priority', $key + 1) }}"
                                    @else
                                        href="{{ route('detail-where-priority', $key + 1) }}" @endif
                                    class="nav-link small " style="color: white">
                                    <p>{{ Str::ucfirst($item->name) }}</p>
                                    @if ($priority === Str::lower($item->name))
                                        <i class='nav-icon float-right fa fa-check-circle'></i>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item {{ $active === 'filter-status' ? 'menu-open' : ' ' }}">
                    <a class="nav-link {{ $active === 'filter-status' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-filter"></i>
                        <p>
                            Filter By Status
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-gray">
                        @foreach ($prioritas_status as $key => $item)
                            <li class="nav-item">
                                <a @if (auth()->user()->roles_id == 2) href="{{ route('get-task-by-status', $key + 1) }}"
                                    @else
                                        href="{{ route('detail-where-staus', $key + 1) }}" @endif
                                    class="nav-link small " style="color: white">
                                    <p>{{ Str::ucfirst($item->name_status) }}</p>
                                    @if ($priority === $item->name_status)
                                        <i class='nav-icon float-right fa fa-check-circle'></i>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
