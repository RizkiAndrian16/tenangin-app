@extends('layouts.main')
@section('title', 'Mode Fokus Pelaksanaan - Tenangin.')
@section('content')

    @php
        $activity = $recommendationItem->activity;
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Mode Fokus: Pelaksanaan</h1>
            <p class="text-muted mb-0">Ikuti instruksi dengan tenang dan gunakan timer di bawah ini.</p>
        </div>
    </div>

    {{-- ==========================================
         CARD UTAMA (PEMBUNGKUS BESAR)
    =============================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-4 p-md-5">

            <div class="row g-4 align-items-stretch mb-0 mb-md-5">

                {{-- ==========================================
                     CARD DALAM KIRI: INFO & TIMER
                =============================================== --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div class="score-hero-bg p-4 p-xl-5 h-100 d-flex flex-column justify-content-start text-center">

                            {{-- 1. JUDUL DI ATAS --}}
                            <h2 class="fw-bold text-dark mb-3 focus-title">{{ $activity->title }}</h2>

                            {{-- 2. TIPE, DURASI & INTENSITAS SEBARIS --}}
                            <div
                                class="d-flex flex-wrap justify-content-center align-items-center gap-3 gap-md-4 text-muted mb-5 focus-info-text">
                                <div class="d-flex align-items-center gap-1">
                                    <i data-feather="layers" class="icon-16"></i>
                                    <span>{{ $activity->activity_type ?? 'Aktivitas Relaksasi' }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <i data-feather="clock" class="icon-16"></i>
                                    <span id="durationText">{{ $activity->duration_category ?? '-' }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <i data-feather="activity" class="icon-16"></i>
                                    <span>Intensitas {{ $activity->intensity_level ?? '-' }}</span>
                                </div>
                            </div>

                            @if (str_contains($activity->duration_category, '>'))
                                <div
                                    class="flex-grow-1 d-flex flex-column align-items-center justify-content-center text-center">
                                    <div
                                        class="alert-soft-success text-success d-flex align-items-center justify-content-center mb-5 mt-n4 shadow-sm mx-auto focus-mode-icon-circle">
                                        <i data-feather="wind" class="icon-80"></i>
                                    </div>
                                    <h4 class="fw-bold text-dark mb-2">Mode Bebas Waktu</h4>
                                    <p class="text-muted text-center px-2 mb-0">Aktivitas ini dirancang untuk dilakukan
                                        dengan santai tanpa batasan waktu.</p>
                                </div>
                            @else
                                <div class="timer-container my-auto mb-1 timer-container-offset">
                                    <svg class="timer-svg" viewBox="0 0 200 200">
                                        <circle class="timer-svg-bg" cx="100" cy="100" r="90"></circle>

                                        <circle class="timer-svg-progress" id="timerCircle" cx="100" cy="100"
                                            r="90" stroke-dasharray="565.48" stroke-dashoffset="0">
                                        </circle>
                                    </svg>
                                    <div class="timer-text-overlay">
                                        <h1 class="fw-bolder mb-0 timer-display-text" id="timerDisplay">00:00</h1>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3 timer-intro-text" id="timerIntroText">
                                    Luangkan waktu sejenak untuk diri sendiri.<br>Klik mulai jika sudah siap.
                                </p>
                            @endif

                            {{-- Pendorong tombol ke bawah (mt-auto) --}}
                            <div class="mt-auto w-100">
                                @if (!str_contains($activity->duration_category, '>'))
                                    {{-- Wrapper tetap w-100 --}}
                                    <div class="d-flex justify-content-center flex-nowrap gap-2 mb-2 w-100">

                                        {{-- PERBAIKAN: Hapus w-100 dari setiap button dan kembalikan padding menjadi px-4 --}}
                                        <button type="button" id="btnStart"
                                            class="btn btn-soft-success rounded-pill px-4 py-2 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2 text-nowrap btn-focus-action">
                                            <i data-feather="play" class="icon-18"></i> Mulai
                                        </button>

                                        <button type="button" id="btnPause"
                                            class="btn btn-soft-warning rounded-pill px-4 py-2 fw-bold shadow-sm d-none justify-content-center align-items-center gap-2 text-nowrap btn-focus-action">
                                            <i data-feather="pause" class="icon-18"></i> Jeda
                                        </button>

                                        <button type="button" id="btnReset"
                                            class="btn btn-soft-danger rounded-pill px-4 py-2 fw-bold shadow-sm d-none justify-content-center align-items-center gap-2 text-nowrap btn-focus-action">
                                            <i data-feather="rotate-ccw" class="icon-18"></i> Ulangi
                                        </button>

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ==========================================
                     CARD DALAM KANAN: INSTRUKSI & SELESAI
                =============================================== --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 p-md-5 d-flex flex-column h-100">

                            <div class="d-flex align-items-center gap-2 mb-4">
                                <div class="icon-box-soft icon-box-success">
                                    <i data-feather="book-open"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Tips dan Konteks Pelaksanaan</h5>
                            </div>

                            @if ($activity->instruction)
                                @php
                                    $steps = array_filter(array_map('trim', explode('.', $activity->instruction)));
                                @endphp
                                <div class="alert-soft-success alert-white-text rounded-4 p-4 mb-4 flex-grow-1">
                                    @foreach ($steps as $index => $step)
                                        <p class="fw-bold text-dark mb-{{ $loop->last ? '0' : '3' }} fs-6">
                                            {{ $index + 1 }}. {{ $step }}.
                                        </p>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-soft-secondary rounded-4 p-4 flex-grow-1">
                                    Instruksi spesifik tidak tersedia.
                                </div>
                            @endif

                            {{-- Pendorong tombol ke bawah (mt-auto) --}}
                            <div class="text-center mt-auto pt-4 border-top">
                                <p class="text-muted small mb-3">Tekan tombol di bawah jika Anda sudah selesai melakukan
                                    aktivitas.</p>

                                {{-- PERBAIKAN: Membungkus dengan d-grid d-sm-flex agar memanjang di HP dan normal di PC --}}
                                <div class="d-grid d-sm-flex justify-content-sm-center">
                                    <a href="{{ route('feedbacks.create', $recommendationItem->id) }}"
                                        class="btn btn-soft-success rounded-pill px-4 py-2 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2">
                                        <i data-feather="check-circle" class="icon-18"></i>Selesai
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- PERBAIKAN: Mengganti d-grid menjadi d-none agar hilang di HP --}}
                <div class="col-12 pt-4 border-top d-none d-md-flex justify-content-md-center gap-2">
                    <a href="{{ route('recommendations.final', $recommendationItem->recommendation->pss_assessment_id) }}"
                        class="btn btn-soft-secondary rounded-pill px-4 py-2 d-flex align-items-center justify-content-center gap-2">
                        <i data-feather="arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
