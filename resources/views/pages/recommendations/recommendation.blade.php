@extends('layouts.main')
@section('title', 'Kandidat Aktivitas Relaksasi - Tenangin.')
@section('content')

    @if (auth()->user()->isMahasiswa())
        <x-stepper :current-step="3" />
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ==========================================
         CARD 1: SUMMARY (SCORE & RULE)
    =============================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4 p-md-5">
            <div class="text-center border-bottom pb-4 mb-4">
                <h2 class="fw-bold mb-2">Kandidat Aktivitas Relaksasi</h2>
                <p class="text-muted mb-0">Daftar kandidat aktivitas relaksasi yang sesuai dengan hasil pengukuran tingkat stres Anda.</p>
            </div>
            <div class="row g-4 align-items-stretch">

                {{-- KOLOM 1: SKOR & TINGKAT STRES --}}
                <div class="col-md-4">
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
                            <p class="text-muted small mb-2 custom-dark-text">Tingkat Stres</p>

                            @if ($stressLevel == 'Rendah')
                                <span class="badge badge-soft-success rounded-pill px-3 py-2 fs-6 mb-2">
                                    😌 Rendah
                                </span>
                            @elseif ($stressLevel == 'Sedang')
                                <span class="badge badge-soft-warning rounded-pill px-3 py-2 fs-6 mb-2">
                                    😐 Sedang
                                </span>
                            @else
                                <span class="badge badge-soft-danger rounded-pill px-3 py-2 fs-6 mb-2">
                                    😟 Tinggi
                                </span>
                            @endif

                        </div>
                    </div>
                </div>

                {{-- KOLOM 2: HASIL RULE-BASED --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 d-flex flex-column">

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div
                                    class="icon-box-soft
                                    @if ($stressLevel == 'Rendah') icon-box-success
                                    @elseif($stressLevel == 'Sedang') icon-box-warning
                                    @else icon-box-danger @endif">
                                    <i data-feather="cpu"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Penyaringan Aktivitas</h5>
                            </div>

                            @if ($stressLevel == 'Rendah')
                                <div class="alert-soft-success rounded-3 p-3 mb-3 flex-grow-1">
                                    <h6 class="fw-bold mb-2">Kategori Aman</h6>
                                    <p class="mb-0 small">Sistem merekomendasikan aktivitas relaksasi yang aman untuk membantu
                                        menjaga tingkat stres Anda tetap rendah dan stabil.</p>
                                </div>
                            @elseif ($stressLevel == 'Sedang')
                                <div class="alert-soft-warning rounded-3 p-3 mb-3 flex-grow-1">
                                    <h6 class="fw-bold mb-2">Kategori Menengah</h6>
                                    <p class="mb-0 small">Sistem merekomendasikan aktivitas relaksasi dengan intensitas ringan hingga
                                        sedang untuk meredakan stres sesuai dengan kondisi Anda.</p>
                                </div>
                            @else
                                <div class="alert-soft-danger rounded-3 p-3 mb-3 flex-grow-1">
                                    <h6 class="fw-bold mb-2">Kategori Prioritas</h6>
                                    <p class="mb-0 small">Sistem merekomendasikan aktivitas relaksasi dengan intensitas ringan agar 
                                        lebih nyaman untuk dijalankan.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- KOLOM 3: PETUNJUK SELANJUTNYA --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="icon-box-soft icon-box-success">
                                    <i data-feather="map"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Langkah Berikutnya</h5>
                            </div>

                            <div class="alert-soft-success rounded-3 p-3 mb-3 flex-grow-1">
                                <h6 class="fw-bold mb-2">1. Tinjau Kandidat</h6>
                                <p class="mb-3 small">Lihat daftar kandidat aktivitas yang tersedia.</p>

                                <h6 class="fw-bold mb-2">2. Tentukan Preferensi</h6>
                                <p class="mb-0 small">Isi preferensi jenis, durasi, dan intensitas aktivitas yang Anda sukai.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==========================================
         CARD 2: DAFTAR KANDIDAT AKTIVITAS
    =============================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-2 mb-4">
                <div class="icon-box-soft icon-box-success">
                    <i data-feather="list"></i>
                </div>
                <h5 class="fw-bold mb-0">Daftar Kandidat Aktivitas Relaksasi yang Direkomendasikan</h5>
            </div>

            <div class="row g-4">
                @forelse ($rules as $rule)
                    <div class="col-lg-6">

                        {{-- Menggunakan class baru .activity-item-card --}}
                        <div class="card activity-item-card shadow-sm rounded-4 h-100">
                            <div class="card-body p-4 d-flex flex-column">

                                {{-- Judul Aktivitas menggunakan class .activity-item-title --}}
                                <div class="mb-3 border-bottom pb-3">
                                    <h5 class="fw-bold mb-0 text-dark activity-item-title">
                                        {{ $loop->iteration }}. {{ $rule->activity->title }}
                                    </h5>
                                </div>

                                <div class="row g-3 mb-4">
                                    {{-- Kotak Jenis Aktivitas --}}
                                    <div class="col-12 col-md-4">
                                        <div class="score-hero-bg rounded-3 p-3 h-100 border-soft-success">
                                            <p class="fw-bold small mb-1">Jenis Aktivitas</p>
                                            <p class="text-muted small mb-0">{{ $rule->activity->activity_type }}</p>
                                        </div>
                                    </div>

                                    {{-- Kotak Durasi --}}
                                    <div class="col-12 col-md-4">
                                        <div class="score-hero-bg rounded-3 p-3 h-100 border-soft-success">
                                            <p class="fw-bold small mb-1">Durasi Aktivitas</p>
                                            <p class="text-muted small mb-0">{{ $rule->activity->duration_category }}</p>
                                        </div>
                                    </div>

                                    {{-- Kotak Intensitas --}}
                                    <div class="col-12 col-md-4">
                                        <div class="score-hero-bg rounded-3 p-3 h-100 border-soft-success">
                                            <p class="fw-bold small mb-1">Intensitas Aktivitas</p>
                                            <p class="text-muted small mb-0">{{ $rule->activity->intensity_level }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <p class="fw-bold mb-1">Deskripsi Aktivitas</p>
                                    <p class="text-muted small mb-0">{{ $rule->activity->description }}</p>
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
                            <h5 class="fw-bold mb-2">Kandidat Aktivitas Belum Tersedia</h5>
                            <p class="text-muted mb-0">
                                Belum terdapat aktivitas relaksasi yang sesuai dengan aturan rekomendasi untuk tingkat stres
                                Anda saat ini.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ==========================================
         CARD 3: FORM PREFERENSI AKTIVITAS
    =============================================== --}}

    <div id="preferenceAlert" class="alert-soft-danger rounded-3 p-3 mb-4">
        Harap lengkapi semua pilihan preferensi aktivitas Anda sebelum melanjutkan.
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">

            {{-- Header Card Preferensi --}}
            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="icon-box-soft icon-box-success flex-shrink-0">
                        <i data-feather="sliders"></i>
                    </div>
                    <h5 class="fw-bold mb-0">Pilih Preferensi Aktivitas</h5>
                </div>
                <p class="text-muted small mb-0">
                    Pilih jenis, durasi, dan intensitas aktivitas yang Anda sukai.
                </p>
            </div>

            {{-- Form Input --}}
            <form id="preferenceForm" action="{{ route('recommendations.preferences', $pssAssessment->id) }}"
                method="POST">
                @csrf
                <div class="row g-4">
                    {{-- Jenis Aktivitas --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Jenis Aktivitas</label>
                        <select name="preferred_activity_type" class="form-select custom-input">
                            <option value="">Pilih jenis aktivitas</option>
                            @foreach ($activityTypes as $type)
                                <option value="{{ $type }}"
                                    {{ isset($lastPreference) && $lastPreference->preferred_activity_type == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Durasi --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Durasi Aktivitas</label>
                        <select name="preferred_duration" class="form-select custom-input">
                            <option value="">Pilih durasi aktivitas</option>
                            @foreach ($durations as $duration)
                                <option value="{{ $duration }}"
                                    {{ isset($lastPreference) && $lastPreference->preferred_duration == $duration ? 'selected' : '' }}>
                                    {{ $duration }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Intensitas --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Intensitas Aktivitas</label>
                        <select name="preferred_intensity" class="form-select custom-input">
                            <option value="">Pilih intensitas aktivitas</option>
                            @foreach ($intensities as $intensity)
                                <option value="{{ $intensity }}"
                                    {{ isset($lastPreference) && $lastPreference->preferred_intensity == $intensity ? 'selected' : '' }}>
                                    {{ $intensity }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            {{-- NAVIGASI BUTTON --}}
            <div class="d-flex justify-content-end justify-content-md-between gap-3 border-top mt-4 pt-4">

                {{-- KEMBALI: Disembunyikan di HP (d-none), Muncul di PC (d-md-flex) --}}
                <a href="{{ route('pss-assessments.show', $pssAssessment->id) }}"
                    class="btn btn-soft-secondary rounded-pill px-4 py-2 d-none d-md-flex align-items-center justify-content-center gap-2">
                    <i data-feather="arrow-left" class="icon-16"></i>
                    <span class="fw-medium">Kembali</span>
                </a>

                {{-- AKSI: Full memanjang di HP (flex-fill), normal di PC (flex-md-grow-0) --}}
                <button type="submit" form="preferenceForm"
                    class="btn btn-soft-success rounded-pill px-3 px-sm-4 py-2 d-flex align-items-center justify-content-center gap-2 flex-fill flex-md-grow-0 force-focus-hover">
                    <span class="fw-medium">Lihat Rekomendasi Final</span>
                    <i data-feather="arrow-right" class="icon-16"></i>
                </button>

            </div>
        </div>
    </div>
@endsection
