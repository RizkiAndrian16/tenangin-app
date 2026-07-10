@extends('layouts.main')
@section('title', 'Final Recommendation - Tenangin.')
@section('content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Final Rekomendasi Aktivitas</h1>
            <p class="text-muted mb-0">
                Rekomendasi aktivitas relaksasi personal berdasarkan tingkat stres dan preferensi aktivitas pengguna.
            </p>
        </div>
    </div>

    {{-- ======================================
        CARD 1: SUMMARY (STRES & PREFERENSI)
    ====================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
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
                                        Sistem melakukan penyaringan aktivitas secara spesifik berdasarkan 3 kriteria yang
                                        telah Anda tentukan.
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

            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 activity-item-card">
                {{-- Bagian Atas: Ikon dan Judul Sejajar --}}
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="icon-box-soft icon-box-success flex-shrink-0">
                        <i data-feather="award"></i>
                    </div>
                    <h5 class="fw-bold mb-0">Final Recommendation Ranking</h5>
                </div>

                {{-- Bagian Bawah: Deskripsi --}}
                <p class="text-muted small mb-0">
                    Aktivitas relaksasi diurutkan berdasarkan similarity score tertinggi.
                </p>
            </div>

            {{-- List Aktivitas --}}
            <div class="row g-4">
                @forelse ($finalRecommendations as $index => $recommendation)
                    @php
                        $activity = $recommendation['activity'];
                        $similarityScore = $recommendation['similarity_score'];
                        $matchingScore = $recommendation['matching_score'];
                        $percentage = number_format($similarityScore * 100, 0);

                        // Ambil ID Recommendation Item secara dinamis untuk dimasukkan ke URL Mode Fokus
                        $recParent = \App\Models\Recommendation::where('pss_assessment_id', $pssAssessment->id)
                            ->where('user_id', Auth::id())
                            ->first();

                        $recItem = $recParent
                            ? \App\Models\RecommendationItem::where('recommendation_id', $recParent->id)
                                ->where('activity_id', $activity->id)
                                ->first()
                            : null;
                    @endphp

                    <div class="col-lg-6 {{ $index >= 2 ? 'd-none hidden-recommendation' : '' }}">
                        <div class="card activity-item-card shadow-sm rounded-4 h-100">
                            <div class="card-body p-4 d-flex flex-column">

                                {{-- HEADER --}}
                                <div class="mb-2 pb-2 d-flex justify-content-between align-items-start gap-3">
                                    <div>
                                        <h5 class="fw-bold mb-1 text-dark activity-item-title">{{ $activity->title }}</h5>
                                        <p class="text-muted small mb-0">{{ $activity->activity_type }}</p>
                                    </div>

                                    <div class="text-end flex-shrink-0">
                                        <h4 class="fw-bold text-success mb-1">
                                            {{ $percentage }}%
                                        </h4>
                                        <p class="text-muted small mb-0">Similarity</p>
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
                                            <p class="fw-bold small mb-1">Matching Score</p>
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
                                    @if ($recItem)
                                        <a href="{{ route('feedbacks.focus', $recItem->id) }}"
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
                            <h5 class="fw-bold mb-2">Final Recommendation Tidak Tersedia</h5>
                            <p class="text-muted mb-0">
                                Sistem belum dapat menghasilkan rekomendasi final berdasarkan preferensi pengguna saat ini.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- TOMBOL LIHAT LAINNYA --}}
            @if ($finalRecommendations->count() > 2)
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
