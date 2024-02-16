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
                    <a href="/" class="nav-link {{ $active === 'beranda' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item active menu open"><!--menu open/active-->
                    <a href="{{ route('organisasi') }}"
                        class="nav-link {{ $active === 'manageOrganisasi' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-sitemap"></i>
                        <p>
                            Manage Organization
                        </p>
                    </a>
                </li>
                <li class="nav-item active menu open"><!--menu open/active-->
                    <a href="{{ route('ManageUsers.index') }}"
                        class="nav-link {{ $active === 'manageUser' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Manage Users
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
