<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title_auth')</title>

    <!-- Global stylesheets -->
    <link href="{{ asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('assets/demo/demo_configurator.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <!-- /theme JS files -->

</head>

<body>

    <!-- Main navbar -->
    <div class="navbar navbar-dark navbar-static py-2">
        <div class="container-fluid">
            <div class="navbar-brand">
                <a href="index.html" class="d-inline-flex align-items-center">
                    <img src="../../../assets/images/logo_icon.svg" alt="">
                    <img src="../../../assets/images/logo_text_light.svg" class="d-none d-sm-inline-block h-16px ms-3"
                        alt="">
                </a>
            </div>

            <div class="d-flex justify-content-end align-items-center ms-auto">
                <ul class="navbar-nav flex-row">
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="navbar-nav-link navbar-nav-link-icon rounded ms-1">
                            <div class="d-flex align-items-center mx-md-1">
                                <i class="ph-user-circle-plus"></i>
                                <span class="d-none d-md-inline-block ms-2">Register</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="navbar-nav-link navbar-nav-link-icon rounded ms-1">
                            <div class="d-flex align-items-center mx-md-1">
                                <i class="ph-user-circle"></i>
                                <span class="d-none d-md-inline-block ms-2">Login</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /main navbar -->


    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                @yield('content_auth')

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</body>

</html>
