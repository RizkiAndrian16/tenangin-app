@extends('layouts.main')
@section('title', 'Final Recommendation - Tenangin.')
@section('content')

    @if (auth()->user()->isMahasiswa())
        <x-stepper :current-step="4" />
    @endif

    @if (session('success'))
        <div class="profile-success-alert mb-4" id="successAlert">
            <div class="d-flex align-items-start gap-3">
                <div class="profile-success-icon">
                    <i data-feather="check-circle"></i>
                </div>

                <div>
                    <h6 class="fw-bold mb-1">Sukses!</h6>
                    <p class="mb-0">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- ======================================
        CARD 1: SUMMARY (STRES & PREFERENSI)
    ====================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4 p-md-5">
            <div class="text-center border-bottom pb-4 mb-4">
                <h2 class="fw-bold mb-2">Final Rekomendasi Aktivitas</h2>
                <p class="text-muted mb-0">Rekomendasi aktivitas relaksasi yang disesuaikan dengan tingkat stres dan preferensi Anda.</p>
            </div>
            <div class="row g-4 align-items-stretch">

                {{-- Kolom 1: Skor Stres --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div
                            class="score-hero-bg p-4 h-100 d-flex flex-column justify-content-center align-items-center text-center">
                            <div class="score-circle mx-auto mb-3 score-circle-{{ strtolower($stressLevel) }}">
                                <div class="score-circle-inner">
                                    <span class="score-number score-number-{{ strtolower($stressLevel) }}">
                                        {{ $pssAssessment->total_score }}
                                    </span>
                                    <span class="score-max">/ 40</span>
                                </div>
                            </div>

                            <p class="text-muted small mb-3 custom-dark-text">Skor PSS-10</p>
                            <p class="text-muted small mb-2 custom-dark-text">Tingkat Stres Anda</p>

                            <div>
                                @if ($stressLevel == 'Rendah')
                                    <span class="badge badge-soft-success rounded-pill px-3 py-2 fs-6">😌 Rendah</span>
                                @elseif ($stressLevel == 'Sedang')
                                    <span class="badge badge-soft-warning rounded-pill px-3 py-2 fs-6">😐 Sedang</span>
                                @else
                                    <span class="badge badge-soft-danger rounded-pill px-3 py-2 fs-6">😟 Tinggi</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom 2: Preferensi Pengguna --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100 activity-item-card">
                        <div class="card-body p-4 p-xl-5 d-flex flex-column justify-content-center">
                            <div class="row align-items-center g-4">

                                {{-- Sisi Kiri: Header & Deskripsi --}}
                                <div class="col-md-5">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="icon-box-soft icon-box-success flex-shrink-0">
                                            <i data-feather="sliders"></i>
                                        </div>
                                        <h5 class="fw-bold mb-0">Preferensi Aktivitas Anda</h5>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        Rekomendasi disesuaikan dengan preferensi aktivitas yang telah Anda pilih.
                                    </p>
                                </div>

                                {{-- Sisi Kanan: Daftar Atribut (Disusun Vertikal) --}}
                                <div class="col-md-7">
                                    <div class="d-flex flex-column gap-3">

                                        {{-- Jenis Aktivitas --}}
                                        <div
                                            class="d-flex justify-content-between align-items-center rounded-3 p-3 border-soft-success shadow-sm bg-white">
                                            <span class="text-muted small fw-medium">Jenis Aktivitas</span>
                                            <span
                                                class="fw-bold small text-dark text-end">{{ $activePreference->preferred_activity_type }}</span>
                                        </div>

                                        {{-- Durasi --}}
                                        <div
                                            class="d-flex justify-content-between align-items-center rounded-3 p-3 border-soft-success shadow-sm bg-white">
                                            <span class="text-muted small fw-medium">Durasi</span>
                                            <span
                                                class="fw-bold small text-dark text-end">{{ $activePreference->preferred_duration }}</span>
                                        </div>

                                        {{-- Intensitas --}}
                                        <div
                                            class="d-flex justify-content-between align-items-center rounded-3 p-3 border-soft-success shadow-sm bg-white">
                                            <span class="text-muted small fw-medium">Intensitas</span>
                                            <span
                                                class="fw-bold small text-dark text-end">{{ $activePreference->preferred_intensity }}</span>
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
        CARD 2: DAFTAR REKOMENDASI FINAL
    ====================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">

            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="icon-box-soft icon-box-success flex-shrink-0">
                        <i data-feather="award"></i>
                    </div>
                    <h5 class="fw-bold mb-0">Rekomendasi Aktivitas Terbaik</h5>
                </div>
                <p class="text-muted small mb-0">
                    Aktivitas diurutkan berdasarkan tingkat kecocokan dengan preferensi aktivitas Anda.
                </p>
            </div>

            {{-- List Aktivitas --}}
            <div class="row g-4">
                @forelse ($recommendationItems as $index => $item)
                    @php
                        $activity = $item->activity;
                        $similarityScore = $item->similarity_score;
                        $matchingScore = round($similarityScore * 7);
                        $percentage = number_format($similarityScore * 100, 0);
                    @endphp

                    <div class="col-lg-6 {{ $index >= 2 ? 'd-none hidden-recommendation' : '' }}">
                        <div class="card activity-item-card shadow-sm rounded-4 h-100">
                            <div class="card-body p-4 d-flex flex-column">

                                {{-- HEADER --}}
                                <div class="mb-2 pb-2 d-flex justify-content-between align-items-start gap-3">
                                    <div>
                                        <h5 class="fw-bold mb-1 text-dark activity-item-title">
                                            {{ $loop->iteration }}. {{ $activity->title }}
                                        </h5>
                                        <p class="text-muted small mb-0">{{ $activity->activity_type }}</p>
                                    </div>

                                    <div class="text-end flex-shrink-0">
                                        <h4 class="fw-bold text-success mb-1">
                                            {{ $percentage }}%
                                        </h4>
                                        <p class="text-muted small mb-0">Kecocokan</p>
                                    </div>
                                </div>

                                {{-- ATTRIBUTE KOTAK --}}
                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-md-4">
                                        <div class="score-hero-bg rounded-3 p-3 h-100 border-soft-success">
                                            <p class="fw-bold small mb-1">Durasi</p>
                                            <p class="text-muted small mb-0">
                                                {{ $activity->duration_category }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="score-hero-bg rounded-3 p-3 h-100 border-soft-success">
                                            <p class="fw-bold small mb-1">Intensitas</p>
                                            <p class="text-muted small mb-0">
                                                {{ $activity->intensity_level }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="score-hero-bg rounded-3 p-3 h-100 border-soft-success">
                                            <p class="fw-bold small mb-1">Tingkat Kecocokan</p>
                                            <p class="text-muted small mb-0">
                                                {{ $matchingScore }} / 7
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <p class="fw-bold mb-1">Deskripsi Aktivitas</p>
                                    <p class="text-muted small mb-0">{{ $activity->description }}</p>
                                </div>

                                {{-- FOOTER (Mulai Aktivitas) --}}
                                <div
                                    class="mt-auto pt-4 border-top custom-top-divider d-flex flex-column align-items-center gap-2">
                                    @if ($item)
                                        <a href="{{ route('feedbacks.focus', $item->id) }}"
                                            class="btn btn-soft-success rounded-pill px-4 py-2 force-focus-hover">
                                            Mulai Aktivitas
                                        </a>
                                    @else
                                        <button type="button" class="btn btn-soft-secondary rounded-pill px-4 py-2"
                                            disabled>
                                            Memuat...
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="p-5 text-center">
                            <div class="mb-3 text-muted">
                                <i data-feather="info" class="empty-state-icon"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Rekomendasi Belum Tersedia</h5>
                            <p class="text-muted mb-0">
                                Belum ada rekomendasi yang sesuai dengan preferensi yang dipilih. Silakan ubah preferensi Anda dan coba lagi.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- TOMBOL LIHAT LAINNYA --}}
            @if ($recommendationItems->count() > 2)
                <div class="text-center mt-4 mb-0" id="showMoreContainer">
                    <button type="button" id="btnShowMore"
                        class="btn btn-soft-secondary rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                        <span class="fw-medium">Lihat rekomendasi lainnya</span>
                        <i data-feather="chevron-down"></i>
                    </button>
                </div>
            @endif

            {{-- PERBAIKAN: Seluruh wrapper disembunyikan di HP (d-none) agar garis border juga hilang --}}
            <div class="d-none d-md-flex justify-content-md-center gap-2 border-top pt-4 mt-4">
                <a href="{{ route('pss-assessments.index') }}"
                    class="btn btn-soft-secondary rounded-pill px-4 py-2 d-flex align-items-center justify-content-center gap-2">
                    <i data-feather="arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>
@endsection
