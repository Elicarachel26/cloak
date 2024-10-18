<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>
    <link rel="icon" type="image/x-icon" href="{{URL('client/images/favicon.ico')}}">
    <meta charset="utf-8" />
    <title>@yield('title', env('APP_NAME'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <!-- <meta content="Ikhwanul Akhmad. DLY" name="author" /> -->
    <!-- App favicon -->
    {{--
    <link rel="shortcut icon" href="assets/images/favicon.ico"> --}}

    @include('panel.layouts.css')

</head>

<body>

    <main id="layout-wrapper">

        @include('panel.layouts.header')
        @include('panel.layouts.sidebar')

        <div class="vertical-overlay"></div>

        <!-- Start Content here -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>

            @include('panel.layouts.footer')
        </div>
        <!-- end main content-->
    </main>



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    @include('panel.layouts.script')
    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>