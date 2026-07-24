<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tenangin') }}</title>

    <!-- SCRIPT ANTI-KEDIP DARK MODE (TETAP INLINE UNTUK MENCEGAH FOUC) -->
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>

    <!-- ADMIN KIT / BOOTSTRAP CSS -->
    <link href="{{ asset('assets-admin/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/css/button.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/css/alert.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/css/dark-mode.css') }}" rel="stylesheet">

    <!-- CSS AUTENTIKASI BARU -->
    <link href="{{ asset('assets-admin/css/auth.css') }}" rel="stylesheet">

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body class="bg-light">
    <!-- Tombol Toggle Dark Mode -->
    <button id="darkModeToggle"
        class="btn btn-light rounded-circle shadow-sm position-fixed top-0 end-0 m-4 d-flex align-items-center justify-content-center">
    </button>

    <div class="auth-page-bg">

        @if (request()->routeIs('login') || request()->routeIs('register'))
            <!-- DATA ATTRIBUTE MENGGANTIKAN LOGIC SCRIPT BLADE -->
            <div id="authCard" class="sliding-wrapper"
                data-register-active="{{ old('name') || request()->routeIs('register') ? 'true' : 'false' }}">

                <!-- 1. PANEL HIJAU (MELUNCUR) -->
                <div class="slide-panel green-overlay">
                    <div class="auth-left-photo"></div>
                    <div class="auth-left-watermark">
                        <img src="{{ asset('assets-admin/img/logo/LogoSistem.png') }}" alt="">
                    </div>
                    <div class="auth-left-content">
                        <div class="auth-left-brand">
                            <div class="auth-left-brand-icon">
                                <img src="{{ asset('assets-admin/img/logo/LogoSistem.png') }}" alt="Tenangin">
                            </div>
                            <div>
                                <div class="auth-left-brand-name">Tenangin</div>
                                <div class="auth-left-brand-tagline">Sistem Rekomendasi Aktivitas Relaksasi</div>
                            </div>
                        </div>
                        <div class="auth-left-text-block">
                            <h1 class="auth-left-headline">
                                Kelola Stres dan<br>
                                Temukan Aktivitas Relaksasi Yang Tepat
                            </h1>
                        </div>
                        <div class="auth-left-features">
                            <div class="auth-feature-box">
                                <div class="auth-feature-icon">
                                    <i data-feather="clipboard"></i>
                                </div>
                                <h6>Prediksi Stres</h6>
                                <small>Ketahui tingkat stres melalui pendekatan PSS-10</small>
                            </div>

                            <div class="auth-feature-box">
                                <div class="auth-feature-icon">
                                    <i data-feather="heart"></i>
                                </div>
                                <h6>Rekomendasi</h6>
                                <small>Temukan aktivitas relaksasi yang paling tepat</small>
                            </div>

                            <div class="auth-feature-box">
                                <div class="auth-feature-icon">
                                    <i data-feather="trending-down"></i>
                                </div>
                                <h6>Tingkat Stres</h6>
                                <small>Pantau perubahan tingkat stres melalui grafik</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. WADAH FORM LOGIN (Memanggil File Partial) -->
                <div class="slide-panel form-login-side">
                    @include('auth._login_form')
                </div>

                <!-- 3. WADAH FORM REGISTER (Memanggil File Partial) -->
                <div class="slide-panel form-register-side">
                    @include('auth._register_form')
                </div>

            </div>
        @else
            <!-- WADAH UTAMA: Dibuat identik dengan halaman Login -->
            <div class="sliding-wrapper auth-static-wrapper">

                <!-- 1. PANEL HIJAU (STATIS UNTUK FORGOT PASSWORD) -->
                <div class="slide-panel green-overlay">
                    <div class="auth-left-photo"></div>
                    <div class="auth-left-watermark">
                        <img src="{{ asset('assets-admin/img/logo/LogoSistem.png') }}" alt="">
                    </div>
                    <div class="auth-left-content">
                        <div class="auth-left-brand">
                            <div class="auth-left-brand-icon">
                                <img src="{{ asset('assets-admin/img/logo/LogoSistem.png') }}" alt="Tenangin">
                            </div>
                            <div>
                                <div class="auth-left-brand-name">Tenangin</div>
                                <div class="auth-left-brand-tagline">Sistem Rekomendasi Aktivitas Relaksasi</div>
                            </div>
                        </div>
                        <div class="auth-left-text-block">
                            <h1 class="auth-left-headline">
                                Kelola Stres dan<br>
                                Temukan Aktivitas Relaksasi Yang Tepat
                            </h1>
                        </div>
                        <div class="auth-left-features">
                            <div class="auth-feature-box">
                                <div class="auth-feature-icon"><i data-feather="clipboard"></i></div>
                                <h6>Prediksi Stres</h6>
                                <small>Ketahui tingkat stres melalui pendekatan PSS-10</small>
                            </div>
                            <div class="auth-feature-box">
                                <div class="auth-feature-icon"><i data-feather="heart"></i></div>
                                <h6>Rekomendasi</h6>
                                <small>Temukan aktivitas relaksasi yang paling tepat</small>
                            </div>
                            <div class="auth-feature-box">
                                <div class="auth-feature-icon"><i data-feather="trending-down"></i></div>
                                <h6>Tingkat Stres</h6>
                                <small>Pantau perubahan tingkat stres melalui grafik</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. WADAH FORM KANAN -->
                <div class="slide-panel form-login-side">
                    <div class="auth-right-body">
                        {{ $slot }}
                    </div>
                </div>

            </div>
        @endif

    </div>

    <!-- ADMIN KIT & FEATHER ICONS -->
    <script src="{{ asset('assets-admin/js/app.js') }}"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="{{ asset('assets-admin/js/base-script.js') }}"></script>
</body>

</html>
