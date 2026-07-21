<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tenangin') }}</title>

    <!-- SCRIPT ANTI-KEDIP DARK MODE -->
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

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        /* ======================================
           BACKGROUND UTAMA
        ====================================== */
        html,
        body {
            height: 100%;
        }

        .auth-page-bg {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(160deg, #ECFDF5 0%, #D1FAE5 45%, #BBF7D0 100%);
            transition: background 0.3s ease;
        }

        .auth-page-bg::before,
        .auth-page-bg::after {
            content: "";
            position: absolute;
            background-image: url('{{ asset('assets-admin/img/logo/LogoSistem.png') }}');
            background-size: contain;
            background-repeat: no-repeat;
            z-index: 0;
        }

        .auth-page-bg::before {
            top: -12%;
            left: -14%;
            width: 560px;
            height: 560px;
            opacity: 0.10;
            transform: rotate(-8deg);
        }

        .auth-page-bg::after {
            bottom: -16%;
            right: -10%;
            width: 440px;
            height: 440px;
            opacity: 0.08;
            transform: rotate(12deg);
        }

        /* ======================================
           SLIDING PANEL CONTAINER
        ====================================== */
        .sliding-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1040px;
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 30px 80px rgba(16, 92, 55, 0.18);
            min-height: 649px;
            padding: 12px;
            overflow: hidden;
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }

        .slide-panel {
            position: absolute;
            top: 12px;
            bottom: 12px;
            width: calc(50% - 18px);
            transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .green-overlay {
            left: 12px;
            z-index: 20;
            background: #ECFDF5;
            border-radius: 22px;
            overflow: hidden;
        }

        .form-login-side {
            right: 12px;
            z-index: 10;
            display: flex;
            flex-direction: column;
            opacity: 1;
            transform: translateX(0);
        }

        .form-register-side {
            right: 12px;
            z-index: 5;
            display: flex;
            flex-direction: column;
            opacity: 0;
            transform: translateX(50px);
            pointer-events: none;
        }

        /* AKSI KETIKA KELAS "sign-up-mode" AKTIF */
        .sliding-wrapper.sign-up-mode .green-overlay {
            transform: translateX(calc(100% + 12px));
        }

        .sliding-wrapper.sign-up-mode .form-login-side {
            opacity: 0;
            transform: translateX(calc(-100% - 50px));
            pointer-events: none;
        }

        .sliding-wrapper.sign-up-mode .form-register-side {
            opacity: 1;
            transform: translateX(calc(-100% - 12px));
            pointer-events: auto;
            z-index: 15;
        }

        /* ======================================
           ISI KONTEN PANEL KIRI (HIJAU)
        ====================================== */
        .auth-left-photo {
            position: absolute;
            top: -18%;
            left: -22%;
            width: 145%;
            height: 145%;
            background: linear-gradient(150deg, #A7F3D0 0%, #6EE7B7 45%, #34D399 100%);
            transform: rotate(-7deg);
            z-index: 0;
        }

        .auth-left-watermark {
            position: absolute;
            inset: 0;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .auth-left-watermark img {
            width: 85%;
            max-width: 380px;
            opacity: 0.10;
            transform: rotate(6deg);
        }

        .auth-left-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: grid;
            grid-template-rows: auto 1fr auto;
            padding: 40px 48px;
        }

        .auth-left-brand {
            grid-row: 1;
            align-self: start;
            justify-self: start;
            margin: -20px 0 0 -24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .auth-left-brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .auth-left-brand-icon img {
            width: 26px;
            height: 26px;
            object-fit: contain;
        }

        .auth-left-brand-name {
            color: #064E3B;
            font-weight: 800;
            font-size: 15px;
            line-height: 1.2;
        }

        .auth-left-brand-tagline {
            color: rgba(6, 78, 59, 0.65);
            font-size: 10.5px;
            font-weight: 500;
        }

        .auth-left-text-block {
            grid-row: 2;
            align-self: center;
            max-width: 480px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .auth-left-headline {
            font-size: 38px;
            font-weight: 900;
            color: #064E3B;
            line-height: 1.3;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .auth-left-headline span {
            color: #FFFFFF;
            background: #15803D;
            padding: 0 6px;
            border-radius: 6px;
            box-decoration-break: clone;
            -webkit-box-decoration-break: clone;
        }

        .auth-left-features {
            grid-row: 3;
            max-width: 480px;
            margin-left: -24px;
            margin-right: -24px;
            display: flex;
            gap: 10px;
        }

        .auth-feature-box {
            flex: 1;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 14px;
            padding: 12px 10px;
            backdrop-filter: blur(6px);
        }

        .auth-feature-icon {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            background: rgba(255, 255, 255, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #064E3B;
            margin-bottom: 8px;
        }

        .auth-feature-icon svg {
            width: 14px;
            height: 14px;
        }

        .auth-feature-box h6 {
            font-size: 11.5px;
            font-weight: 700;
            color: #064E3B;
            margin-bottom: 2px;
            line-height: 1.25;
        }

        .auth-feature-box small {
            font-size: 9.5px;
            color: rgba(6, 78, 59, 0.62);
            display: block;
            line-height: 1.3;
        }

        /* ======================================
           ISI KONTEN PANEL KANAN (FORM)
        ====================================== */
        .auth-right-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-width: 340px;
            margin: 0 auto;
            width: 100%;
        }

        .auth-right-body h1 {
            font-size: 26px;
            font-weight: 800;
            text-align: center;
            color: #0F172A;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .auth-right-body p.sub {
            text-align: center;
            color: #64748B;
            font-size: 14px;
            margin-bottom: 26px;
        }

        .auth-field-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .auth-input-wrap {
            position: relative;
        }

        .auth-input {
            height: 46px;
            width: 100%;
            padding: 0 16px;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            font-size: 14px;
            background-color: #FFFFFF;
            color: #1E293B;
            transition: all 0.2s ease;
        }

        .auth-input.has-toggle {
            padding-right: 42px;
        }

        .auth-input::placeholder {
            color: #94A3B8;
        }

        .auth-input:focus {
            outline: none;
            border-color: #34D399 !important;
            background-color: #FFFFFF;
            box-shadow: 0 0 0 0.15rem rgba(52, 211, 153, 0.18) !important;
        }

        .auth-input-toggle {
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 0;
            color: #94A3B8;
            display: flex;
            cursor: pointer;
        }

        .auth-input-toggle:hover {
            color: #16A34A;
        }

        .auth-submit-btn {
            width: 100%;
            height: 48px;
            border-radius: 999px;
            border: none;
            background: linear-gradient(135deg, #6EE7B7, #34D399);
            color: #064E3B;
            font-weight: 700;
            font-size: 14.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 10px;
        }

        .auth-submit-btn:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
        }

        .auth-submit-btn svg {
            width: 17px;
            height: 17px;
        }

        /* ====== DIVIDER "ATAU" ====== */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 18px 0;
            color: #94A3B8;
            font-size: 12.5px;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #E2E8F0;
        }

        /* ====== TOMBOL LOGIN DENGAN GOOGLE ====== */
        .auth-google-btn {
            width: 100%;
            height: 46px;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
            background: #FFFFFF;
            color: #334155;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .auth-google-btn:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
            color: #334155;
        }

        .auth-google-btn svg {
            width: 18px;
            height: 18px;
        }

        .dark-mode .auth-divider {
            color: #64748B;
        }

        .dark-mode .auth-divider::before,
        .dark-mode .auth-divider::after {
            background: #374151;
        }

        .dark-mode .auth-google-btn {
            background: #0F172A;
            border-color: #374151;
            color: #E5E7EB;
        }

        .dark-mode .auth-google-btn:hover {
            background: #1E293B;
        }

        .auth-link {
            color: #16A34A;
            text-decoration: none;
            font-weight: 600;
            font-size: 13.5px;
            transition: color 0.2s ease;
            cursor: pointer;
        }

        .auth-link:hover {
            color: #15803D;
        }

        /* ======================================
           DARK MODE
        ====================================== */
        .dark-mode .auth-page-bg {
            background: linear-gradient(160deg, #0F172A 0%, #0B1E15 60%, #0F172A 100%);
        }

        .dark-mode .auth-page-bg::before,
        .dark-mode .auth-page-bg::after {
            opacity: 0.15;
            filter: saturate(3) brightness(0.7) contrast(1.2);
        }

        .dark-mode .sliding-wrapper {
            background: #162033;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.35);
        }

        .dark-mode .green-overlay {
            background: #0F172A;
        }

        .dark-mode .auth-left-photo {
            background: linear-gradient(150deg, #14532D 0%, #166534 45%, #052e16 100%);
        }

        .dark-mode .auth-left-watermark img {
            opacity: 0.08;
        }

        .dark-mode .auth-left-brand-icon {
            background: rgba(255, 255, 255, 0.08);
        }

        .dark-mode .auth-left-brand-name {
            color: #F0FDF4;
        }

        .dark-mode .auth-left-brand-tagline {
            color: rgba(240, 253, 244, 0.6);
        }

        .dark-mode .auth-left-headline {
            color: #F8FAFC;
        }

        .dark-mode .auth-left-headline span {
            background: #22C55E;
            color: #052e16;
        }

        .dark-mode .auth-feature-box {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.12);
        }

        .dark-mode .auth-feature-icon {
            background: rgba(255, 255, 255, 0.1);
            color: #86EFAC;
        }

        .dark-mode .auth-feature-box h6 {
            color: #F0FDF4;
        }

        .dark-mode .auth-feature-box small {
            color: rgba(240, 253, 244, 0.55);
        }

        .dark-mode .auth-right-body h1 {
            color: #F9FAFB;
        }

        .dark-mode .auth-right-body p.sub {
            color: #9CA3AF;
        }

        .dark-mode .auth-field-label {
            color: #E5E7EB;
        }

        .dark-mode .auth-input {
            background-color: #0F172A !important;
            border-color: #374151 !important;
            color: #F9FAFB !important;
        }

        .dark-mode .auth-input::placeholder {
            color: #9CA3AF !important;
        }

        .dark-mode .auth-input:focus {
            background-color: #0F172A !important;
            border-color: #22C55E !important;
            box-shadow: 0 0 0 0.15rem rgba(34, 197, 94, 0.15) !important;
        }

        .dark-mode .auth-input-toggle {
            color: #CBD5E1;
        }

        .dark-mode .auth-input-toggle:hover {
            color: #4ADE80;
        }

        #darkModeToggle {
            color: #475569;
            transition: all 0.3s ease;
        }

        html:not(.dark-mode) #darkModeToggle {
            background: linear-gradient(135deg, #6EE7B7, #34D399) !important;
            color: #064E3B !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(52, 211, 153, 0.3) !important;
        }

        .dark-mode #darkModeToggle {
            background-color: #1E293B !important;
            border-color: #374151 !important;
            color: #E5E7EB !important;
        }

        /* ======================================
           TAMPILAN MOBILE / HP (RESPONSIVE FIX)
        ====================================== */
        @media (max-width: 860px) {

            html,
            body {
                overflow-x: hidden !important;
            }

            .auth-page-bg {
                padding: 20px 15px !important;
            }

            /* 1. Tinggi default untuk form Login & Register */
            .sliding-wrapper {
                min-height: 610px !important;
                padding: 0 !important;
                border-radius: 24px !important;
                transition: min-height 0.4s ease !important;
            }

            .sliding-wrapper.sign-up-mode {
                min-height: 665px !important;
            }

            /* 2. Pengaturan dasar panel (Sistem Melayang) */
            .slide-panel {
                width: 100% !important;
                position: absolute !important;
                top: 0 !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                padding: 35px 24px !important;
                transition: opacity 0.4s ease, visibility 0.4s ease !important;
                transform: none !important;
            }

            /* 3. Matikan Panel Hijau di HP */
            .slide-panel.green-overlay {
                display: none !important;
                opacity: 0 !important;
                visibility: hidden !important;
                z-index: -10 !important;
            }

            /* 4. Atur Form Login & Register */
            .form-login-side,
            .form-register-side {
                display: flex !important;
                flex-direction: column !important;
                justify-content: center !important;
            }

            .form-login-side {
                opacity: 1 !important;
                visibility: visible !important;
                pointer-events: auto !important;
                z-index: 10;
            }

            .form-register-side {
                opacity: 0 !important;
                visibility: hidden !important;
                pointer-events: none !important;
                z-index: 5;
            }

            .sliding-wrapper.sign-up-mode .form-login-side {
                opacity: 0 !important;
                visibility: hidden !important;
                pointer-events: none !important;
                z-index: 5;
            }

            .sliding-wrapper.sign-up-mode .form-register-side {
                opacity: 1 !important;
                visibility: visible !important;
                pointer-events: auto !important;
                z-index: 10;
            }

            /* 5. Posisi Tombol Dark Mode */
            #darkModeToggle {
                top: 15px !important;
                right: 15px !important;
                margin: 0 !important;
                width: 48px !important;
                height: 48px !important;
                z-index: 1060 !important;
            }

            /* ====================================================
               6. PERBAIKAN RUANG KOSONG (KHUSUS RESET PASSWORD DI HP)
               (Dipindah ke urutan terbawah agar diprioritaskan oleh CSS)
               ==================================================== */
            .sliding-wrapper.auth-static-wrapper {
                min-height: 0 !important;
                /* Hapus paksaan tinggi 520px */
                height: auto !important;
                /* Biarkan tinggi menyesuaikan isi */
                display: block !important;
            }

            .sliding-wrapper.auth-static-wrapper .form-login-side {
                position: relative !important;
                top: auto !important;
                bottom: auto !important;
                height: auto !important;
                min-height: 0 !important;
                padding: 70px 24px !important;
            }
        }
    </style>
</head>

<body class="bg-light">
    <!-- Tombol Toggle Dark Mode -->
    <button id="darkModeToggle"
        class="btn btn-light rounded-circle shadow-sm position-fixed top-0 end-0 m-4 d-flex align-items-center justify-content-center"
        style="z-index: 1050; width: 52px; height: 52px; cursor: pointer;">
    </button>

    <div class="auth-page-bg">

        @if (request()->routeIs('login') || request()->routeIs('register'))
            <div id="authCard" class="sliding-wrapper">

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

                            <!-- Kotak 1: Prediksi (Sesuai Judul & Arahan Dospem) -->
                            <div class="auth-feature-box">
                                <div class="auth-feature-icon">
                                    <i data-feather="clipboard"></i>
                                </div>
                                <h6>Prediksi Stres</h6>
                                <small>Ketahui tingkat stres melalui pendekatan PSS-10</small>
                            </div>

                            <!-- Kotak 2: Rekomendasi -->
                            <div class="auth-feature-box">
                                <div class="auth-feature-icon">
                                    <i data-feather="heart"></i>
                                </div>
                                <h6>Rekomendasi</h6>
                                <small>Temukan aktivitas relaksasi yang paling tepat</small>
                            </div>

                            <!-- Kotak 3: Grafik -->
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
                <!-- Menggunakan .slide-panel agar ukurannya mutlak 50% persis -->
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
                <!-- Menggunakan class .slide-panel dan .form-login-side agar 100% presisi dan sejajar -->
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

    <script>
        if (window.feather) {
            feather.replace();
        }

        // FUNGSI ANIMASI SLIDING PANEL
        function toggleAuthMode(e, mode) {
            e.preventDefault();
            const authCard = document.getElementById('authCard');

            if (mode === 'register') {
                authCard.classList.add('sign-up-mode');
                window.history.pushState({}, '', '/register');
            } else {
                authCard.classList.remove('sign-up-mode');
                window.history.pushState({}, '', '/login');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const authCard = document.getElementById('authCard');
            if (!authCard) return;

            const hasRegisterErrors = {{ old('name') ? 'true' : 'false' }};
            const isRegisterRoute = {{ request()->routeIs('register') ? 'true' : 'false' }};

            if (hasRegisterErrors || isRegisterRoute) {
                authCard.classList.add('sign-up-mode');
            }
        });
    </script>
</body>

</html>
