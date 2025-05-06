<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Global stylesheets -->
    <link href="{{ asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">

    @stack('style_user')

    <style>
        .datepicker {
            z-index: 9999;
        }
    </style>
    <!-- /global stylesheets -->

</head>

<body class="navbar-top">

    @include('components.user-navbar')

    <!-- Page header -->
    <div class="page-header page-header-dark text-white">
        <div class="page-header-content container-boxed d-lg-flex">
            <div class="d-flex">
                <h4 class="page-title mb-0">@yield('title')
                </h4>

                <a href="#page_header"
                    class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                    data-bs-toggle="collapse" data-color-theme="dark">
                    <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                </a>
            </div>

            <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
                <div class="d-inline-flex align-items-center mb-2 mb-lg-0">

                    <div class="vr flex-shrink-0 my-2 mx-3"></div>
                    <a href="#" class="btn btn-outline-yellow btn-icon w-32px h-32px rounded-pill">
                        <i class="ph-plus"></i>
                    </a>
                    <div class="dropdown ms-2">
                        <a href="#" class="btn btn-light btn-icon w-32px h-32px rounded-pill"
                            data-bs-toggle="dropdown" data-color-theme="dark">
                            <i class="ph-dots-three-vertical"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <button type="button" class="dropdown-item">
                                <i class="ph-users me-2"></i>
                                User management
                            </button>
                            <button type="button" class="dropdown-item">
                                <i class="ph-briefcase me-2"></i>
                                Customers
                            </button>
                            <button type="button" class="dropdown-item">
                                <i class="ph-circles-four me-2"></i>
                                Projects
                            </button>
                            <div class="dropdown-divider"></div>
                            <button type="button" class="dropdown-item">
                                <i class="ph-lock me-2"></i>
                                Permissions
                            </button>
                            <button type="button" class="dropdown-item">
                                <i class="ph-shield-check me-2"></i>
                                Security
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Inner content -->
            <div class="content-inner">
                <div class="content overflow-auto">
                    @yield(section: 'content_user')
                </div>
                @include('components.bottom-navbar')
            </div>
        </div>
    </div>


    <!-- Core JS files -->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/js/vendor/notifications/noty.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/extra_noty.js') }}"></script>
    <!-- /theme JS files -->


    @stack('script_user')

</body>

</html>
