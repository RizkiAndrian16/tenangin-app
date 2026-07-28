@extends('layouts.landing')

@section('content')
    <!--[if lte IE 9]>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <p class="browserupgrade">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            You are using an <strong>outdated</strong> browser. Please
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a href="https://browsehappy.com/">upgrade your browser</a> to improve
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            your experience and security.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <![endif]-->

    <div class="preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <header class="header">
        <div class="navbar-area">
            <div class="container tng-navbar-container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand tng-navbar-brand" href="{{ url('/') }}">
                                <img src="{{ asset('assets-admin/img/logo/LogoSistem.png') }}" alt="Tenangin" />
                                <span class="tng-navbar-brand-text">Tenangin</span>
                            </a>
                            <div class="tng-navbar-mobile-actions">
                                <button class="navbar-toggler" type="button" id="btn-nav-mobile"
                                    aria-label="Toggle navigation">
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                </button>
                            </div>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto align-items-lg-center">
                                    <li class="nav-item">
                                        <a class="page-scroll active" href="#home">Beranda</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="page-scroll" href="#features">Fitur</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="page-scroll" href="#how-it-works">Cara Kerja</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="page-scroll" href="#about">Tentang</a>
                                    </li>
                                </ul>

                                <a href="{{ route('login') }}" class="tng-navbar-cta btn-hover">
                                    Masuk
                                </a>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="tng-main-content-bg">

        <div class="tng-page-glow tng-page-glow-1"></div>
        <div class="tng-page-glow tng-page-glow-2"></div>
        <div class="tng-page-glow tng-page-glow-3"></div>

        <section id="home" class="tng-hero">
            <div class="tng-hero-shape">
                <svg viewBox="0 0 1781.408 796.067" preserveAspectRatio="xMidYMax slice" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="tngHeroGradient" gradientUnits="userSpaceOnUse" x1="0" y1="0"
                            x2="0" y2="796.067">
                            <stop offset="0" stop-color="#4ADE80" />
                            <stop offset="1" stop-color="#10B981" />
                        </linearGradient>
                    </defs>
                    <path fill="url(#tngHeroGradient)"
                        d="m1650.595 755.5c56.3 272.618-131.189 364.024-310.13 505.374-347.561 273.959-503.57 14.469-1065.8 253.673s-359.832-759.047-359.832-759.047z"
                        transform="translate(120.633 -755.5)" />
                    <path fill="url(#tngHeroGradient)"
                        d="m-113.148 755.5c-41.4 185.71 96.459 247.977 228.027 344.266 255.548 186.624 370.256 9.856 783.643 172.8s264.57-517.07 264.57-517.07z"
                        transform="translate(286.464 -753.856)" />
                </svg>
            </div>

            <div class="container tng-hero-container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="tng-hero-content">
                            <h1 class="wow fadeInUp" data-wow-delay=".2s">
                                Kenali Tingkat Stresmu <br class="tng-hero-br">
                                dan Temukan Aktivitas <br class="tng-hero-br">
                                Relaksasi yang Tepat
                            </h1>
                            <p class="wow fadeInUp" data-wow-delay=".4s">
                                Tenangin membantu kamu mengetahui tingkat stres melalui assessment
                                PSS-10, lalu memberikan rekomendasi aktivitas relaksasi yang
                                dipersonalisasi sesuai preferensimu.
                            </p>
                            <a href="{{ route('login') }}" class="tng-hero-outline-btn wow fadeInUp" data-wow-delay=".6s">
                                Masuk
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="tng-hero-img wow fadeInUp" data-wow-delay=".3s">
                            <div class="tng-mock">
                                <div class="tng-mock-sidebar">
                                    <div class="tng-mock-logo"><i class="lni lni-cloud-check"></i></div>
                                    <span class="tng-mock-side-icon active"><i class="lni lni-grid-alt"></i></span>
                                    <span class="tng-mock-side-icon"><i class="lni lni-user"></i></span>
                                    <span class="tng-mock-side-icon"><i class="lni lni-clipboard-check"></i></span>
                                    <span class="tng-mock-side-icon"><i class="lni lni-timer"></i></span>
                                    <span class="tng-mock-side-icon"><i class="lni lni-comments"></i></span>
                                </div>

                                <div class="tng-mock-main">
                                    <div class="tng-mock-banner">
                                        <p class="tng-mock-banner-title">Selamat Datang! 👋</p>
                                        <p class="tng-mock-banner-text">Pantau tingkat stres Anda dan lihat perkembangan
                                            relaksasimu.</p>
                                    </div>

                                    <div class="tng-mock-cta">
                                        <div class="tng-mock-cta-icon"><i class="lni lni-pulse"></i></div>
                                        <div class="tng-mock-cta-text">
                                            <p class="tng-mock-cta-title">Mulai PSS-10 Assessment</p>
                                            <p class="tng-mock-cta-sub">Lakukan evaluasi untuk mengetahui tingkat stres
                                                Anda hari ini.</p>
                                        </div>
                                        <span class="tng-mock-cta-btn">Mulai <i class="lni lni-arrow-right"></i></span>
                                    </div>

                                    <div class="tng-mock-grid">
                                        <div class="tng-mock-score-card">
                                            <div class="tng-mock-ring">
                                                <span>15<b>/40</b></span>
                                            </div>
                                            <p class="tng-mock-score-label">Tingkat Stres Terakhir</p>
                                            <span class="tng-mock-badge tng-badge-warning">Sedang</span>
                                        </div>
                                        <div class="tng-mock-pref-card">
                                            <p class="tng-mock-section-label"><i class="lni lni-grid-alt"></i> Preferensi
                                                Aktivitas</p>
                                            <div class="tng-mock-pref-row"><span>Jenis Aktivitas</span><b>Meditasi</b>
                                            </div>
                                            <div class="tng-mock-pref-row"><span>Durasi</span><b>15 Menit</b></div>
                                            <div class="tng-mock-pref-row"><span>Intensitas</span><b>Rendah</b></div>
                                        </div>
                                        <div class="tng-mock-stat-card">
                                            <div class="tng-mock-stat-row"><b>12</b><span>Total Assessment</span><i
                                                    class="lni lni-clipboard"></i></div>
                                            <div class="tng-mock-stat-row"><b>9</b><span>Total Rekomendasi</span><i
                                                    class="lni lni-pulse"></i></div>
                                            <div class="tng-mock-stat-row"><b>6</b><span>Feedback</span><i
                                                    class="lni lni-comments"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tng-mock-chart">
                                        <p class="tng-mock-section-label"><i class="lni lni-stats-up"></i> Grafik
                                            Perubahan Tingkat Stres
                                        </p>
                                        <svg viewBox="0 0 400 100" class="tng-mock-chart-svg" preserveAspectRatio="none">
                                            <polyline points="10,60 90,48 170,68 250,50 330,20 390,15" fill="none"
                                                stroke="#16A34A" stroke-width="3" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <circle cx="90" cy="48" r="4" fill="#D97706" />
                                            <circle cx="170" cy="68" r="4" fill="#16A34A" />
                                            <circle cx="330" cy="20" r="4" fill="#DC2626" />
                                        </svg>
                                        <div class="tng-mock-chart-legend">
                                            <span><i class="tng-mock-dot tng-dot-success"></i>Rendah</span>
                                            <span><i class="tng-mock-dot tng-dot-warning"></i>Sedang</span>
                                            <span><i class="tng-mock-dot tng-dot-danger"></i>Tinggi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tng-hero-promo">
                                <div class="tng-hero-promo-icon"><i class="lni lni-alarm-clock"></i></div>
                                <p class="tng-hero-promo-title">Yuk, Mulai Assessment!</p>
                                <p class="tng-hero-promo-text">Cuma 5 menit, langsung dapat rekomendasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="tng-features pt-90 pb-70">
            <div class="container position-relative z-index-1">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="section-title text-center mb-60">
                            <h2 class="wow fadeInUp" data-wow-delay=".2s">
                                Fasilitas Lengkap untuk <br class="d-none d-md-block" /> Kelola Stresmu
                            </h2>
                            <p class="wow fadeInUp mx-auto tng-features-description" data-wow-delay=".4s">
                                Tenangin hadir dengan berbagai alat yang dirancang khusus untuk membantumu mengenali,
                                mengatasi, dan memantau tingkat stres selama masa perkuliahan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="tng-bento-grid">
                    <div class="tng-feature-card tng-bento-big wow fadeInUp" data-wow-delay=".2s">
                        <div class="tng-feature-icon tng-icon-success">
                            <i class="lni lni-clipboard"></i>
                        </div>
                        <h3>Assessment PSS-10</h3>
                        <p>
                            Ukur tingkat stresmu dengan cepat dan akurat menggunakan kuesioner standar <i>Perceived
                                Stress
                                Scale</i> (PSS-10). Hasil dari tes ini akan menjadi acuan utama sistem untuk memberikan
                            bantuan yang tepat.
                        </p>
                        <a href="{{ route('login') }}" class="tng-bento-link">
                            Mulai assessment <i class="lni lni-arrow-right"></i>
                        </a>
                    </div>

                    <div class="tng-feature-card tng-bento-s1 wow fadeInUp" data-wow-delay=".3s">
                        <div class="tng-feature-icon tng-icon-teal">
                            <i class="lni lni-bulb"></i>
                        </div>
                        <div>
                            <h3>Rekomendasi Personal</h3>
                            <p>Dapatkan saran aktivitas relaksasi yang disesuaikan dengan tingkat stres dan preferensi
                                waktu
                                luangmu.</p>
                        </div>
                    </div>

                    <div class="tng-feature-card tng-bento-s2 wow fadeInUp" data-wow-delay=".4s">
                        <div class="tng-feature-icon tng-icon-warning">
                            <i class="lni lni-leaf"></i>
                        </div>
                        <div>
                            <h3>Aktivitas & Mode Fokus</h3>
                            <p>Jalankan aktivitas relaksasi (sesuai dengan rekomendasi) secara langsung di dalam sistem
                                menggunakan timer cerdas.</p>
                        </div>
                    </div>

                    <div class="tng-feature-card tng-bento-s3 wow fadeInUp" data-wow-delay=".5s">
                        <div class="tng-feature-icon tng-icon-blue">
                            <i class="lni lni-stats-up"></i>
                        </div>
                        <div>
                            <h3>Pantau Perkembangan</h3>
                            <p>Lihat grafik riwayat stresmu dari waktu ke waktu untuk mengetahui efektivitas relaksasi
                                yang
                                telah dilakukan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="how-it-works" class="tng-how pt-70">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-9">
                        <div class="section-title text-center mb-60">
                            <h2 class="wow fadeInUp" data-wow-delay=".2s">
                                Bagaimana Tenangin Bekerja?
                            </h2>
                            <p class="wow fadeInUp" data-wow-delay=".4s">
                                Empat langkah mudah, dari assessment sampai evaluasi aktivitas.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="tng-how-timeline">
                    <div class="tng-how-step wow fadeInUp" data-wow-delay=".2s">
                        <span class="tng-how-ghost">01</span>
                        <div class="tng-how-number">01</div>
                        <div class="tng-how-content">
                            <h3>Isi Assessment</h3>
                            <p>Jawab 10 pertanyaan PSS-10 untuk mengetahui tingkat stres saat ini.</p>
                        </div>
                    </div>
                    <div class="tng-how-step wow fadeInUp" data-wow-delay=".3s">
                        <span class="tng-how-ghost">02</span>
                        <div class="tng-how-number">02</div>
                        <div class="tng-how-content">
                            <h3>Tentukan Preferensi</h3>
                            <p>Pilih karakteristik aktivitas relaksasi yang sesuai dengan preferensimu.</p>
                        </div>
                    </div>
                    <div class="tng-how-step wow fadeInUp" data-wow-delay=".4s">
                        <span class="tng-how-ghost">03</span>
                        <div class="tng-how-number">03</div>
                        <div class="tng-how-content">
                            <h3>Dapatkan Rekomendasi</h3>
                            <p>Tenangin mencocokkan tingkat stres dan preferensi untuk menghasilkan rekomendasi yang
                                lebih
                                sesuai.</p>
                        </div>
                    </div>
                    <div class="tng-how-step wow fadeInUp" data-wow-delay=".5s">
                        <span class="tng-how-ghost">04</span>
                        <div class="tng-how-number">04</div>
                        <div class="tng-how-content">
                            <h3>Lakukan &amp; Evaluasi</h3>
                            <p>Jalankan aktivitas relaksasi dan berikan feedback setelah selesai.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="tng-personalization pt-70">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="tng-personalization-visual wow fadeInUp" data-wow-delay=".2s">
                            <div class="tng-personalization-card">
                                <div class="tng-personalization-badge">
                                    <i class="lni lni-target-customer"></i> Personalisasi Aktif
                                </div>
                                <div class="tng-tag-row">
                                    <span class="tng-tag"><i class="lni lni-grid-alt"></i> Jenis Aktivitas</span>
                                    <span class="tng-tag"><i class="lni lni-timer"></i> Durasi</span>
                                    <span class="tng-tag"><i class="lni lni-pulse"></i> Intensitas</span>
                                </div>
                                <div class="tng-personalization-bar-row">
                                    <div class="tng-personalization-bar">
                                        <span class="tng-bar-fill"></span>
                                    </div>
                                    <span class="tng-personalization-percent">78%</span>
                                </div>
                                <p class="tng-personalization-caption">Tingkat kesesuaian rekomendasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="tng-personalization-content wow fadeInUp" data-wow-delay=".3s">
                            <div class="section-title mb-25">
                                <h2>Rekomendasi yang Lebih Sesuai untukmu</h2>
                                <p>
                                    Rekomendasi di Tenangin tidak hanya mempertimbangkan tingkat
                                    stresmu, tetapi juga preferensi pribadi seperti jenis
                                    aktivitas, durasi, dan intensitas yang kamu inginkan - agar
                                    aktivitas relaksasi yang disarankan terasa lebih pas
                                    untukmu.
                                </p>
                            </div>
                            <div class="tng-personalization-points">
                                <div class="tng-personalization-point">
                                    <i class="lni lni-grid-alt"></i>
                                    <span>Jenis aktivitas disesuaikan minat kamu</span>
                                </div>
                                <div class="tng-personalization-point">
                                    <i class="lni lni-timer"></i>
                                    <span>Durasi menyesuaikan waktu luangmu</span>
                                </div>
                                <div class="tng-personalization-point">
                                    <i class="lni lni-pulse"></i>
                                    <span>Intensitas disesuaikan kondisi stresmu</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="tng-about pt-70">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7 text-center">
                        <div class="section-title mb-25 wow fadeInUp" data-wow-delay=".2s">
                            <h2>Tentang Tenangin</h2>
                        </div>
                        <p class="wow fadeInUp" data-wow-delay=".3s">
                            Tenangin dikembangkan sebagai sistem yang membantu mahasiswa
                            mengenali tingkat stres melalui PSS-10 dan memperoleh rekomendasi
                            aktivitas relaksasi yang lebih personal, sehingga lebih mudah
                            menjaga keseimbangan di tengah kesibukan perkuliahan.
                        </p>
                        <div class="tng-about-points wow fadeInUp" data-wow-delay=".35s">
                            <div class="tng-about-point">
                                <i class="lni lni-clipboard"></i>
                                <span>Berbasis PSS-10</span>
                            </div>
                            <div class="tng-about-point">
                                <i class="lni lni-target"></i>
                                <span>Rekomendasi Personal</span>
                            </div>
                            <div class="tng-about-point">
                                <i class="lni lni-graph"></i>
                                <span>Pantau Perkembangan</span>
                            </div>
                        </div>
                        <div class="tng-about-disclaimer wow fadeInUp" data-wow-delay=".4s">
                            <i class="lni lni-shield"></i>
                            <p>
                                Hasil assessment pada Tenangin bersifat informatif dan bukan
                                merupakan diagnosis medis atau profesional.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="tng-cta pt-90 pb-50">
            <div class="container">
                <div class="tng-cta-wrapper">
                    <div class="tng-cta-dots"></div>
                    <div class="row align-items-center position-relative">
                        <div class="col-lg-8">
                            <div class="section-title mb-0">
                                <h2 class="text-white mb-15 wow fadeInUp" data-wow-delay=".2s">
                                    Siap Mengenali Kondisimu dan Menemukan Aktivitas yang Tepat?
                                </h2>
                                <p class="text-white wow fadeInUp" data-wow-delay=".4s">
                                    Mulai dengan assessment PSS-10 dan dapatkan rekomendasi
                                    aktivitas relaksasi yang dipersonalisasi untukmu.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-30 mt-lg-0">
                            <a href="{{ route('login') }}" class="main-btn btn-hover tng-cta-btn wow fadeInUp"
                                data-wow-delay=".6s">
                                Mulai dengan Tenangin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <button id="landingDarkModeToggle" type="button" aria-label="Ubah tema" title="Ubah tema">
            <i class="lni lni-night" id="themeIcon"></i>
        </button>

        <a href="#" class="scroll-top btn-hover">
            <i class="lni lni-chevron-up"></i>
        </a>
    </div>
@endsection
