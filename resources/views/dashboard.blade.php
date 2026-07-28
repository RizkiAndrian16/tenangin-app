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
                        Selamat Datang, {{ Auth::user()->name }}! 👋
                    </h4>
                    <p class="text-white mb-0 dashboard-hero-subtitle">
                        Pantau ringkasan data pengguna, assessment, aktivitas, dan feedback di sistem Tenangin.
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
                                    <span class="text-muted small">Total Aktivitas</span>
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
                                    <span class="text-muted small d-block mb-1">Total Assessment</span>
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
             DASHBOARD MAHASISWA
        ======================================================== --}}

        {{-- HEADER --}}
        <div class="mb-4">
            <div class="position-relative overflow-hidden rounded-4 shadow-sm p-4 p-md-5 p-lg-3 dashboard-hero-banner">

                <div class="position-absolute top-0 end-0 rounded-circle dashboard-hero-circle-top"></div>
                <div class="position-absolute bottom-0 end-0 rounded-circle dashboard-hero-circle-bottom"></div>

                <div class="position-relative">
                    <h4 class="fw-bold text-white mb-2 mb-lg-1">
                        Selamat Datang, {{ Auth::user()->name }}! 👋
                    </h4>
                    <p class="text-white mb-0 dashboard-hero-subtitle">
                        Pantau tingkat stres Anda dengan melakukan assessment PSS-10 dan lihat perkembangan relaksasi
                        Anda secara berkala.
                    </p>
                </div>
            </div>
        </div>

        {{-- =======================================================
             REMINDER KELENGKAPAN PROFIL
             Hanya tampil untuk mahasiswa dengan profil belum lengkap
        ======================================================== --}}
        @if (Auth::user()->isMahasiswa() && !Auth::user()->hasCompleteProfile())
            <div class="dashboard-profile-reminder mb-4">
                <div class="dashboard-profile-reminder-content">

                    <div class="dashboard-profile-reminder-main">
                        <div class="dashboard-profile-reminder-icon">
                            <i data-feather="user-check"></i>
                        </div>

                        <div class="dashboard-profile-reminder-text">
                            <h6>Lengkapi profilmu</h6>

                            <p>
                                Yuk, isi sedikit info profilmu dulu. Setelah itu, kamu bisa langsung mencoba assessment
                                PSS-10 dan melihat rekomendasi relaksasi yang pas buatmu.
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}"
                        class="btn rounded-pill px-4 py-2 fw-medium d-flex align-items-center justify-content-center flex-shrink-0 text-white text-nowrap dashboard-profile-reminder-button">
                        Lengkapi Profil
                        <i data-feather="chevron-right" class="ms-1 icon-18"></i>
                    </a>
                </div>
            </div>
        @endif

        {{-- =======================================================
             BAGIAN 1: HERO CTA (Mulai Assessment)
        ======================================================== --}}
        <div class="row g-4 mb-1">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div
                        class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 p-4 rounded-4 hero-cta-card">

                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="bg-success d-flex align-items-center justify-content-center flex-shrink-0 rounded-4 shadow-sm icon-box-60">
                                <i data-feather="activity" class="icon-26 text-white"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">Mulai PSS-10 Assessment</h5>
                                <p class="text-muted small mb-0">
                                    Lakukan evaluasi untuk mengetahui tingkat stres Anda hari ini dan dapatkan
                                    rekomendasi aktivitas.
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('pss-assessments.create') }}"
                            class="btn btn-success rounded-pill px-4 py-2 fw-medium d-flex align-items-center justify-content-center flex-shrink-0 text-white text-nowrap">
                            Mulai Tes Sekarang
                            <i data-feather="chevron-right" class="ms-1 icon-18"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- =======================================================
             BAGIAN 2 & 3: STATISTIK, STRES TERAKHIR, & PREFERENSI
        ======================================================== --}}
        <div class="row g-4 mb-4">

            {{-- KOLOM 1: TINGKAT STRES TERAKHIR (Dipindah ke Kiri - Prioritas 1) --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div
                        class="card-body p-4 d-flex flex-column justify-content-center align-items-center text-center h-100">

                        <div
                            class="score-circle mx-auto mb-4 dashboard-score-circle {{ $lastAssessment ? 'score-circle-' . strtolower($lastAssessment->stress_level) : 'dashboard-score-circle-empty' }}">
                            <div class="score-circle-inner">
                                <span
                                    class="score-number dashboard-score-number {{ $lastAssessment ? 'score-number-' . strtolower($lastAssessment->stress_level) : 'dashboard-score-number-empty' }}">
                                    {{ $stressScore }}
                                </span>
                                <span
                                    class="score-max dashboard-score-max {{ !$lastAssessment ? 'dashboard-score-max-empty' : '' }}">/40</span>
                            </div>
                        </div>

                        <span class="text-muted small mb-3">Tingkat Stres Terakhir</span>

                        @if (!$lastAssessment)
                            <span class="badge badge-soft-secondary rounded-pill mb-3">Belum Ada</span>
                        @elseif ($lastAssessment->stress_level == 'Rendah')
                            <span class="badge badge-soft-success rounded-pill px-3 py-1 fw-medium mb-3">😌 Rendah</span>
                        @elseif ($lastAssessment->stress_level == 'Sedang')
                            <span class="badge badge-soft-warning rounded-pill px-3 py-1 fw-medium mb-3">😐 Sedang</span>
                        @else
                            <span class="badge badge-soft-danger rounded-pill px-3 py-1 fw-medium mb-3">😟 Tinggi</span>
                        @endif

                        <span class="text-muted dashboard-date-text">
                            @if ($lastAssessment)
                                {{ $lastAssessment->created_at->format('d M Y') }}
                            @else
                                Anda belum melakukan tes
                            @endif
                        </span>

                    </div>
                </div>
            </div>

            {{-- KOLOM 2: KARAKTERISTIK RELAKSASI AKTIF (Dipindah ke Tengah - Prioritas 2) --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 d-flex flex-column justify-content-center">

                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="icon-box-soft icon-box-success rounded-3 flex-shrink-0">
                                <i data-feather="sliders"></i>
                            </div>
                            <h6 class="fw-bold mb-0 text-dark">Preferensi Aktivitas Relaksasi</h6>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            <div
                                class="d-flex justify-content-between align-items-center rounded-3 p-3 border-soft-success shadow-sm bg-white">
                                <span class="text-muted fw-medium small">Jenis Aktivitas</span>
                                <span
                                    class="text-dark fw-bold small text-end">{{ $activePreference->preferred_activity_type ?? '-' }}</span>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center rounded-3 p-3 border-soft-success shadow-sm bg-white">
                                <span class="text-muted fw-medium small">Durasi Aktivitas</span>
                                <span
                                    class="text-dark fw-bold small text-end">{{ $activePreference->preferred_duration ?? '-' }}</span>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center rounded-3 p-3 border-soft-success shadow-sm bg-white">
                                <span class="text-muted fw-medium small">Intensitas Aktivitas</span>
                                <span
                                    class="text-dark fw-bold small text-end">{{ $activePreference->preferred_intensity ?? '-' }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- KOLOM 3: STATISTIK (Dipindah ke Kanan - Prioritas 3) --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 d-flex flex-column justify-content-center h-100">

                        <div class="d-flex align-items-center pb-3 mb-3 border-bottom">
                            <div class="d-flex flex-column">
                                <h5 class="fw-bold mb-0 text-dark">{{ $totalAssessments }}</h5>
                                <span class="text-muted small">Total Assessment</span>
                            </div>
                            <div class="icon-box-soft icon-box-success rounded-circle flex-shrink-0 ms-auto icon-48">
                                <i data-feather="clipboard" class="icon-20"></i>
                            </div>
                        </div>

                        <div class="d-flex align-items-center pb-3 mb-3 border-bottom">
                            <div class="d-flex flex-column">
                                <h5 class="fw-bold mb-0 text-dark">{{ $totalRecommendations }}</h5>
                                <span class="text-muted small">Total Rekomendasi</span>
                            </div>
                            <div class="icon-box-soft icon-box-success rounded-circle flex-shrink-0 ms-auto icon-48">
                                <i data-feather="activity" class="icon-20"></i>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h5 class="fw-bold mb-0 text-dark">{{ $totalFeedbacks }}</h5>
                                <span class="text-muted small">Feedback</span>
                            </div>
                            <div class="icon-box-soft icon-box-success rounded-circle flex-shrink-0 ms-auto icon-48">
                                <i data-feather="message-square" class="icon-20"></i>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- =======================================================
             BAGIAN 4: GRAFIK (GAYA MODERN TENANGIN)
        ======================================================== --}}
        <div class="row g-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 w-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-soft icon-box-success me-3">
                                <i data-feather="trending-up"></i>
                            </div>
                            <h6 class="fw-bold mb-0">Grafik Perubahan Tingkat Stres</h6>
                        </div>

                        {{-- KANVAS SELALU DI-RENDER --}}
                        <div class="position-relative">
                            <div class="chart chart-sm">
                                <canvas id="pssTrendChart"></canvas>
                            </div>
                        </div>

                        {{-- KETERANGAN WARNA SELALU TAMPIL --}}
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
                    </div>
                </div>
            </div>
        </div>

        {{-- =======================================================
             DATA BRIDGE + SCRIPT INISIALISASI CHART.JS
        ======================================================== --}}
        @if (isset($chartData))
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

    <script>
        window.ChartJS4 = window.Chart;
    </script>

    <script
        src="{{ asset('assets-admin/js/dashboard.js') }}?v={{ filemtime(public_path('assets-admin/js/dashboard.js')) }}">
    </script>
@endpush
