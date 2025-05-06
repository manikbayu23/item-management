<div class="navbar navbar-sm navbar-footer border-top">
    <div class="container-fluid">
        <ul class="nav mx-auto gap-2">
            <li class="nav-item">
                @php
                    $active = 'text-primary bg-primary bg-opacity-10 fw-semibold';
                @endphp
                <a href="{{ route('user.dashboard') }}"
                    class="navbar-nav-link navbar-nav-link-icon rounded {{ Route::is('user.dashboard') ? $active : '' }}">
                    <div class="d-flex align-items-center mx-md-1">
                        <i class="ph-house"></i>
                        <span class="d-none d-md-inline-block ms-2">Home</span>
                    </div>
                </a>
            </li>
            <li class="nav-item ms-md-1">
                <a href="{{ route('user.assets.form') }}"
                    class="navbar-nav-link navbar-nav-link-icon rounded {{ Route::is('user.assets.form') ? $active : '' }}">
                    <div class="d-flex align-items-center mx-md-1">
                        <i class="ph-file-text"></i>
                        <span class="d-none d-md-inline-block ms-2">Form</span>
                    </div>
                </a>
            </li>
            <li class="nav-item ms-md-1">
                <a href="{{ route('user.assets.history') }}"
                    class="navbar-nav-link navbar-nav-link-icon rounded {{ Route::is('user.assets.history') ? $active : '' }}">
                    <div class="d-flex align-items-center mx-md-1">
                        <i class="ph-list-dashes"></i>
                        <span class="d-none d-md-inline-block ms-2">Riwayat</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
