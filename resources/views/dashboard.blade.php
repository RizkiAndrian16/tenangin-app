@extends('layouts.main')
@section('title', 'Dashboard - Tenangin.')

@push('styles')
    <link
        href="{{ asset('assets-admin/css/dashboard.css') }}?v={{ filemtime(public_path('assets-admin/css/dashboard.css')) }}"
        rel="stylesheet">
@endpush

@section('content')

    @if (Auth::user()->isAdmin())

        {{-- =======================================================
             DASHBOARD ADMIN
        ======================================================== --}}

        {{-- HEADER --}}
        <div class="mb-4">
            <div class="position-relative overflow-hidden rounded-4 shadow-sm p-4 p-md-5 p-lg-3 dashboard-hero-banner">

                <div class="position-absolute top-0 end-0 rounded-circle dashboard-hero-circle-top"></div>
                <div class="position-absolute bottom-0 end-0 rounded-circle dashboard-hero-circle-bottom"></div>

                <div class="position-relative">
                    <h4 class="fw-bold text-white mb-2 mb-lg-1">
                        Halo, {{ Auth::user()->name }}! 👋
                    </h4>
                    <p class="text-white mb-0 dashboard-hero-subtitle">
                        Pantau secara menyeluruh ringkasan data pengguna, hasil PSS-10, katalog aktivitas, riwayat & aturan rekomendasi, serta feedback.
                    </p>
                </div>
            </div>
        </div>

        {{-- =======================================================
             STATISTIK RINGKAS
        ======================================================== --}}
        <div class="card profile-alert-card rounded-4 p-4">
            <div class="row g-4">

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 position-relative d-flex align-items-center h-100">
                            <a href="{{ route('users.index') }}"
                                class="position-absolute text-decoration-underline small fw-medium dashboard-link-pos dashboard-link-success-text">Lihat</a>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box-soft icon-box-success rounded-circle flex-shrink-0 icon-52">
                                    <i data-feather="users" class="icon-22"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $totalUsers }}</h4>
                                    <span class="text-muted small">Total Pengguna</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 position-relative d-flex align-items-center h-100">
                            <a href="{{ route('activities.index') }}"
                                class="position-absolute text-decoration-underline small fw-medium dashboard-link-pos dashboard-link-warning-text">Lihat</a>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box-soft icon-box-warning rounded-circle flex-shrink-0 icon-52">
                                    <i data-feather="grid" class="icon-22"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $totalActivities }}</h4>
                                    <span class="text-muted small">Total Katalog Aktivitas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 position-relative d-flex align-items-center h-100">
                            <a href="{{ route('rule-based-rules.index') }}"
                                class="position-absolute text-decoration-underline small fw-medium dashboard-link-pos dashboard-link-teal-text">Lihat</a>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box-soft icon-box-teal rounded-circle flex-shrink-0 icon-52">
                                    <i data-feather="git-branch" class="icon-22"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $totalRules }}</h4>
                                    <span class="text-muted small">Total Aturan Rekomendasi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 position-relative d-flex align-items-center h-100">
                            <a href="{{ route('pss-assessments.index') }}"
                                class="position-absolute text-decoration-underline small fw-medium dashboard-link-pos dashboard-link-primary-text">Lihat</a>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box-soft icon-box-primary rounded-circle flex-shrink-0 icon-52">
                                    <i data-feather="clipboard" class="icon-22"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $totalAssessments }}</h4>
                                    <span class="text-muted small d-block mb-1">Total PSS-10 Assessment</span>
                                    @if ($usersHighStress > 0)
                                        <a href="{{ route('pss-assessments.index', ['stress_level' => 'Tinggi']) }}"
                                            class="d-block small fw-medium text-decoration-underline dashboard-link-danger-text">
                                            {{ $usersHighStress }} Stres Tinggi
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 position-relative d-flex align-items-center h-100">
                            <a href="{{ route('recommendations.history') }}"
                                class="position-absolute text-decoration-underline small fw-medium dashboard-link-pos dashboard-link-purple-text">Lihat</a>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box-soft icon-box-purple rounded-circle flex-shrink-0 icon-52">
                                    <i data-feather="clock" class="icon-22"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $totalRecommendations }}</h4>
                                    <span class="text-muted small">Total Riwayat Rekomendasi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 position-relative d-flex align-items-center h-100">
                            <a href="{{ route('feedbacks.index') }}"
                                class="position-absolute text-decoration-underline small fw-medium dashboard-link-pos dashboard-link-danger-text">Lihat</a>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box-soft icon-box-danger rounded-circle flex-shrink-0 icon-52">
                                    <i data-feather="message-square" class="icon-22"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $totalFeedbacks }}</h4>
                                    <span class="text-muted small">Total Feedback</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- =======================================================
             GRAFIK TREN BULANAN TAHUN BERJALAN
        ======================================================== --}}
        <div class="row g-4">
            <div class="col-12">
                {{-- BUNGKUSAN CARD UTAMA (Agar persis seperti referensi) --}}
                <div class="card border-0 shadow-sm rounded-4 w-100">
                    <div class="card-body p-4">

                        {{-- JUDUL & IKON --}}
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-soft icon-box-success me-3">
                                <i data-feather="trending-up"></i>
                            </div>
                            <h6 class="fw-bold mb-0">Tren Penggunaan Sistem ({{ now()->year }})</h6>
                        </div>

                        {{-- DERETAN 3 GRAFIK --}}
                        <div class="row g-4">
                            {{-- CHART 1: PENGGUNA BARU --}}
                            <div class="col-12 col-lg-4">
                                <div class="card border shadow-none rounded-4 w-100 h-100">
                                    <div class="card-body p-3">
                                        <div class="text-center mb-4">
                                            <span class="text-muted fw-medium small">Pengguna Baru</span>
                                        </div>
                                        <div class="chart chart-sm dashboard-chart-sm">
                                            <canvas id="newUserChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- CHART 2: ASSESSMENT --}}
                            <div class="col-12 col-lg-4">
                                <div class="card border shadow-none rounded-4 w-100 h-100">
                                    <div class="card-body p-3">
                                        <div class="text-center mb-4">
                                            <span class="text-muted fw-medium small">PSS-10 Assessment</span>
                                        </div>
                                        <div class="chart chart-sm dashboard-chart-sm">
                                            <canvas id="assessmentChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- CHART 3: FEEDBACK --}}
                            <div class="col-12 col-lg-4">
                                <div class="card border shadow-none rounded-4 w-100 h-100">
                                    <div class="card-body p-3">
                                        <div class="text-center mb-4">
                                            <span class="text-muted fw-medium small">Feedback</span>
                                        </div>
                                        <div class="chart chart-sm dashboard-chart-sm">
                                            <canvas id="feedbackChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- =======================================================
             AKTIVITAS TERBARU
        ======================================================== --}}
        <div class="row g-4">
            <div class="col-12">
                {{-- BUNGKUSAN CARD UTAMA AKTIVITAS TERBARU --}}
                <div class="card border-0 shadow-sm rounded-4 w-100">
                    <div class="card-body p-4">

                        {{-- DERETAN 3 KOLOM AKTIVITAS --}}
                        <div class="row g-4">

                            {{-- KOLOM 1: PENGGUNA BARU --}}
                            <div class="col-12 col-lg-4">
                                <div class="card border shadow-none rounded-4 h-100">
                                    <div class="card-body p-3 d-flex flex-column">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="icon-box-soft icon-box-success rounded-3 flex-shrink-0">
                                                <i data-feather="user-plus"></i>
                                            </div>
                                            <h6 class="fw-bold mb-0 text-dark">Pengguna Baru</h6>
                                        </div>

                                        @forelse ($latestUsers as $user)
                                            <div
                                                class="d-flex justify-content-between align-items-center dashboard-latest-item {{ !$loop->last ? 'border-bottom' : '' }}">
                                                <span class="small fw-medium text-dark">{{ $user->name }}</span>
                                                <span
                                                    class="text-muted text-11">{{ $user->created_at->diffForHumans() }}</span>
                                            </div>
                                        @empty
                                            <div class="d-flex flex-grow-1 align-items-center justify-content-center py-3">
                                                <p class="text-muted small mb-0">Belum ada data.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            {{-- KOLOM 2: ASSESSMENT TERBARU --}}
                            <div class="col-12 col-lg-4">
                                <div class="card border shadow-none rounded-4 h-100">
                                    <div class="card-body p-3 d-flex flex-column">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="icon-box-soft icon-box-primary rounded-3 flex-shrink-0">
                                                <i data-feather="clipboard"></i>
                                            </div>
                                            <h6 class="fw-bold mb-0 text-dark">PSS-10 Assessment Terbaru</h6>
                                        </div>

                                        @forelse ($latestAssessments as $assessment)
                                            <div
                                                class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                                <span
                                                    class="small fw-medium text-dark">{{ $assessment->user->name ?? '-' }}</span>

                                                @if ($assessment->stress_level == 'Rendah')
                                                    <span
                                                        class="badge badge-soft-success rounded-pill badge-dashboard-sm">Rendah</span>
                                                @elseif ($assessment->stress_level == 'Sedang')
                                                    <span
                                                        class="badge badge-soft-warning rounded-pill badge-dashboard-sm">Sedang</span>
                                                @else
                                                    <span
                                                        class="badge badge-soft-danger rounded-pill badge-dashboard-sm">Tinggi</span>
                                                @endif

                                            </div>
                                        @empty
                                            <div class="d-flex flex-grow-1 align-items-center justify-content-center py-3">
                                                <p class="text-muted small mb-0">Belum ada data.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            {{-- KOLOM 3: FEEDBACK TERBARU --}}
                            <div class="col-12 col-lg-4">
                                <div class="card border shadow-none rounded-4 h-100">
                                    <div class="card-body p-3 d-flex flex-column">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="icon-box-soft icon-box-warning rounded-3 flex-shrink-0">
                                                <i data-feather="message-square"></i>
                                            </div>
                                            <h6 class="fw-bold mb-0 text-dark">Feedback Terbaru</h6>
                                        </div>

                                        @forelse ($latestFeedbacks as $feedback)
                                            <div
                                                class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                                <span
                                                    class="small fw-medium text-dark">{{ $feedback->user->name ?? '-' }}</span>
                                                <span class="small text-muted">⭐
                                                    {{ $feedback->overall_rating ?? '-' }}/5</span>
                                            </div>
                                        @empty
                                            <div class="d-flex flex-grow-1 align-items-center justify-content-center py-3">
                                                <p class="text-muted small mb-0">Belum ada data.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- =======================================================
             DATA BRIDGE: TREN BULANAN ADMIN -> dashboard.js
        ======================================================== --}}
        <script id="dashboard-admin-data" type="application/json">
            {!! json_encode([
                'labels' => $monthlyLabels,
                'users' => $monthlyUsers,
                'assessments' => $monthlyAssessments,
                'feedbacks' => $monthlyFeedbacks,
            ]) !!}
        </script>
    @else
        {{-- =======================================================
             DASHBOARD MAHASISWA (REDESIGNED - CALM & EMPATHETIC)
        ======================================================== --}}

        {{-- =====================================================
             SECTION 1: HERO BANNER TENANG
        ====================================================== --}}
        <div class="mb-4">
            <div class="student-hero-banner position-relative overflow-hidden rounded-4 shadow-sm">

                {{-- Blob dekoratif SVG --}}
                <div class="student-hero-blob student-hero-blob-1" aria-hidden="true"></div>
                <div class="student-hero-blob student-hero-blob-2" aria-hidden="true"></div>

                {{-- Konten utama --}}
                <div class="student-hero-content position-relative">

                    {{-- Sapaan empatik --}}
                    <div class="student-hero-greeting mb-1">
                        <h4 class="fw-bold student-hero-title mb-0">
                            Halo, {{ Auth::user()->name }}! 👋
                        </h4>
                    </div>
                    <p class="student-hero-subtitle mb-4">
                        Ambil nafas dalam-dalam. Mari temukan kedamaian kecil untuk dirimu hari ini.
                    </p>

                    {{-- Daily Calming Quote --}}
                    <div class="student-daily-quote">
                        <i data-feather="feather" class="student-quote-icon"></i>
                        <p id="dailyQuoteText" class="student-quote-text mb-0">"Pikiranmu berhak mendapatkan waktu untuk tenang."</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- =====================================================
             SECTION 2: PRIMARY ACTION — CEK KONDISI
        ====================================================== --}}
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="student-cta-card rounded-4 shadow-sm">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">

                        {{-- Grouping Icon & Text so they stay side-by-side on mobile --}}
                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                            {{-- Ilustrasi / Ikon --}}
                            <div class="student-cta-icon-wrap flex-shrink-0">
                                <div class="student-cta-icon-circle">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Teks --}}
                            <div class="text-start">
                                <h5 class="fw-bold student-cta-title mb-1">Yuk, cari tahu tingkat stresmu</h5>
                                <p class="student-cta-subtitle mb-0">
                                    Luangkan waktu sebentar untuk dirimu sendiri. Jawab sesuai kata hatimu, ya.
                                </p>
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <a href="{{ route('pss-assessments.create') }}"
                            id="btn-cek-kondisi"
                            class="student-cta-btn d-flex align-items-center gap-2 text-decoration-none flex-shrink-0">
                            Cari Tahu Sekarang
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- =====================================================
             INFORMASI PRIVASI DATA MAHASISWA
        ====================================================== --}}
        <div class="mb-3 mb-lg-4">
            <div class="student-privacy-card rounded-4 shadow-sm">
                <div class="student-privacy-grid">
                    <div class="student-privacy-icon-wrap flex-shrink-0">
                        <div class="student-privacy-icon-circle">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="student-privacy-title-wrap">
                        <h5 class="fw-bold student-privacy-title mb-0">Privasi Data Kamu</h5>
                    </div>
                    <div class="student-privacy-desc-wrap">
                        <p class="student-privacy-desc mb-0">
                            Data yang kamu isi, seperti hasil PSS-10, preferensi aktivitas, dan feedback, membantu sistem memberikan rekomendasi yang lebih sesuai untuk kamu. Informasi tersebut digunakan dengan tetap menjaga privasi kamu selama menggunakan sistem.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- =====================================================
             SECTION 3: QUICK RELIEF + STATUS KONDISI
        ====================================================== --}}
        <div class="student-grid-container d-flex flex-column gap-2 gap-lg-4 mb-2 mb-lg-4">

            {{-- KONDISIMU SAAT INI (order-1 on mobile) --}}
            <div class="grid-kondisi order-1">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 d-flex flex-column">

                        <div class="d-flex align-items-center gap-2 mb-4">
                            <div class="student-widget-icon-wrap">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </div>
                            <h6 class="fw-bold mb-0 student-widget-title">Kondisimu (Terakhir Dicatat)</h6>
                        </div>

                        <div class="flex-grow-1 d-flex flex-column justify-content-center">
                            @if (!$lastAssessment)
                                {{-- Belum ada data --}}
                                <div class="student-mood-empty text-center py-2">
                                    <div class="student-mood-empty-emoji mb-2">🌱</div>
                                    <p class="fw-semibold student-mood-empty-title mb-1">Belum ada data kondisi</p>
                                    <p class="text-muted small mb-0">
                                        Cari tahu tingkat stresmu sekarang agar kamu bisa mengetahui kondisimu sekarang.
                                    </p>
                                </div>
                            @else
                                {{-- Ada data assessment --}}
                                <div class="student-mood-display">

                                    {{-- Mood Bar --}}
                                    <div class="student-mood-bar-wrap mb-4">
                                        <div class="student-mood-bar-track">
                                            <div class="student-mood-bar-fill student-mood-fill-{{ strtolower($lastAssessment->stress_level) }}"
                                                style="width: {{ round(($stressScore / 40) * 100) }}%">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1">
                                            <small class="student-mood-bar-label">Tenang</small>
                                            <small class="student-mood-bar-label">Sangat Stres</small>
                                        </div>
                                    </div>

                                    {{-- Mood Label & Deskripsi --}}
                                    @if ($lastAssessment->stress_level == 'Rendah')
                                        <div class="student-mood-badge student-mood-badge-low mb-3">
                                            😌 &nbsp;Kondisimu sedang &nbsp;<strong>baik</strong>
                                        </div>
                                        <p class="student-mood-desc text-muted small mb-0">
                                            Kondisimu sudah cukup baik hari ini. Pertahankan ya! Tetap jaga rutinitas relaksasimu agar pikiran selalu tenang dan produktif.
                                        </p>
                                    @elseif ($lastAssessment->stress_level == 'Sedang')
                                        <div class="student-mood-badge student-mood-badge-medium mb-3">
                                            😐 &nbsp;Kamu sedang &nbsp;<strong>sedikit lelah</strong>
                                        </div>
                                        <p class="student-mood-desc text-muted small mb-0">
                                            Tidak apa-apa, wajar kok merasa lelah. Coba ambil jeda sejenak dan lakukan aktivitas relaksasi ringan agar pikiran kembali segar.
                                        </p>
                                    @else
                                        <div class="student-mood-badge student-mood-badge-high mb-3">
                                            😟 &nbsp;Kamu sedang &nbsp;<strong>butuh istirahat</strong>
                                        </div>
                                        <p class="student-mood-desc text-muted small mb-0">
                                            Tarik napas dalam-dalam, kami di sini untukmu. Istirahatkan pikiranmu sejenak, lalu cobalah aktivitas relaksasi yang kami rekomendasikan.
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            {{-- TINGKAT STRES TERAKHIR (order-2 on mobile) --}}
            <div class="grid-tingkat-stres order-2">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 d-flex flex-column align-items-center text-center">

                        {{-- Judul Widget --}}
                        <div class="d-flex align-items-center gap-2 mb-4 align-self-start">
                            <div class="student-widget-icon-wrap">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M12 8v4l3 3"/>
                                </svg>
                            </div>
                            <h6 class="fw-bold mb-0 student-widget-title">
                                Tingkat Stres Terakhir
                            </h6>
                        </div>

                        {{-- Area Bulatan Skor + Kaki (Badge & Tanggal) --}}
                        <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1 w-100">
                            
                            {{-- Bulatan Skor --}}
                            <div class="score-circle mx-auto mb-4 dashboard-score-circle {{ $lastAssessment ? 'score-circle-' . strtolower($lastAssessment->stress_level) : 'dashboard-score-circle-empty' }}">
                                <div class="score-circle-inner">
                                    <span class="score-number dashboard-score-number {{ $lastAssessment ? 'score-number-' . strtolower($lastAssessment->stress_level) : 'dashboard-score-number-empty' }}">
                                        {{ $stressScore }}
                                    </span>
                                    <span class="score-max dashboard-score-max {{ !$lastAssessment ? 'dashboard-score-max-empty' : '' }}">/40</span>
                                </div>
                            </div>

                            <span class="text-muted small mt-2 mb-3">Tingkat Stres Terakhir</span>

                            {{-- Kaki Bulatan: Lencana Status (Badge) --}}
                            @if (!$lastAssessment)
                                <span class="badge badge-soft-secondary rounded-pill px-3 py-1.5 fw-medium mb-3">Belum Ada</span>
                            @else
                                @if ($lastAssessment->stress_level == 'Rendah')
                                    <span class="badge badge-soft-success rounded-pill px-3 py-1.5 fw-medium mb-3">😌 Rendah</span>
                                @elseif ($lastAssessment->stress_level == 'Sedang')
                                    <span class="badge badge-soft-warning rounded-pill px-3 py-1.5 fw-medium mb-3">😐 Sedang</span>
                                @else
                                    <span class="badge badge-soft-danger rounded-pill px-3 py-1.5 fw-medium mb-3">😟 Tinggi</span>
                                @endif
                            @endif

                            {{-- Kaki Bulatan: Tanggal Tes --}}
                            <div class="d-flex align-items-center gap-2 student-mood-date">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                <span class="small">
                                    @if ($lastAssessment)
                                        Terakhir diisi: {{ $lastAssessment->created_at->locale('id')->translatedFormat('d F Y') }}
                                    @else
                                        Belum ada riwayat
                                    @endif
                                </span>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            {{-- PREFERENSI RELAKSASI (order-3 on mobile) --}}
            <div class="grid-preferensi order-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">

                        <div class="d-flex align-items-center gap-2 mb-4">
                            <div class="student-widget-icon-wrap">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/>
                                </svg>
                            </div>
                            <h6 class="fw-bold mb-0 student-widget-title">Preferensi Aktivitas Relaksasimu</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <div class="student-pref-item">
                                    <span class="student-pref-label">Jenis Aktivitas</span>
                                    <span class="student-pref-value">{{ $activePreference->preferred_activity_type ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="student-pref-item">
                                    <span class="student-pref-label">Durasi</span>
                                    <span class="student-pref-value">{{ $activePreference->preferred_duration ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="student-pref-item">
                                    <span class="student-pref-label">Intensitas</span>
                                    <span class="student-pref-value">{{ $activePreference->preferred_intensity ?? '—' }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- =====================================================
             SECTION 5: PERJALANANMU (GRAFIK / EMPTY STATE)
        ====================================================== --}}
        <div class="row g-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 w-100">
                    <div class="card-body p-4">

                        <div class="d-flex align-items-center gap-2 mb-4">
                            <div class="student-widget-icon-wrap">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                                </svg>
                            </div>
                            <h6 class="fw-bold mb-0 student-widget-title">Grafik Perubahan Tingkat Stres</h6>
                        </div>

                        @php
                            $hasChartData = isset($chartData) && isset($labels) && count($labels) > 0;
                        @endphp

                        @if ($hasChartData)
                            {{-- Ada data: tampilkan grafik --}}
                            <div class="position-relative">
                                <div class="chart chart-sm">
                                    <canvas id="pssTrendChart"></canvas>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center flex-wrap gap-4 mt-4">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="dashboard-legend-dot dashboard-legend-low"></span>
                                    <small class="text-muted fw-medium">Rendah</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="dashboard-legend-dot dashboard-legend-medium"></span>
                                    <small class="text-muted fw-medium">Sedang</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="dashboard-legend-dot dashboard-legend-high"></span>
                                    <small class="text-muted fw-medium">Tinggi</small>
                                </div>
                            </div>
                        @else
                            {{-- Belum ada data: empty state ramah --}}
                            <div class="student-chart-empty text-center py-4">
                                <div class="student-chart-empty-illustration mb-4">
                                    <svg width="120" height="100" viewBox="0 0 120 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <ellipse cx="60" cy="88" rx="48" ry="8" fill="#E8F5EE" opacity="0.6"/>
                                        <rect x="10" y="60" width="8" height="28" rx="4" fill="#B8D8C8"/>
                                        <rect x="26" y="45" width="8" height="43" rx="4" fill="#A5C8B5"/>
                                        <rect x="42" y="52" width="8" height="36" rx="4" fill="#B8D8C8"/>
                                        <rect x="58" y="35" width="8" height="53" rx="4" fill="#8FBDAA"/>
                                        <rect x="74" y="48" width="8" height="40" rx="4" fill="#A5C8B5"/>
                                        <rect x="90" y="38" width="8" height="50" rx="4" fill="#8FBDAA"/>
                                        <rect x="106" y="55" width="8" height="33" rx="4" fill="#B8D8C8"/>
                                        <circle cx="90" cy="28" r="14" fill="#D4EAE0"/>
                                        <path d="M86 28 Q90 22 94 28" stroke="#7BAD98" stroke-width="2" stroke-linecap="round" fill="none"/>
                                        <circle cx="87" cy="26" r="1.5" fill="#7BAD98"/>
                                        <circle cx="93" cy="26" r="1.5" fill="#7BAD98"/>
                                    </svg>
                                </div>
                                <p class="student-chart-empty-title fw-semibold mb-1">Grafik ini akan menemanimu</p>
                                <p class="text-muted small mb-4">
                                    Setelah pengecekan pertama, kamu bisa melihat perkembanganmu di sini. Yuk mulai langkah pertamamu hari ini!
                                </p>
                                <a href="{{ route('pss-assessments.create') }}" class="student-chart-empty-btn">
                                    Mulai Langkah Pertama →
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        {{-- =======================================================
             DATA BRIDGE + SCRIPT INISIALISASI CHART.JS
        ======================================================== --}}
        @if (isset($chartData) && isset($labels) && count($labels) > 0)
            <script id="dashboard-student-data" type="application/json">
                {!! json_encode([
                    'labels' => $labels,
                    'scores' => $scores,
                    'stressLevels' => $stressLevels,
                ]) !!}
            </script>
        @endif

    @endif

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script
        src="{{ asset('assets-admin/js/dashboard.js') }}?v={{ filemtime(public_path('assets-admin/js/dashboard.js')) }}">
    </script>
@endpush
