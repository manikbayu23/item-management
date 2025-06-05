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
    <div class="page-header page-header-light shadow">
        <div class="page-header-content container-boxed d-lg-flex">
            <div class="d-flex">
                <h4 class="page-title mb-0 text-dark">@yield('title')
                </h4>

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
