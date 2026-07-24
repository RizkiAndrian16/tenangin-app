@extends('layouts.landing')

@section('content')

    <body>
        <!--[if lte IE 9]>
                                            <p class="browserupgrade">
                                                You are using an <strong>outdated</strong> browser. Please
                                                <a href="https://browsehappy.com/">upgrade your browser</a> to improve
                                                your experience and security.
                                            </p>
                                            <![endif]-->

        <!-- ======== preloader start ======== -->
        <div class="preloader">
            <div class="loader">
                <div class="spinner">
                    <div class="spinner-container">
                        <div class="spinner-rotator">
                            <div class="spinner-left">
                                <div class="spinner-circle"></div>
                            </div>
                            <div class="spinner-right">
                                <div class="spinner-circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- preloader end -->

        <!-- ======== header start ======== -->
        <header class="header">
            <div class="navbar-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <nav class="navbar navbar-expand-lg tng-navbar-pill">
                                <a class="navbar-brand tng-navbar-brand" href="{{ url('/') }}">
                                    <img src="{{ asset('assets-admin/img/logo/LogoSistem.png') }}" alt="Tenangin" />
                                    <span class="tng-navbar-brand-text">Tenangin</span>
                                </a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                </button>

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
                                        <li class="nav-item tng-nav-item-cta">
                                            <a href="{{ route('login') }}" class="tng-nav-btn">Masuk</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- navbar collapse -->
                            </nav>
                            <!-- navbar -->
                        </div>
                    </div>
                    <!-- row -->
                </div>
                <!-- container -->
            </div>
            <!-- navbar area -->
        </header>
        <!-- ======== header end ======== -->

        <!-- ======== hero-section start ======== -->
        <section id="home" class="tng-hero">
            <div class="tng-hero-orb tng-hero-orb-1"></div>
            <div class="tng-hero-orb tng-hero-orb-2"></div>
            <div class="container">
                <div class="row align-items-center position-relative">
                    <div class="col-lg-6">
                        <div class="tng-hero-content">
                            <h1 class="wow fadeInUp" data-wow-delay=".4s">
                                Kenali Tingkat Stresmu, <span class="tng-text-gradient">Temukan Relaksasi</span>
                                yang Tepat
                            </h1>
                            <p class="wow fadeInUp" data-wow-delay=".6s">
                                Tenangin membantu kamu mengetahui tingkat stres melalui assessment
                                PSS-10, lalu memberikan rekomendasi aktivitas relaksasi yang
                                dipersonalisasi sesuai preferensimu.
                            </p>
                            <div class="tng-hero-btn-group wow fadeInUp" data-wow-delay=".8s">
                                <a href="{{ route('login') }}" class="main-btn btn-hover tng-main-btn">
                                    Masuk ke Tenangin
                                    <i class="lni lni-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="tng-hero-visual wow fadeInUp" data-wow-delay=".5s">
                            <div class="tng-hero-blob"></div>
                            <div class="tng-hero-mockup">
                                <div class="tng-hero-mockup-topbar">
                                    <span></span><span></span><span></span>
                                </div>
                                <div class="tng-hero-mockup-body">
                                    <div class="tng-hero-mockup-score">
                                        <span class="tng-hero-mockup-score-num">18</span>
                                        <span class="tng-hero-mockup-score-max">/ 40</span>
                                    </div>
                                    <p class="tng-hero-mockup-caption">Skor PSS-10 Kamu</p>
                                    <span class="tng-hero-mockup-badge">Tingkat Stres: Rendah</span>
                                    <div class="tng-hero-mockup-list">
                                        <div class="tng-hero-mockup-row">
                                            <span class="tng-hero-mockup-dot tng-dot-success"></span>
                                            Assessment Selesai
                                        </div>
                                        <div class="tng-hero-mockup-row">
                                            <span class="tng-hero-mockup-dot tng-dot-primary"></span>
                                            Rekomendasi Siap
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tng-hero-float-card">
                                <span class="tng-hero-float-dot tng-dot-teal"></span>
                                Aktivitas Relaksasi Cocok
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ======== hero-section end ======== -->

        <!-- ======== feature-section start ======== -->
        <section id="features" class="tng-features pt-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-9">
                        <div class="section-title text-center mb-60">
                            <span class="tng-kicker wow fadeInUp" data-wow-delay=".1s">Fitur Utama</span>
                            <h2 class="wow fadeInUp" data-wow-delay=".2s">
                                Yang Bisa Kamu Lakukan di Tenangin
                            </h2>
                            <p class="wow fadeInUp" data-wow-delay=".4s">
                                Empat langkah sederhana untuk mengenali kondisi stresmu dan
                                menemukan aktivitas relaksasi yang sesuai.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="tng-bento-grid">
                    <div class="tng-feature-card tng-bento-big wow fadeInUp" data-wow-delay=".2s">
                        <div class="tng-feature-icon tng-icon-success">
                            <i class="lni lni-clipboard-check"></i>
                        </div>
                        <h3>Assessment PSS-10</h3>
                        <p>
                            Ketahui tingkat stresmu dengan mengisi 10 pertanyaan singkat
                            berbasis skala PSS-10, standar yang umum dipakai untuk mengukur
                            persepsi stres.
                        </p>
                        <a href="{{ route('login') }}" class="tng-bento-link">
                            Mulai assessment <i class="lni lni-arrow-right"></i>
                        </a>
                    </div>

                    <div class="tng-feature-card tng-bento-s1 wow fadeInUp" data-wow-delay=".3s">
                        <div class="tng-feature-icon tng-icon-teal">
                            <i class="lni lni-thumbs-up"></i>
                        </div>
                        <div>
                            <h3>Rekomendasi Personal</h3>
                            <p>Aktivitas relaksasi berdasarkan tingkat stres dan preferensimu.</p>
                        </div>
                    </div>

                    <div class="tng-feature-card tng-bento-s2 wow fadeInUp" data-wow-delay=".4s">
                        <div class="tng-feature-icon tng-icon-primary">
                            <i class="lni lni-leaf"></i>
                        </div>
                        <div>
                            <h3>Aktivitas Relaksasi</h3>
                            <p>Jalankan aktivitas relaksasi lewat Mode Fokus di sistem.</p>
                        </div>
                    </div>

                    <div class="tng-feature-card tng-bento-s3 wow fadeInUp" data-wow-delay=".5s">
                        <div class="tng-feature-icon tng-icon-purple">
                            <i class="lni lni-bar-chart"></i>
                        </div>
                        <div>
                            <h3>Pantau Perkembangan</h3>
                            <p>Lihat riwayat assessment dan perkembangan tingkat stresmu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ======== feature-section end ======== -->

        <!-- ======== how-it-works start ======== -->
        <section id="how-it-works" class="tng-how pt-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-9">
                        <div class="section-title text-center mb-60">
                            <span class="tng-kicker wow fadeInUp" data-wow-delay=".1s">Cara Kerja</span>
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
                            <p>Tenangin mencocokkan tingkat stres dan preferensi untuk menghasilkan rekomendasi yang lebih
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
        <!-- ======== how-it-works end ======== -->

        <!-- ======== personalization-section start ======== -->
        <section class="tng-personalization pt-120">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="tng-personalization-visual wow fadeInUp" data-wow-delay=".2s">
                            <div class="tng-personalization-card">
                                <div class="tng-tag-row">
                                    <span class="tng-tag">Jenis Aktivitas</span>
                                    <span class="tng-tag">Durasi</span>
                                    <span class="tng-tag">Intensitas</span>
                                </div>
                                <div class="tng-personalization-bar">
                                    <span class="tng-bar-fill" style="width: 78%"></span>
                                </div>
                                <p class="tng-personalization-caption">Tingkat kesesuaian rekomendasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="tng-personalization-content wow fadeInUp" data-wow-delay=".3s">
                            <div class="section-title mb-25">
                                <span class="tng-kicker">Personalisasi</span>
                                <h2>Rekomendasi yang Lebih Sesuai untukmu</h2>
                                <p>
                                    Rekomendasi di Tenangin tidak hanya mempertimbangkan tingkat
                                    stresmu, tetapi juga preferensi pribadi seperti jenis
                                    aktivitas, durasi, dan intensitas yang kamu inginkan - agar
                                    aktivitas relaksasi yang disarankan terasa lebih pas
                                    untukmu.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ======== personalization-section end ======== -->

        <!-- ======== about-section start ======== -->
        <section id="about" class="tng-about pt-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <div class="section-title mb-25 wow fadeInUp" data-wow-delay=".2s">
                            <span class="tng-kicker">Tentang</span>
                            <h2>Tentang Tenangin</h2>
                        </div>
                        <p class="wow fadeInUp" data-wow-delay=".3s">
                            Tenangin dikembangkan sebagai sistem yang membantu mahasiswa
                            mengenali tingkat stres melalui PSS-10 dan memperoleh rekomendasi
                            aktivitas relaksasi yang lebih personal, sehingga lebih mudah
                            menjaga keseimbangan di tengah kesibukan perkuliahan.
                        </p>
                        <p class="tng-about-disclaimer wow fadeInUp" data-wow-delay=".4s">
                            Hasil assessment pada Tenangin bersifat informatif dan bukan
                            merupakan diagnosis medis atau profesional.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- ======== about-section end ======== -->

        <!-- ======== cta-section start ======== -->
        <section class="tng-cta pt-120">
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
        <!-- ======== cta-section end ======== -->

        <!-- ======== footer start ======== -->
        <footer class="tng-footer">
            <div class="container">
                <div class="tng-footer-wrapper">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="tng-footer-brand">
                                <a href="{{ url('/') }}" class="tng-footer-logo">
                                    <img src="{{ asset('assets-admin/img/logo/LogoSistem.png') }}" alt="Tenangin" />
                                    <span>Tenangin</span>
                                </a>
                                <p>Sistem Rekomendasi Aktivitas Relaksasi Personal untuk Mahasiswa</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ul class="tng-footer-links">
                                <li><a href="#home" class="page-scroll">Beranda</a></li>
                                <li><a href="#features" class="page-scroll">Fitur</a></li>
                                <li><a href="#how-it-works" class="page-scroll">Cara Kerja</a></li>
                                <li><a href="#about" class="page-scroll">Tentang</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tng-footer-bottom">
                        <p>&copy; {{ date('Y') }} Tenangin.</p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- ======== footer end ======== -->

        <!-- ======== scroll-top ======== -->
        <a href="#" class="scroll-top btn-hover">
            <i class="lni lni-chevron-up"></i>
        </a>

        <!-- ======== JS here ======== -->
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
@endsection
