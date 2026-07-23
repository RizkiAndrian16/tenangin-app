@extends('layouts.main')
@section('title', 'Dashboard - Tenangin.')
@section('content')

    @if (Auth::user()->isAdmin())

        {{-- =======================================================
             DASHBOARD ADMIN
        ======================================================== --}}
        @php
            $totalUsers = \App\Models\User::count();
            $totalAssessments = \App\Models\PssAssessment::count();
            $totalActivities = \App\Models\Activity::count();
            $totalFeedbacks = \App\Models\Feedback::count();
            $totalRules = \App\Models\RuleBasedRule::count();
            $totalRecommendations = \App\Models\Recommendation::count();

            $usersHighStress = \App\Models\User::has('pssAssessments')
                ->get()
                ->filter(function ($user) {
                    $latest = $user->pssAssessments()->latest()->first();
                    return $latest && $latest->stress_level === 'Tinggi';
                })
                ->count();
        @endphp

        {{-- HEADER --}}
        <div class="mb-4">
            <div class="position-relative overflow-hidden rounded-4 shadow-sm p-4 p-md-5 p-lg-3"
                style="background: linear-gradient(135deg, #20c997 0%, #17a589 100%);">

                <div class="position-absolute top-0 end-0 rounded-circle"
                    style="width: 160px; height: 160px; background: rgba(255,255,255,0.08); transform: translate(40px, -60px);">
                </div>
                <div class="position-absolute bottom-0 end-0 rounded-circle"
                    style="width: 90px; height: 90px; background: rgba(255,255,255,0.06); transform: translate(10px, 25px);">
                </div>

                <div class="position-relative">
                    <h4 class="fw-bold text-white mb-2 mb-lg-1">
                        Selamat Datang, {{ Auth::user()->name }}! 👋
                    </h4>
                    <p class="text-white mb-0" style="opacity: 0.9;">
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
                                class="position-absolute text-decoration-underline small fw-medium"
                                style="top: 20px; right: 20px; color: #16A34A;">Lihat</a>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box-soft icon-box-success rounded-circle flex-shrink-0"
                                    style="width: 52px; height: 52px;">
                                    <i data-feather="users" style="width: 22px; height: 22px;"></i>
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
                                class="position-absolute text-decoration-underline small fw-medium"
                                style="top: 20px; right: 20px; color: #D97706;">Lihat</a>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box-soft icon-box-warning rounded-circle flex-shrink-0"
                                    style="width: 52px; height: 52px;">
                                    <i data-feather="grid" style="width: 22px; height: 22px;"></i>
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
                                class="position-absolute text-decoration-underline small fw-medium"
                                style="top: 20px; right: 20px; color: #0D9488;">Lihat</a>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box-soft rounded-circle flex-shrink-0"
                                    style="width: 52px; height: 52px; background: #CCFBF1; color: #0D9488;">
                                    <i data-feather="git-branch" style="width: 22px; height: 22px;"></i>
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
                                class="position-absolute text-decoration-underline small fw-medium"
                                style="top: 20px; right: 20px; color: #0284C7;">Lihat</a>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box-soft icon-box-primary rounded-circle flex-shrink-0"
                                    style="width: 52px; height: 52px;">
                                    <i data-feather="clipboard" style="width: 22px; height: 22px;"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $totalAssessments }}</h4>
                                    <span class="text-muted small d-block mb-1">Total Assessment</span>
                                    @if ($usersHighStress > 0)
                                        <a href="{{ route('pss-assessments.index', ['stress_level' => 'Tinggi']) }}"
                                            class="d-block small fw-medium text-decoration-underline"
                                            style="color: #DC2626;">
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
                                class="position-absolute text-decoration-underline small fw-medium"
                                style="top: 20px; right: 20px; color: #7C3AED;">Lihat</a>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box-soft rounded-circle flex-shrink-0"
                                    style="width: 52px; height: 52px; background: #EDE9FE; color: #7C3AED;">
                                    <i data-feather="clock" style="width: 22px; height: 22px;"></i>
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
                                class="position-absolute text-decoration-underline small fw-medium"
                                style="top: 20px; right: 20px; color: #DC2626;">Lihat</a>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box-soft icon-box-danger rounded-circle flex-shrink-0"
                                    style="width: 52px; height: 52px;">
                                    <i data-feather="message-square" style="width: 22px; height: 22px;"></i>
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
             GRAFIK TREN BULANAN (6 BULAN TERAKHIR)
        ======================================================== --}}
        @php
            $monthlyLabels = [];
            $monthlyUsers = [];
            $monthlyAssessments = [];
            $monthlyFeedbacks = [];

            // Ambil angka bulan saat ini (misal Juli = 7).
            // Dikurang 1 karena perhitungan subMonths dimulai dari 0 (bulan ini)
            $limit = now()->month - 1;

            // Looping dari bulan Januari tahun ini hingga bulan sekarang
            for ($i = $limit; $i >= 0; $i--) {
                $startOfMonth = now()->subMonths($i)->startOfMonth();
                $endOfMonth = now()->subMonths($i)->endOfMonth();

                // Format bulan dan tahun (Contoh: "Jan 2024")
                $monthlyLabels[] = $startOfMonth->format('M Y');

                // Tambahkan pengecekan role mahasiswa
                $monthlyUsers[] = \App\Models\User::where('role', 'mahasiswa')
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->count();

                $monthlyAssessments[] = \App\Models\PssAssessment::whereBetween('created_at', [
                    $startOfMonth,
                    $endOfMonth,
                ])->count();

                $monthlyFeedbacks[] = \App\Models\Feedback::whereBetween('created_at', [
                    $startOfMonth,
                    $endOfMonth,
                ])->count();
            }
        @endphp

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
                                        <div class="chart chart-sm" style="height: 200px;">
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
                                        <div class="chart chart-sm" style="height: 200px;">
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
                                        <div class="chart chart-sm" style="height: 200px;">
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
        @php
            $latestUsers = \App\Models\User::latest()->take(5)->get();
            $latestAssessments = \App\Models\PssAssessment::with('user')->latest()->take(5)->get();
            $latestFeedbacks = \App\Models\Feedback::with(['user', 'recommendationItem.activity'])
                ->latest()
                ->take(5)
                ->get();
        @endphp

        <div class="row g-4">
            <div class="col-12">
                {{-- BUNGKUSAN CARD UTAMA AKTIVITAS TERBARU --}}
                <div class="card border-0 shadow-sm rounded-4 w-100">
                    <div class="card-body p-4">

                        {{-- DERETAN 3 KOLOM AKTIVITAS --}}
                        {{-- DERETAN 3 KOLOM AKTIVITAS --}}
                        <div class="row g-4">

                            {{-- KOLOM 1: PENGGUNA BARU --}}
                            <div class="col-12 col-lg-4">
                                <div class="card border shadow-none rounded-4 h-100">
                                    {{-- Tambahkan d-flex flex-column di sini --}}
                                    <div class="card-body p-3 d-flex flex-column">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="icon-box-soft icon-box-success rounded-3 flex-shrink-0">
                                                <i data-feather="user-plus"></i>
                                            </div>
                                            <h6 class="fw-bold mb-0 text-dark">Pengguna Baru</h6>
                                        </div>

                                        @forelse ($latestUsers as $user)
                                            <div class="d-flex justify-content-between align-items-center {{ !$loop->last ? 'border-bottom' : '' }}"
                                                style="padding-top: 12px; padding-bottom: 12px;">
                                                <span class="small fw-medium text-dark">{{ $user->name }}</span>
                                                <span
                                                    class="text-muted text-11">{{ $user->created_at->diffForHumans() }}</span>
                                            </div>
                                        @empty
                                            {{-- Bungkus teks ke dalam kontainer penengah ini --}}
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
                                    {{-- Tambahkan d-flex flex-column di sini --}}
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
                                                    <span class="badge badge-soft-success rounded-pill"
                                                        style="font-size: 11px; padding: 4px 10px;">Rendah</span>
                                                @elseif ($assessment->stress_level == 'Sedang')
                                                    <span class="badge badge-soft-warning rounded-pill"
                                                        style="font-size: 11px; padding: 4px 10px;">Sedang</span>
                                                @else
                                                    <span class="badge badge-soft-danger rounded-pill"
                                                        style="font-size: 11px; padding: 4px 10px;">Tinggi</span>
                                                @endif

                                            </div>
                                        @empty
                                            {{-- Bungkus teks ke dalam kontainer penengah ini --}}
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
                                    {{-- Tambahkan d-flex flex-column di sini --}}
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
                                            {{-- Bungkus teks ke dalam kontainer penengah ini --}}
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
             SCRIPT GRAFIK TREN ADMIN
        ======================================================== --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            window.ChartJS4 = window.Chart;
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Konfigurasi Umum agar kodenya tidak berulang
                const commonOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#ffffff',
                            titleColor: '#212529',
                            bodyColor: '#6c757d',
                            borderColor: '#dee2e6',
                            borderWidth: 1,
                            padding: 10,
                            usePointStyle: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: 5, // Mencegah grafik loncat ekstrem saat data masih sedikit
                            ticks: {
                                precision: 0
                            },
                            grid: {
                                color: '#f8f9fa',
                                borderDash: [5, 5],
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                };

                const labels = {!! json_encode($monthlyLabels) !!};
                const usersData = {!! json_encode($monthlyUsers) !!};
                const assessmentsData = {!! json_encode($monthlyAssessments) !!};
                const feedbacksData = {!! json_encode($monthlyFeedbacks) !!};

                // 1. Chart Pengguna Baru (Line Chart)
                new ChartJS4(document.getElementById('newUserChart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Pengguna Baru',
                            data: usersData,
                            borderColor: '#22c55e',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            pointBackgroundColor: '#22c55e',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            tension: 0.4 // Membuat garis melengkung halus
                        }]
                    },
                    options: commonOptions
                });

                // 2. Chart Assessment (Line Chart)
                new ChartJS4(document.getElementById('assessmentChart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Assessment',
                            data: assessmentsData,
                            borderColor: '#0ea5e9',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            pointBackgroundColor: '#0ea5e9',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            tension: 0.4
                        }]
                    },
                    options: commonOptions
                });

                // 3. Chart Feedback (Line Chart)
                new ChartJS4(document.getElementById('feedbackChart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Feedback',
                            data: feedbacksData,
                            borderColor: '#f59e0b',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            pointBackgroundColor: '#f59e0b',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            tension: 0.4
                        }]
                    },
                    options: commonOptions
                });
            });
        </script>
    @else
        {{-- =======================================================
             DASHBOARD MAHASISWA
        ======================================================== --}}
        @php
            // 1. Data Grafik (10 Assessment Terakhir)
            $chartData = Auth::user()->pssAssessments()->latest()->take(10)->get()->reverse()->values();

            $labels = [];
            $scores = [];
            $pointColors = [];
            $stressLevels = [];

            foreach ($chartData as $item) {
                $labels[] = $item->created_at->format('d M');
                $scores[] = $item->total_score;
                $stressLevels[] = $item->stress_level;

                if ($item->stress_level == 'Rendah') {
                    $pointColors[] = '#20c997'; // Hijau
                } elseif ($item->stress_level == 'Sedang') {
                    $pointColors[] = '#fd7e14'; // Oranye
                } else {
                    $pointColors[] = '#dc3545'; // Merah
                }
            }

            // --- TAMBAHKAN 3 BARIS INI ---
            if (empty($labels)) {
                $labels = ['', '', '', '', '']; // Dummy label agar grid X terbentang
            }

            // 2. Data Tabel (5 Assessment Terakhir)
            $lastAssessment = Auth::user()->pssAssessments()->latest()->first();
        @endphp

        {{-- HEADER --}}
        <div class="mb-4">
            <div class="position-relative overflow-hidden rounded-4 shadow-sm p-4 p-md-5 p-lg-3"
                style="background: linear-gradient(135deg, #20c997 0%, #17a589 100%);">

                <div class="position-absolute top-0 end-0 rounded-circle"
                    style="width: 160px; height: 160px; background: rgba(255,255,255,0.08); transform: translate(40px, -60px);">
                </div>
                <div class="position-absolute bottom-0 end-0 rounded-circle"
                    style="width: 90px; height: 90px; background: rgba(255,255,255,0.06); transform: translate(10px, 25px);">
                </div>

                <div class="position-relative">
                    <h4 class="fw-bold text-white mb-2 mb-lg-1">
                        Selamat Datang, {{ Auth::user()->name }}! 👋
                    </h4>
                    <p class="text-white mb-0" style="opacity: 0.9;">
                        Pantau tingkat stres Anda dengan melakukan assessment PSS-10 dan lihat perkembangan relaksasi Anda
                        secara berkala.
                    </p>
                </div>
            </div>
        </div>

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
        @php
            $stressScore = $lastAssessment->total_score ?? 0;
        @endphp

        <div class="row g-4 mb-4">

            {{-- KOLOM 1: TINGKAT STRES TERAKHIR (Dipindah ke Kiri - Prioritas 1) --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div
                        class="card-body p-4 d-flex flex-column justify-content-center align-items-center text-center h-100">

                        <div class="score-circle mx-auto mb-4 {{ $lastAssessment ? 'score-circle-' . strtolower($lastAssessment->stress_level) : '' }}"
                            style="width: 110px; height: 110px; {{ !$lastAssessment ? 'box-shadow: 0 4px 20px rgba(148, 163, 184, 0.15);' : '' }}">
                            <div class="score-circle-inner">
                                <span
                                    class="score-number {{ $lastAssessment ? 'score-number-' . strtolower($lastAssessment->stress_level) : '' }}"
                                    style="font-size: 2rem; {{ !$lastAssessment ? 'color: #94A3B8;' : '' }}">
                                    {{ $stressScore }}
                                </span>
                                <span class="score-max"
                                    style="font-size: 0.8rem; {{ !$lastAssessment ? 'color: #CBD5E1;' : '' }}">/40</span>
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

                        <span class="text-muted" style="font-size: 13px;">
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
                                    class="text-dark fw-bold small text-end">{{ Auth::user()->activePreference->preferred_activity_type ?? '-' }}</span>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center rounded-3 p-3 border-soft-success shadow-sm bg-white">
                                <span class="text-muted fw-medium small">Durasi Aktivitas</span>
                                <span
                                    class="text-dark fw-bold small text-end">{{ Auth::user()->activePreference->preferred_duration ?? '-' }}</span>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center rounded-3 p-3 border-soft-success shadow-sm bg-white">
                                <span class="text-muted fw-medium small">Intensitas Aktivitas</span>
                                <span
                                    class="text-dark fw-bold small text-end">{{ Auth::user()->activePreference->preferred_intensity ?? '-' }}</span>
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
                                <h5 class="fw-bold mb-0 text-dark">{{ Auth::user()->pssAssessments()->count() }}</h5>
                                <span class="text-muted small">Total Assessment</span>
                            </div>
                            <div class="icon-box-soft icon-box-success rounded-circle flex-shrink-0 ms-auto"
                                style="width: 48px; height: 48px;">
                                <i data-feather="clipboard" style="width: 20px; height: 20px;"></i>
                            </div>
                        </div>

                        <div class="d-flex align-items-center pb-3 mb-3 border-bottom">
                            <div class="d-flex flex-column">
                                <h5 class="fw-bold mb-0 text-dark">{{ Auth::user()->recommendations()->count() }}</h5>
                                <span class="text-muted small">Total Rekomendasi</span>
                            </div>
                            <div class="icon-box-soft icon-box-success rounded-circle flex-shrink-0 ms-auto"
                                style="width: 48px; height: 48px;">
                                <i data-feather="activity" style="width: 20px; height: 20px;"></i>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h5 class="fw-bold mb-0 text-dark">{{ Auth::user()->feedbacks()->count() }}</h5>
                                <span class="text-muted small">Feedback</span>
                            </div>
                            <div class="icon-box-soft icon-box-success rounded-circle flex-shrink-0 ms-auto"
                                style="width: 48px; height: 48px;">
                                <i data-feather="message-square" style="width: 20px; height: 20px;"></i>
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
                                <span style="width:12px; height:12px; background:#20c997; border-radius:50%;"></span>
                                <small class="text-muted fw-medium">Rendah</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span style="width:12px; height:12px; background:#fd7e14; border-radius:50%;"></span>
                                <small class="text-muted fw-medium">Sedang</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span style="width:12px; height:12px; background:#dc3545; border-radius:50%;"></span>
                                <small class="text-muted fw-medium">Tinggi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- =======================================================
             SCRIPT INISIALISASI CHART.JS
        ======================================================== --}}
        @if (isset($chartData))
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                window.ChartJS4 = window.Chart;
            </script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const ctx = document.getElementById('pssTrendChart').getContext('2d');

                    const labels = {!! json_encode($labels) !!};
                    const scores = {!! json_encode($scores) !!};
                    const pointColors = {!! json_encode($pointColors) !!};
                    const stressLevels = {!! json_encode($stressLevels) !!};

                    new ChartJS4(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Skor',
                                data: scores,
                                borderColor: '#dee2e6',
                                borderWidth: 2,
                                backgroundColor: 'transparent',
                                pointBackgroundColor: pointColors,
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                pointRadius: 6,
                                pointHoverRadius: 8,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 15,
                                    right: 15
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: '#ffffff',
                                    titleColor: '#212529',
                                    bodyColor: '#6c757d',
                                    borderColor: '#dee2e6',
                                    borderWidth: 1,
                                    padding: 12,
                                    usePointStyle: true,
                                    callbacks: {
                                        label: function(context) {
                                            return ` Tingkat Stress: ${stressLevels[context.dataIndex]}`;
                                        },
                                        afterLabel: function(context) {
                                            return ` Skor: ${context.parsed.y} / 40`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    min: 0,
                                    max: 40,
                                    grid: {
                                        color: '#f8f9fa',
                                        borderDash: [5, 5],
                                        drawBorder: false
                                    },
                                    ticks: {
                                        stepSize: 5,
                                        precision: 0,
                                        autoSkip: false
                                    },
                                    afterBuildTicks: function(axis) {
                                        axis.ticks = [0, 5, 10, 15, 20, 25, 30, 35, 40].map(function(v) {
                                            return {
                                                value: v
                                            };
                                        });
                                    }
                                },
                                x: {
                                    offset: true,
                                    grid: {
                                        display: true,
                                        color: '#f8f9fa',
                                        borderDash: [5, 5],
                                        drawBorder: false
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        @endif

    @endif

@endsection
