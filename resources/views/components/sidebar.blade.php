<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto">ADMIN SILAGAS</h5>

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
                {{-- <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm sidebar-resize-hide opacity-50">Main</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li> --}}

                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-database"></i>
                        <span>Master</span>
                    </a>
                    <ul class="nav-group-sub collapse">
                        <li class="nav-item"><a href="{{ route('admin.master.group.index') }}"
                                class="nav-link {{ Route::is('admin.master.group.*') ? 'active' : '' }}">Golongan</a>
                        <li class="nav-item"><a href="{{ route('admin.master.scope.index') }}"
                                class="nav-link {{ Route::is('admin.master.scope.*') ? 'active' : '' }}">Bidang</a>
                        <li class="nav-item"><a href="{{ route('admin.master.category.index') }}" class="nav-link"
                                {{ Route::is('admin.master.category.*') ? 'active' : '' }}>Kelompok</a>
                        <li class="nav-item"><a href="{{ route('admin.master.sub-category.index') }}" class="nav-link"
                                {{ Route::is('admin.master.sub-category.*') ? 'active' : '' }}>Sub Kelompok</a>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
