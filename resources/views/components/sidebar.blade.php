<!-- Main sidebar -->
<div class="sidebar sidebar-dark bg-primary sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto">ADMINISTRATOR</h5>

                <div>
                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill sidebar-control sidebar-main-resize d-none d-lg-inline-flex border-transparent">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill sidebar-mobile-main-toggle d-lg-none border-transparent">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- /sidebar header -->


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm sidebar-resize-hide opacity-50">Main</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        <i class="ph-house"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link  ">
                        <i class="ph-package"></i>
                        <span>Manajemen Barang</span>
                    </a>
                    <ul class="nav-group-sub collapse">
                        <li class="nav-item">
                            <a href="{{ route('admin.item') }}"
                                class="nav-link {{ Route::is('admin.item*') ? 'active' : '' }}">
                                <span>
                                    Daftar Barang
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.room-inventory') }}"
                                class="nav-link {{ Route::is('admin.room-inventory*') ? 'active' : '' }}">
                                <span>
                                    Inventaris Ruangan
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.room-inventory') }}"
                                class="nav-link {{ Route::is('admin.room-inventory*') ? 'active' : '' }}">
                                <span>
                                    Peminjaman Barang
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.user-account') }}"
                        class="nav-link {{ Route::is('admin.user-account*') ? 'active' : '' }}">
                        <i class="ph-users"></i>
                        <span>
                            Akun Pengguna
                        </span>
                    </a>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link  {{ Route::is('admin.master*') ? 'active' : '' }}">
                        <i class="ph-database"></i>
                        <span>Master</span>
                    </a>
                    <ul class="nav-group-sub collapse">
                        <li class="nav-item"><a href="{{ route('admin.master.division') }}"
                                class="nav-link {{ Route::is('admin.master.division*') ? 'active' : '' }}">Divisi</a>
                        </li>
                        <li class="nav-item"><a href="{{ route('admin.master.room') }}"
                                class="nav-link {{ Route::is('admin.master.room*') ? 'active' : '' }}">Ruangan</a>
                        </li>
                        <li class="nav-item"><a href="{{ route('admin.master.position') }}"
                                class="nav-link {{ Route::is('admin.master.position*') ? 'active' : '' }}">Jabatan</a>
                        </li>
                        <li class="nav-item"><a href="{{ route('admin.master.category') }}"
                                class="nav-link {{ Route::is('admin.master.category*') ? 'active' : '' }}">Kategori</a>
                        </li>

                    </ul>
                </li>
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
