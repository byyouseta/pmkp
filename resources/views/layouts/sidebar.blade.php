<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('template/dist/img/avatar-default.png') }}" class="img-circle elevation-2"
                alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
   with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="/home" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
                {{-- <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Active Page</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Inactive Page</p>
                        </a>
                    </li>
                </ul> --}}
            </li>
            @if (Auth::user()->can('indikator-list') || Auth::user()->can('approval-list'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-thumbtack"></i>
                        <p>
                            Indikator
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('indikator-list')
                            <li class="nav-item">
                                <a href="/indikator" class="nav-link">
                                    <i class="fas fa-paper-plane nav-icon"></i>
                                    <p>Pengajuan Indikator</p>
                                </a>
                            </li>
                        @endcan
                        @can('approval-list')
                            <li class="nav-item">
                                <a href="/indikator/approval" class="nav-link">
                                    <i class="fas fa-pen-fancy nav-icon"></i>
                                    <p>Persetujuan Indikator</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="/indikator/cari" class="nav-link">
                                <i class="nav-icon fas fa-search"></i>
                                <p>Cari Indikator</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::user()->can('pelaporan-harian-list') || Auth::user()->can('rekap-harian'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-thumbs-up"></i>
                        <p>
                            PMKP
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('pelaporan-harian-list')
                            <li class="nav-item">
                                <a href="/indikator/list" class="nav-link">
                                    <i class="far fa-edit nav-icon"></i>
                                    <p>Pengisian Indikator Harian</p>
                                </a>
                            </li>
                        @endcan
                        @can('rekap-harian')
                            <li class="nav-item">
                                <a href="/indikator/report" class="nav-link">
                                    <i class="far fa-calendar-alt nav-icon"></i>
                                    <p>Rekap Indikator Harian</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif
            @if (Auth::user()->can('pelaporan-bulanan-list') || Auth::user()->can('rekap-bulanan'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-hospital"></i>
                        <p>
                            IKU
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('pelaporan-bulanan-list')
                            <li class="nav-item">
                                <a href="/pelaporan/bulanan" class="nav-link">
                                    <i class="nav-icon fas fa-pen"></i>
                                    <p>
                                        Pelaporan Bulanan
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('rekap-bulanan')
                            <li class="nav-item">
                                <a href="/report/bulanan" class="nav-link">
                                    <i class="far fa-calendar-alt nav-icon"></i>
                                    <p>Rekap Bulanan</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-hospital-symbol"></i>
                    <p>
                        IKT
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/ikt/laporan" class="nav-link">
                            <i class="nav-icon fas fa-pen"></i>
                            <p>
                                Pelaporan Bulanan
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/ikt" class="nav-link">
                            <i class="far fa-calendar-alt nav-icon"></i>
                            <p>Rekap Bulanan</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user-md"></i>
                    <p>
                        IKI
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
            </li>
            @if (Auth::user()->can('user-list') || Auth::user()->can('unit-list') || Auth::user()->can('satuan-list') || Auth::user()->can('kategori-list'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('user-list')
                            <li class="nav-item">
                                <a href="/user" class="nav-link">
                                    <i class="fas fa-users nav-icon"></i>

                                    <p>Master User</p>
                                </a>
                            </li>
                        @endcan
                        @can('unit-list')
                            <li class="nav-item">
                                <a href="/unit" class="nav-link">
                                    <i class="far fa-building nav-icon"></i>
                                    <p>Master Unit</p>
                                </a>
                            </li>
                        @endcan
                        @can('tahun-list')
                            <li class="nav-item">
                                <a href="/tahun" class="nav-link">
                                    <i class="far fa-calendar-alt nav-icon"></i>
                                    <p>Master Tahun</p>
                                </a>
                            </li>
                        @endcan
                        @can('satuan-list')
                            <li class="nav-item">
                                <a href="/satuan" class="nav-link">
                                    <i class="fas fa-pencil-ruler nav-icon"></i>
                                    <p>Master Satuan</p>
                                </a>
                            </li>
                        @endcan
                        @can('kategori-list')
                            <li class="nav-item">
                                <a href="/kategori" class="nav-link">
                                    <i class="fab fa-buromobelexperte nav-icon"></i>
                                    <p>Master Kategori Indikator</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="/rangeiku" class="nav-link">
                                <i class="nav-icon fas fa-th-large"></i>
                                <p>Master Range IKU</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::user()->can('role-list') || Auth::user()->can('permission-list'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            Managemen Akses
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('role-list')
                            <li class="nav-item">
                                <a href="/roles" class="nav-link">
                                    <i class="fas fa-users-cog nav-icon"></i>

                                    <p>Akses Grup</p>
                                </a>
                            </li>
                        @endcan
                        @can('permission-list')
                            <li class="nav-item">
                                <a href="/permission" class="nav-link">
                                    <i class="far fa-folder-open nav-icon"></i>
                                    <p>List Akses</p>
                                </a>
                            </li>
                        @endcan

                        {{-- <li class="nav-item">
                        <a href="/akses/menu" class="nav-link">
                            <i class="fas fa-user-shield nav-icon"></i>
                            <p>Akses Menu</p>
                        </a>
                    </li> --}}
                    </ul>
                </li>
            @endif

            <li class="nav-item">
                <a href="/profile" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Profil
                        {{-- <span class="right badge badge-danger">New</span> --}}
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <span style="color: Tomato;">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                    </span>
                    {{-- <i class="nav-icon fas fa-sign-out"></i> --}}
                    <p>
                        Logout
                    </p>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
