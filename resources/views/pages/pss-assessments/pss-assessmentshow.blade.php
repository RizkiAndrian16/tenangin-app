@extends('layouts.main')
@section('title', 'Detail PSS Assessment - Tenangin App')
@section('content')

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Detail PSS Assessment</h1>
            <p class="text-muted mb-0">Hasil pengukuran tingkat stres menggunakan PSS-10.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- CARD DASAR --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4 pb-4">

            {{-- 3 CARD DI DALAM --}}
            <div class="row g-4 mb-4 align-items-stretch">

                {{-- SCORE HERO CARD --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div
                            class="score-hero-bg p-4 h-100 d-flex flex-column justify-content-center align-items-center text-center">

                            <div
                                class="score-circle mx-auto mb-3 score-circle-{{ strtolower($pssAssessment->stress_level) }}">
                                <div class="score-circle-inner">
                                    <span class="score-number score-number-{{ strtolower($pssAssessment->stress_level) }}">
                                        {{ $pssAssessment->total_score }}
                                    </span>
                                    <span class="score-max">/ 40</span>
                                </div>
                            </div>
                            <p class="text-muted small mb-3 custom-dark-text">Skor PSS-10 Anda</p>

                            <p class="text-muted small mb-2 custom-dark-text">Tingkat Stres</p>
                            @if ($pssAssessment->stress_level == 'Rendah')
                                <span class="badge badge-soft-success rounded-pill px-3 py-2 fs-6 mb-3">
                                    😌 Rendah
                                </span>
                            @elseif ($pssAssessment->stress_level == 'Sedang')
                                <span class="badge badge-soft-warning rounded-pill px-3 py-2 fs-6 mb-3">
                                    😐 Sedang
                                </span>
                            @else
                                <span class="badge badge-soft-danger rounded-pill px-3 py-2 fs-6 mb-3">
                                    😟 Tinggi
                                </span>
                            @endif

                            <div class="d-flex gap-4 mt-2 justify-content-center">
                                <div class="text-center">
                                    <p class="text-muted small mb-1">Tanggal</p>
                                    <p class="fw-semibold mb-0">
                                        {{ $pssAssessment->created_at->translatedFormat('l, d F Y') }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-muted small mb-1">Waktu</p>
                                    <p class="fw-semibold mb-0">{{ $pssAssessment->created_at->format('H:i') }} WIB</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- TENTANG SKOR --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 d-flex flex-column">

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="icon-box-soft icon-box-success">
                                    <i data-feather="info"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Tentang Skor Anda</h5>
                            </div>

                            <p class="text-muted small mb-3 about-score-text custom-dark-text">
                                PSS-10 membantu mengukur tingkat stres yang Anda rasakan dalam kehidupan sehari-hari selama
                                sebulan terakhir.
                            </p>

                            <div class="score-range-list">
                                <div
                                    class="score-range-item {{ $pssAssessment->stress_level == 'Rendah' ? 'active-range-success' : '' }}">
                                    <span class="range-label">0 – 13</span>
                                    <strong><span class="range-desc">Stres Rendah</span></strong>
                                </div>
                                <div
                                    class="score-range-item {{ $pssAssessment->stress_level == 'Sedang' ? 'active-range-warning' : '' }}">
                                    <span class="range-label">14 – 26</span>
                                    <strong><span class="range-desc">Stres Sedang</span></strong>
                                </div>
                                <div
                                    class="score-range-item {{ $pssAssessment->stress_level == 'Tinggi' ? 'active-range-danger' : '' }}">
                                    <span class="range-label">27 – 40</span>
                                    <strong><span class="range-desc">Stres Tinggi</span></strong>
                                </div>
                            </div>

                            <div class="mt-auto pt-3 border-top custom-top-divider">
                                @if ($pssAssessment->stress_level == 'Rendah')
                                    <p class="text-muted small mb-0 about-score-text">
                                        Pertahankan terus kondisi ini. Konsistensi adalah kunci kesehatan mental jangka
                                        panjang. 🌿
                                    </p>
                                @elseif ($pssAssessment->stress_level == 'Sedang')
                                    <p class="text-muted small mb-0 about-score-text">
                                        Jangan tunggu sampai stres meningkat. Mulai kelola perasaan Anda dari sekarang, satu
                                        langkah kecil sudah cukup. 🌤️
                                    </p>
                                @else
                                    <p class="text-muted small mb-0 about-score-text">
                                        Jangan khawatir, setiap langkah kecil menuju ketenangan tetap berarti. Mulai dari
                                        yang mudah dulu. 🌱
                                    </p>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                {{-- INTERPRETASI --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 d-flex flex-column">

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div
                                    class="icon-box-soft
                                    @if ($pssAssessment->stress_level == 'Rendah') icon-box-success
                                    @elseif($pssAssessment->stress_level == 'Sedang') icon-box-warning
                                    @else icon-box-danger @endif">
                                    <i data-feather="activity"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Interpretasi Hasil</h5>
                            </div>

                            @if ($pssAssessment->stress_level == 'Rendah')
                                <div class="alert-soft-success rounded-3 p-3 mb-3 flex-grow-1">
                                    <h6 class="fw-bold mb-2">Tingkat Stres Rendah</h6>
                                    <p class="mb-0 small">Stres Anda saat ini tergolong rendah. Pertahankan kebiasaan
                                        positif dan pola aktivitas harian yang sudah berjalan baik agar stres tetap
                                        terkendali.</p>
                                </div>
                            @elseif ($pssAssessment->stress_level == 'Sedang')
                                <div class="alert-soft-warning rounded-3 p-3 mb-3 flex-grow-1">
                                    <h6 class="fw-bold mb-2">Tingkat Stres Sedang</h6>
                                    <p class="mb-0 small">Stres Anda mulai terasa dalam aktivitas sehari-hari. Disarankan
                                        mulai melakukan aktivitas relaksasi secara rutin agar stres tidak semakin meningkat.
                                    </p>
                                </div>
                            @else
                                <div class="alert-soft-danger rounded-3 p-3 mb-3 flex-grow-1">
                                    <h6 class="fw-bold mb-2">Tingkat Stres Tinggi</h6>
                                    <p class="mb-0 small">Stres Anda berada di tingkat yang cukup tinggi. Segera luangkan
                                        waktu untuk beristirahat dan lakukan aktivitas relaksasi secara rutin agar stres
                                        dapat dikelola dengan lebih baik.</p>
                                </div>
                            @endif

                            <div class="mt-auto pt-3 border-top">
                                <p class="text-muted small mb-0 custom-dark-text">
                                    Temukan rekomendasi aktivitas relaksasi yang disesuaikan dengan tingkat stres Anda. 🎯
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            {{-- TOMBOL NAVIGASI DI DALAM CARD DASAR --}}
            <div class="d-flex justify-content-between align-items-center border-top"
                style="padding-top: 28px; padding-bottom: 4px;">
                <a href="{{ route('pss-assessments.index') }}"
                    class="btn btn-soft-secondary rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                    <i data-feather="arrow-left"></i>
                    <span>Kembali</span>
                </a>

                <button class="btn btn-soft-success rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                    <span>Lihat Rekomendasi Aktivitas</span>
                    <i data-feather="arrow-right"></i>
                </button>
            </div>

        </div>
    </div>

@endsection
