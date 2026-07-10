@extends('layouts.main')
@section('title', 'Dashboard - Tenangin.')
@section('content')

    {{-- =======================================================
         PENGOLAHAN DATA DASHBOARD
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
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 p-4 rounded-4"
                    style="background-color: rgba(34, 197, 94, 0.05); border: 1.5px solid rgba(34, 197, 94, 0.4);">

                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success d-flex align-items-center justify-content-center flex-shrink-0 rounded-4 shadow-sm"
                            style="width: 60px; height: 60px;">
                            <i data-feather="activity" style="width: 26px; height: 26px; color: #fff;"></i>
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
                        class="btn btn-success rounded-pill px-4 py-2 fw-medium d-flex align-items-center justify-content-center flex-shrink-0 text-white"
                        style="white-space: nowrap;">
                        Mulai Tes Sekarang
                        <i data-feather="chevron-right" class="ms-1" style="width: 18px; height: 18px;"></i>
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
                <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center text-center h-100">

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
                        <span class="badge bg-light text-muted border rounded-pill px-3 py-1 fw-normal mb-3">Belum
                            Ada</span>
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

                    @if ($chartData->count() > 0)
                        <div class="chart chart-sm">
                            <canvas id="chartjs-dashboard-line"></canvas>
                        </div>
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
                    @else
                        {{-- PERBAIKAN: Ditambah text-center dan px-3 agar rapi di HP --}}
                        <div
                            class="d-flex flex-column justify-content-center align-items-center bg-light rounded-4 py-5 mt-3 px-3 text-center">
                            <div class="icon-box-soft icon-box-success mb-3">
                                <i data-feather="bar-chart-2"></i>
                            </div>
                            <p class="text-muted fw-medium mb-0">Belum ada data untuk menampilkan grafik.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- =======================================================
         SCRIPT INISIALISASI CHART.JS
    ======================================================== --}}
    @if (isset($chartData) && $chartData->count() > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById('chartjs-dashboard-line').getContext('2d');

                const labels = {!! json_encode($labels) !!};
                const scores = {!! json_encode($scores) !!};
                const pointColors = {!! json_encode($pointColors) !!};
                const stressLevels = {!! json_encode($stressLevels) !!};

                new Chart(ctx, {
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
                        // Menambahkan ruang kosong di sisi kiri & kanan grafik
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
                                // MENGUNCI GRAFIK AGAR TIDAK "AUTO-ZOOM"
                                min: 0,
                                max: 40,
                                grid: {
                                    color: '#f8f9fa',
                                    borderDash: [5, 5],
                                    drawBorder: false
                                },
                                ticks: {
                                    stepSize: 5, // Memaksa kelipatan 5 (0, 5, 10, 15... 40)
                                    precision: 0 // Menghapus titik desimal
                                }
                            },
                            x: {
                                // MENDORONG TITIK AGAR TIDAK MENTOK GARIS KIRI
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

@endsection
