@extends('layouts.main')
@section('title', 'Detail Evaluasi - Tenangin.')
@section('content')

    @php
        $activity = $feedback->recommendationItem->activity;
        $pss = $feedback->recommendationItem->recommendation->pssAssessment;
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">
                {{ auth()->user()->role === 'admin' ? 'Detail Evaluasi: ' . ($feedback->user->name ?? 'Mahasiswa') : 'Detail Evaluasi Aktivitas' }}
            </h1>
            <p class="text-muted mb-0">
                {{ auth()->user()->role === 'admin'
                    ? 'Rincian umpan balik mahasiswa untuk sesi relaksasi ini.'
                    : 'Rincian umpan balik yang Anda berikan setelah sesi relaksasi.' }}
            </p>
        </div>
    </div>

    {{-- BUNGKUS UTAMA: GRID DALAM SATU CARD DASAR --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-xl-5">
            <div class="row g-4">

                {{-- ======================================
                    KOLOM KIRI: KONTEKS AKTIVITAS (col-lg-4)
                ====================================== --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 score-hero-bg">
                        <div class="card-body p-4 p-xl-5 d-flex flex-column align-items-center text-center">

                            {{-- SETUP KELAS WARNA BERDASARKAN LEVEL STRES --}}
                            @php
                                $stressLevel = $pss->stress_level ?? '';
                                $circleClass = 'score-circle-rendah';
                                $textClass = 'score-number-rendah';
                                $badgeClass = 'badge-soft-success';
                                $emoji = '😊';

                                if ($stressLevel == 'Sedang') {
                                    $circleClass = 'score-circle-sedang';
                                    $textClass = 'score-number-sedang';
                                    $badgeClass = 'badge-soft-warning';
                                    $emoji = '😐';
                                } elseif ($stressLevel == 'Tinggi') {
                                    $circleClass = 'score-circle-tinggi';
                                    $textClass = 'score-number-tinggi';
                                    $badgeClass = 'badge-soft-danger';
                                    $emoji = '😫';
                                }
                            @endphp

                            {{-- 1. PSS SCORE HERO --}}
                            <div class="score-circle {{ $circleClass }} mb-4 mt-2">
                                <div class="score-circle-inner">
                                    <span class="score-number {{ $textClass }}">{{ $pss->total_score ?? '0' }}</span>
                                    <span class="score-max">/ 40</span>
                                </div>
                            </div>

                            <p class="text-muted small fw-medium mb-2">Kondisi Stres Saat Itu (PSS-10)</p>
                            <span class="badge {{ $badgeClass }} rounded-pill px-4 py-2 fs-6 mb-4">
                                {{ $emoji }} {{ $stressLevel ?: 'Tidak Diketahui' }}
                            </span>

                            <hr class="w-100 my-3 custom-top-divider">

                            {{-- 2. AKTIVITAS RELAKSASI --}}
                            <p class="text-muted small fw-medium mb-2 mt-2">Aktivitas Relaksasi</p>
                            <h6 class="fw-bold mb-2 lh-base px-2">{{ $activity->title ?? 'Aktivitas Dihapus' }}</h6>
                            <span class="badge badge-soft-success rounded-pill px-3 py-1 mb-3">
                                {{ $activity->activity_type ?? '-' }}
                            </span>

                            <hr class="w-100 my-3 custom-top-divider">

                            {{-- 3. TANGGAL PELAKSANAAN --}}
                            <p class="text-muted small fw-medium mb-1 mt-2">Tanggal Pelaksanaan</p>
                            <p class="fw-bold text-dark mb-0 fs-6">
                                {{ $feedback->created_at->translatedFormat('l, d F Y') }} <br>
                                <span class="text-muted fw-normal small">{{ $feedback->created_at->format('H:i') }}
                                    WIB</span>
                            </p>

                        </div>
                    </div>
                </div>

                {{-- ======================================
            KOLOM KANAN: FEEDBACK & INDIKATOR (col-lg-8)
        ====================================== --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 p-xl-5">

                            {{-- ================= SEKSI 1: HASIL UMPAN BALIK DENGAN RATING ================= --}}
                            <div
                                class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4 pb-3 border-bottom border-divider-soft">

                                {{-- Sisi Kiri: Judul --}}
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-box-soft icon-box-success flex-shrink-0">
                                        <i data-feather="check-square"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Hasil Umpan Balik</h5>
                                </div>

                                {{-- Sisi Kanan: Rating Bintang --}}
                                <div class="d-flex align-items-center gap-1 justify-content-center justify-content-sm-end">
                                    @php
                                        $rating = $feedback->overall_rating ?? 0;
                                    @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        <i data-feather="star"
                                            class="star-rating-readonly {{ $i <= $rating ? 'filled' : 'empty' }}"></i>
                                    @endfor

                                    @if ($rating == 0)
                                        <span class="text-muted ms-2 fst-italic text-12">(Belum dinilai)</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row g-3">
                                {{-- Status Penyelesaian --}}
                                <div class="col-12 col-md-6">
                                    <div
                                        class="p-4 rounded-4 feedback-result-box shadow-sm text-center h-100 d-flex flex-column justify-content-center">
                                        <p class="text-muted small fw-medium mb-2">Status Penyelesaian</p>
                                        @if ($feedback->is_completed)
                                            <div
                                                class="d-flex justify-content-center align-items-center gap-2 text-success fw-bold fs-6">
                                                <i data-feather="check-circle" class="icon-20"></i> Ya, Selesai
                                            </div>
                                        @else
                                            <div
                                                class="d-flex justify-content-center align-items-center gap-2 text-danger fw-bold fs-6">
                                                <i data-feather="x-circle" class="icon-20"></i> Tidak Selesai
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Manfaat Aktivitas --}}
                                <div class="col-12 col-md-6">
                                    <div
                                        class="p-4 rounded-4 feedback-result-box shadow-sm text-center h-100 d-flex flex-column justify-content-center">
                                        <p class="text-muted small fw-medium mb-2">Manfaat Aktivitas</p>
                                        @if ($feedback->is_helpful === true)
                                            <div
                                                class="d-flex justify-content-center align-items-center gap-2 text-success fw-bold fs-6">
                                                <i data-feather="thumbs-up" class="icon-20"></i> Bermanfaat
                                            </div>
                                        @elseif ($feedback->is_helpful === false)
                                            <div
                                                class="d-flex justify-content-center align-items-center gap-2 text-danger fw-bold fs-6">
                                                <i data-feather="thumbs-down" class="icon-20"></i> Tidak Bermanfaat
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- ================= SEKSI 2: INDIKATOR RELAKSASI ================= --}}
                            <div class="d-flex align-items-center gap-3 mb-4 mt-5 pb-3 border-bottom border-divider-soft">
                                <div class="icon-box-soft icon-box-warning flex-shrink-0">
                                    <i data-feather="bar-chart-2"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Indikator Relaksasi</h5>
                            </div>

                            @if ($feedback->is_completed)
                                <div class="row g-3">
                                    {{-- Fungsi Bantuan untuk Visualisasi Skor Bulat --}}
                                    @php
                                        $renderScore = function ($score) {
                                            $html = '<div class="score-container">';
                                            for ($i = 1; $i <= 5; $i++) {
                                                $stateClass = $i == $score ? 'likert-active' : 'likert-inactive';
                                                $html .=
                                                    '<div class="likert-circle ' . $stateClass . '">' . $i . '</div>';
                                            }
                                            $html .= '</div>';
                                            return $html;
                                        };
                                    @endphp

                                    <div class="col-12 col-md-6">
                                        <div
                                            class="p-3 rounded-4 feedback-result-box shadow-sm text-center h-100 d-flex flex-column justify-content-center">
                                            <span class="fw-medium text-dark d-block mb-1">Ketenangan Perasaan</span>
                                            {!! $renderScore($feedback->calmness_score) !!}
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div
                                            class="p-3 rounded-4 feedback-result-box shadow-sm text-center h-100 d-flex flex-column justify-content-center">
                                            <span class="fw-medium text-dark d-block mb-1">Kenyamanan Aktivitas</span>
                                            {!! $renderScore($feedback->comfort_score) !!}
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div
                                            class="p-3 rounded-4 feedback-result-box shadow-sm text-center h-100 d-flex flex-column justify-content-center">
                                            <span class="fw-medium text-dark d-block mb-1">Pengurangan Stres</span>
                                            {!! $renderScore($feedback->stress_reduction_score) !!}
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div
                                            class="p-3 rounded-4 feedback-result-box shadow-sm text-center h-100 d-flex flex-column justify-content-center">
                                            <span class="fw-medium text-dark d-block mb-1">Kesediaan Mengulang</span>
                                            {!! $renderScore($feedback->willingness_score) !!}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-soft-warning border-0 rounded-4 text-center p-4 mt-3">
                                    <p class="mb-0">
                                        Detail indikator tidak tersedia karena
                                        {{ auth()->user()->role === 'admin' ? 'mahasiswa' : 'Anda' }}
                                        menandai aktivitas ini sebagai <strong>Tidak Selesai.</strong>
                                    </p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>

            {{-- PERBAIKAN: Seluruh wrapper disembunyikan di HP (d-none) agar border hilang --}}
            <div class="border-top pt-4 mt-5 d-none d-md-flex justify-content-md-center gap-2">
                <a href="{{ route('feedbacks.index') }}"
                    class="btn btn-soft-secondary rounded-pill px-4 py-2 d-flex align-items-center justify-content-center gap-2">
                    <i data-feather="arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>

        </div>
    </div>
@endsection
