<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Tenangin App">
    <meta name="author" content="Rizki Andrian">

    <title>@yield('title', 'Tenangin App')</title>

    {{-- FONTS --}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">

    {{-- FAVICON --}}
    <link rel="shortcut icon" href="{{ asset('assets-admin/img/logo/LogoSistem.png') }}" type="image/png">

    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>

    {{-- MAIN CSS --}}
    <link href="{{ asset('assets-admin/css/app.css') }}" rel="stylesheet">

    {{-- CUSTOM CSS --}}
    <link href="{{ asset('assets-admin/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/css/button.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/css/badge.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/css/alert.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/css/filter.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/css/pagination.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/css/pss.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/css/topbar.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/css/profile.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/css/dark-mode.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>

    {{-- WRAPPER --}}
    <div class="wrapper">

        {{-- SIDEBAR --}}
        @include('layouts.sidebar')

        {{-- MAIN --}}
        <div class="main">

            {{-- TOPBAR --}}
            @include('layouts.topbar')

            {{-- PAGE CONTENT --}}
            <main class="content">
                <div class="container-fluid p-0">
                    @yield('content')
                </div>
            </main>

            {{-- FOOTER --}}
            {{-- @include('layouts.footer') --}}

        </div>
    </div>

    {{-- SCROLL TO TOP --}}
    <a class="btn btn-soft-success position-fixed bottom-0 end-0 m-4 rounded-circle" href="#" id="scrollTopButton"
        style="display: none; z-index: 999;">
        <i data-feather="arrow-up"></i>
    </a>

    {{-- JS --}}
    <script src="{{ asset('assets-admin/js/app.js') }}"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="{{ asset('assets-admin/js/base-script.js') }}"></script>

    @stack('scripts')

</body>

</html>
