<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="{{ asset('AdminLTE-3.2.0') }}/index3.html" class="brand-link  text-center">
        <span class="brand-text font-weight-light protest-guerrilla-regular ">Admin<b>SIMPLE</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Menu</li>
                <li class="nav-item active menu open"><!--menu open/active-->
                    <a href="{{ url('/users') }}" class="nav-link {{ $active === 'beranda' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Beranda
                        </p>
                    </a>
                </li>
                <li class="nav-item active menu open"><!--menu open/active-->
                    <a href="{{ url('users/organisasi') }}"
                        class="nav-link {{ $active === 'manageOrganisasi' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-sitemap"></i>
                        <p>
                            Organisasi
                        </p>
                    </a>
                </li>
                <li class="nav-item active menu open"><!--menu open/active-->
                    <a href="{{ route('pegawai.index') }}"
                        class="nav-link {{ $active === 'manageUser' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Pegawai
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
