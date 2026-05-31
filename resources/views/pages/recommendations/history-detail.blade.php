@extends('layouts.main')
@section('title', 'Detail Riwayat Rekomendasi - Tenangin.')
@section('content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Detail Riwayat Rekomendasi</h1>
            <p class="text-muted mb-0">
                Snapshot hasil rekomendasi aktivitas pada {{ $recommendation->created_at->translatedFormat('l, d F Y') }}.
            </p>
        </div>
    </div>

    {{-- ======================================
        CARD 1: SUMMARY (STRES & PREFERENSI)
    ====================================== --}}
    @php
        $stressLevel = $recommendation->pssAssessment->stress_level ?? 'Tidak diketahui';
        $pref = $recommendation->userPreference;
    @endphp

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row g-4 align-items-stretch">
                {{-- Kolom 1: Skor Stres --}}
                {{-- Kolom 1: Skor Stres --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div
                            class="score-hero-bg p-4 h-100 d-flex flex-column justify-content-center align-items-center text-center">
                            <div class="score-circle mx-auto mb-3 score-circle-{{ strtolower($stressLevel) }}">
                                <div class="score-circle-inner">
                                    <span class="score-number score-number-{{ strtolower($stressLevel) }}">
                                        {{ $recommendation->pssAssessment->total_score ?? '-' }}
                                    </span>
                                    <span class="score-max">/ 40</span>
                                </div>
                            </div>

                            {{-- Penyesuaian teks agar sama dengan style halaman PSS-10 --}}
                            <p class="text-muted small mb-3 custom-dark-text">Skor PSS-10 Anda</p>
                            <p class="text-muted small mb-2 custom-dark-text">Tingkat Stres</p>

                            @if ($stressLevel == 'Rendah')
                                <span class="badge badge-soft-success rounded-pill px-3 py-2 fs-6 mb-3">😌 Rendah</span>
                            @elseif ($stressLevel == 'Sedang')
                                <span class="badge badge-soft-warning rounded-pill px-3 py-2 fs-6 mb-3">😐 Sedang</span>
                            @else
                                <span class="badge badge-soft-danger rounded-pill px-3 py-2 fs-6 mb-3">😟 Tinggi</span>
                            @endif

                            {{-- Menambahkan Tanggal dan Waktu (Snapshot History) --}}
                            <div class="d-flex gap-4 mt-2 justify-content-center">
                                <div class="text-center">
                                    <p class="text-muted small mb-1">Tanggal</p>
                                    <p class="fw-bold mb-0">
                                        {{ $recommendation->created_at->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom 2: Preferensi --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100 activity-item-card">
                        <div class="card-body p-4 p-xl-5 d-flex flex-column justify-content-center">
                            <div class="row align-items-center g-4">
                                <div class="col-md-5">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="icon-box-soft icon-box-success flex-shrink-0">
                                            <i data-feather="clock"></i>
                                        </div>
                                        <h5 class="fw-bold mb-0">Preferensi Saat Itu</h5>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        Kriteria yang Anda gunakan saat rekomendasi ini dihasilkan.
                                    </p>
                                </div>
                                <div class="col-md-7">
                                    <div class="d-flex flex-column gap-3">
                                        <div
                                            class="d-flex justify-content-between align-items-center rounded-3 p-3 border-soft-success shadow-sm bg-white">
                                            <span class="text-muted small fw-medium">Jenis Aktivitas</span>
                                            <span
                                                class="fw-bold small text-dark text-end">{{ $pref->preferred_activity_type ?? '-' }}</span>
                                        </div>
                                        <div
                                            class="d-flex justify-content-between align-items-center rounded-3 p-3 border-soft-success shadow-sm bg-white">
                                            <span class="text-muted small fw-medium">Durasi</span>
                                            <span
                                                class="fw-bold small text-dark text-end">{{ $pref->preferred_duration ?? '-' }}</span>
                                        </div>
                                        <div
                                            class="d-flex justify-content-between align-items-center rounded-3 p-3 border-soft-success shadow-sm bg-white">
                                            <span class="text-muted small fw-medium">Intensitas</span>
                                            <span
                                                class="fw-bold small text-dark text-end">{{ $pref->preferred_intensity ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================
        CARD 2: DAFTAR REKOMENDASI (DARI DB)
    ====================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 activity-item-card">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="icon-box-soft icon-box-success flex-shrink-0">
                        <i data-feather="list"></i>
                    </div>
                    <h5 class="fw-bold mb-0">Riwayat Hasil Rekomendasi</h5>
                </div>
                <p class="text-muted small mb-0">Daftar aktivitas yang disarankan pada saat itu.</p>
            </div>

            <div class="row g-4">
                @forelse ($historyItems as $index => $item)
                    @php
                        $activity = $item->activity;
                        $percentage = number_format($item->similarity_score * 100, 0);

                        // KITA KALKULASI BALIK DISINI: similarity dikali 7 lalu dibulatkan
                        $matchingScore = round($item->similarity_score * 7);
                    @endphp

                    <div class="col-lg-6 {{ $index >= 2 ? 'd-none hidden-recommendation' : '' }}">
                        <div class="card activity-item-card shadow-sm rounded-4 h-100">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="mb-3 border-bottom pb-3 d-flex justify-content-between align-items-start gap-3">
                                    <div>
                                        <h5 class="fw-bold mb-1 text-dark activity-item-title">
                                            {{ $activity->title ?? 'Aktivitas Dihapus' }}</h5>
                                        <p class="text-muted small mb-0">{{ $activity->activity_type ?? '-' }}</p>
                                    </div>
                                    <div class="text-end flex-shrink-0">
                                        <h4 class="fw-bold text-success mb-1">{{ $percentage }}%</h4>
                                        <p class="text-muted small mb-0">Similarity</p>
                                    </div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-md-4">
                                        <div class="score-hero-bg rounded-3 p-3 h-100 border-soft-success">
                                            <p class="fw-bold small mb-1">Durasi</p>
                                            <p class="text-muted small mb-0">{{ $activity->duration_category ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="score-hero-bg rounded-3 p-3 h-100 border-soft-success">
                                            <p class="fw-bold small mb-1">Intensitas</p>
                                            <p class="text-muted small mb-0">{{ $activity->intensity_level ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="score-hero-bg rounded-3 p-3 h-100 border-soft-success">
                                            <p class="fw-bold small mb-1">Matching Score</p>

                                            {{-- SEKARANG KITA PANGGIL VARIABEL YANG BARU DIBUAT --}}
                                            <p class="text-muted small mb-0">{{ $matchingScore }} / 7</p>

                                        </div>
                                    </div>
                                </div>

                                @if (!empty($activity->instruction))
                                    <div class="mt-4 pt-3 border-top">
                                        <p class="fw-bold mb-3">Tips dan Konteks Pelaksanaan Aktivitas:</p>
                                        @php
                                            $steps = array_filter(
                                                array_map('trim', explode('.', $activity->instruction)),
                                            );
                                        @endphp
                                        <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                                            @foreach ($steps as $step)
                                                <li class="d-flex align-items-start gap-3 text-muted small">
                                                    <div class="text-success flex-shrink-0 list-icon-offset">
                                                        <i data-feather="check-circle" class="icon-16"></i>
                                                    </div>
                                                    <span class="lh-base">{{ $step }}.</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center text-muted p-4">Tidak ada detail aktivitas untuk riwayat ini.</div>
                    </div>
                @endforelse
            </div>

            @if ($historyItems->count() > 2)
                <div class="text-center mt-4 mb-4" id="showMoreContainer">
                    <button type="button" id="btnShowMore"
                        class="btn btn-soft-secondary rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                        <span class="fw-medium">Lihat rekomendasi lainnya</span>
                        <i data-feather="chevron-down"></i>
                    </button>
                </div>
            @endif

            {{-- NAVIGASI KEMBALI KE HISTORY --}}
            <div class="d-flex justify-content-center align-items-center flex-wrap gap-2 border-top pt-4">
                <a href="{{ route('recommendations.history') }}"
                    class="btn btn-soft-secondary rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                    <i data-feather="arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>
@endsection
