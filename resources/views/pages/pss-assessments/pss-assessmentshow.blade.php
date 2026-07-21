@extends('layouts.main')
@section('title', 'Detail PSS Assessment - Tenangin.')
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Detail PSS-10 Assessment</h1>
            <p class="text-muted mb-0">
                Hasil pengukuran tingkat stres menggunakan PSS-10
                @if (auth()->user()->role === 'admin')
                    milik <strong class="text-dark">{{ $pssAssessment->user->name }}</strong>.
                @endif
            </p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4 pb-4">

            @if (auth()->user()->role === 'admin')
                {{-- =========================================================
                     TAMPILAN KHUSUS ADMIN (TATA LETAK BARU: ATAS & BAWAH)
                ========================================================== --}}

                {{-- BARIS 1: SKOR & INFORMASI MAHASISWA --}}
                <div class="row g-4 mb-3 mb-lg-4">

                    {{-- KIRI: SKOR HERO --}}
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden bg-light">
                            <div
                                class="score-hero-bg p-4 h-100 d-flex flex-column justify-content-center align-items-center text-center">

                                <div
                                    class="score-circle mx-auto mb-3 score-circle-{{ strtolower($pssAssessment->stress_level) }}">
                                    <div class="score-circle-inner">
                                        <span
                                            class="score-number score-number-{{ strtolower($pssAssessment->stress_level) }}">
                                            {{ $pssAssessment->total_score }}
                                        </span>
                                        <span class="score-max">/ 40</span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3 custom-dark-text">Total Skor PSS-10</p>

                                <p class="text-muted small mb-2 custom-dark-text">Tingkat Stres</p>
                                @if ($pssAssessment->stress_level == 'Rendah')
                                    <span class="badge badge-soft-success rounded-pill px-3 py-2 fs-6 mb-0">😌 Rendah</span>
                                @elseif ($pssAssessment->stress_level == 'Sedang')
                                    <span class="badge badge-soft-warning rounded-pill px-3 py-2 fs-6 mb-0">😐 Sedang</span>
                                @else
                                    <span class="badge badge-soft-danger rounded-pill px-3 py-2 fs-6 mb-0">😟 Tinggi</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- KANAN: INFORMASI MAHASISWA --}}
                    <div class="col-lg-8">
                        <div class="card border shadow-sm rounded-4 h-100">
                            <div class="card-body p-4 pb-3 pb-lg-4 d-flex flex-column justify-content-center">

                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="icon-box-soft icon-box-success flex-shrink-0">
                                        <i data-feather="user"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Informasi Mahasiswa</h5>
                                </div>
                                <p class="text-muted small mb-4">Profil akademik dan personal peserta assessment.</p>

                                <div class="row g-4">
                                    {{-- BARIS 1 --}}
                                    <div class="col-md-6 border-bottom pb-2">
                                        <small class="text-muted d-block mb-1">Nama Lengkap</small>
                                        <span class="fw-bold text-dark">{{ $pssAssessment->user->name }}</span>
                                    </div>
                                    <div class="col-md-6 border-bottom pb-2">
                                        <small class="text-muted d-block mb-1">Waktu Pengerjaan</small>
                                        <span
                                            class="fw-bold text-dark">{{ $pssAssessment->created_at->translatedFormat('l, d F Y - H:i') }}</span>
                                    </div>

                                    {{-- BARIS 2 --}}
                                    <div class="col-md-6 border-bottom pb-2">
                                        <small class="text-muted d-block mb-1">Universitas</small>
                                        <span
                                            class="fw-bold text-dark">{{ $pssAssessment->user->university ?? 'Belum diisi' }}</span>
                                    </div>
                                    <div class="col-md-6 border-bottom pb-2">
                                        <small class="text-muted d-block mb-1">Jurusan & Semester</small>
                                        <span class="fw-bold text-dark">
                                            {{ $pssAssessment->user->major ?? 'Belum diisi' }}
                                            @if ($pssAssessment->user->semester)
                                                (Semester {{ $pssAssessment->user->semester }})
                                            @endif
                                        </span>
                                    </div>

                                    {{-- BARIS 3 --}}
                                    <div class="col-md-6 border-bottom pb-2">
                                        <small class="text-muted d-block mb-1">Jenis Kelamin & Umur</small>
                                        <span class="fw-bold text-dark">
                                            {{ $pssAssessment->user->gender ?? 'Belum diisi' }}
                                            @if ($pssAssessment->user->age)
                                                ({{ $pssAssessment->user->age }} Tahun)
                                            @endif
                                        </span>
                                    </div>
                                    {{-- Tambahan class no-border-hp untuk menjaga layout HP --}}
                                    <div class="col-md-6 border-bottom pb-1 pb-md-2 no-border-hp">
                                        <small class="text-muted d-block mb-1">Tempat Tinggal</small>
                                        <span
                                            class="fw-bold text-dark">{{ $pssAssessment->user->residence_status ?? 'Belum diisi' }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                {{-- BARIS 2: TABEL RINCIAN JAWABAN (FULL WIDTH) --}}
                <div class="row g-3 g-lg-4 mb-2">
                    <div class="col-12">
                        <div class="card border shadow-sm rounded-4">
                            <div class="card-body p-4">

                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="icon-box-soft icon-box-success flex-shrink-0">
                                        <i data-feather="list"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Rincian Jawaban Kuesioner</h5>
                                </div>
                                <p class="text-muted small mb-4">Data respons mentah dari ke-10 pertanyaan PSS-10.</p>

                                @php
                                    $questions = [
                                        1 => 'Seberapa sering kamu merasa kecewa karena sesuatu yang terjadi secara tidak terduga?',
                                        2 => 'Seberapa sering kamu merasa tidak mampu mengendalikan hal-hal penting dalam hidupmu?',
                                        3 => 'Seberapa sering kamu merasa gelisah dan stres?',
                                        4 => 'Seberapa sering kamu merasa percaya diri dengan kemampuanmu untuk menyelesaikan masalah pribadi?',
                                        5 => 'Seberapa sering kamu merasa segala sesuatu berjalan sesuai keinginanmu?',
                                        6 => 'Seberapa sering kamu mengetahui bahwa kamu tidak bisa mengatasi hal-hal yang harus kamu lakukan?',
                                        7 => 'Seberapa sering kamu mampu mengendalikan hal-hal yang menjengkelkan dalam hidupmu?',
                                        8 => 'Seberapa sering kamu merasa mampu mengendalikan permasalahanmu?',
                                        9 => 'Seberapa sering kamu marah karena hal-hal yang terjadi di luar kendalimu?',
                                        10 => 'Seberapa sering kamu merasa tidak mampu menyelesaikan permasalahan-permasalahan yang menumpuk dalam hidupmu?',
                                    ];
                                    $options = [
                                        0 => 'Tidak Pernah',
                                        1 => 'Hampir Tidak Pernah',
                                        2 => 'Kadang-kadang',
                                        3 => 'Cukup Sering',
                                        4 => 'Sangat Sering',
                                    ];
                                @endphp

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle mb-0">
                                        <thead class="table-light text-center">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="50%">Pertanyaan</th>
                                                <th width="25%">Jawaban Dipilih</th>
                                                <th width="20%">Skor Mentah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pssAssessment->answers as $answer)
                                                <tr>
                                                    <td class="text-center fw-medium">{{ $answer->question_number }}</td>
                                                    <td>{{ $questions[$answer->question_number] ?? 'Pertanyaan tidak diketahui' }}
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge badge-soft-secondary rounded-pill">
                                                            {{ $options[$answer->answer_score] ?? '-' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <strong class="fs-6">{{ $answer->answer_score }}</strong>
                                                        @if (in_array($answer->question_number, [4, 5, 7, 8]))
                                                            <small class="text-muted d-block mt-1 reverse-scoring-note">
                                                                Nilai dibalik
                                                            </small>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-4">Data jawaban
                                                        tidak ditemukan di database.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- =========================================================
                     TAMPILAN KHUSUS MAHASISWA (3 KOLOM KODE LAMA)
                ========================================================== --}}
                <div class="row g-4 mb-4 align-items-stretch">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                            <div
                                class="score-hero-bg p-4 h-100 d-flex flex-column justify-content-center align-items-center text-center">

                                <div
                                    class="score-circle mx-auto mb-3 score-circle-{{ strtolower($pssAssessment->stress_level) }}">
                                    <div class="score-circle-inner">
                                        <span
                                            class="score-number score-number-{{ strtolower($pssAssessment->stress_level) }}">
                                            {{ $pssAssessment->total_score }}
                                        </span>
                                        <span class="score-max">/ 40</span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3 custom-dark-text">Skor PSS-10</p>

                                <p class="text-muted small mb-2 custom-dark-text">Tingkat Stres</p>
                                @if ($pssAssessment->stress_level == 'Rendah')
                                    <span class="badge badge-soft-success rounded-pill px-3 py-2 fs-6 mb-3">😌 Rendah</span>
                                @elseif ($pssAssessment->stress_level == 'Sedang')
                                    <span class="badge badge-soft-warning rounded-pill px-3 py-2 fs-6 mb-3">😐 Sedang</span>
                                @else
                                    <span class="badge badge-soft-danger rounded-pill px-3 py-2 fs-6 mb-3">😟 Tinggi</span>
                                @endif

                                <div class="d-flex gap-4 mt-2 justify-content-center">
                                    <div class="text-center">
                                        <p class="text-muted small mb-1">Tanggal</p>
                                        <p class="fw-bold mb-0">
                                            {{ $pssAssessment->created_at->translatedFormat('l, d F Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4 d-flex flex-column">

                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <div class="icon-box-soft icon-box-success">
                                        <i data-feather="info"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Tentang Skor</h5>
                                </div>

                                <p class="text-muted small mb-3 about-score-text custom-dark-text">
                                    PSS-10 membantu mengukur tingkat stres yang dirasakan dalam kehidupan sehari-hari selama
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
                                            Jangan tunggu sampai stres meningkat. Mulai kelola perasaan dari sekarang, satu
                                            langkah kecil sudah cukup. 🌤️
                                        </p>
                                    @else
                                        <p class="text-muted small mb-0 about-score-text">
                                            Jangan khawatir, setiap langkah kecil menuju ketenangan tetap berarti. Mulai
                                            dari yang mudah dulu. 🌱
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <div
                                        class="icon-box-soft @if ($pssAssessment->stress_level == 'Rendah') icon-box-success @elseif($pssAssessment->stress_level == 'Sedang') icon-box-warning @else icon-box-danger @endif">
                                        <i data-feather="activity"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Interpretasi Hasil</h5>
                                </div>

                                @if ($pssAssessment->stress_level == 'Rendah')
                                    <div class="alert-soft-success rounded-3 p-3 mb-3 flex-grow-1">
                                        <h6 class="fw-bold mb-2">Tingkat Stres Rendah</h6>
                                        <p class="mb-0 small">Stres saat ini tergolong rendah. Pertahankan kebiasaan
                                            positif dan pola aktivitas harian yang sudah berjalan baik agar stres tetap
                                            terkendali.</p>
                                    </div>
                                @elseif ($pssAssessment->stress_level == 'Sedang')
                                    <div class="alert-soft-warning rounded-3 p-3 mb-3 flex-grow-1">
                                        <h6 class="fw-bold mb-2">Tingkat Stres Sedang</h6>
                                        <p class="mb-0 small">Stres mulai terasa dalam aktivitas sehari-hari. Disarankan
                                            mulai melakukan aktivitas relaksasi secara rutin agar stres tidak semakin
                                            meningkat.</p>
                                    </div>
                                @else
                                    <div class="alert-soft-danger rounded-3 p-3 mb-3 flex-grow-1">
                                        <h6 class="fw-bold mb-2">Tingkat Stres Tinggi</h6>
                                        <p class="mb-0 small">Stres berada di tingkat yang cukup tinggi. Segera luangkan
                                            waktu untuk beristirahat dan lakukan aktivitas relaksasi secara rutin agar stres
                                            dapat dikelola dengan lebih baik.</p>
                                    </div>
                                @endif

                                <div class="mt-auto pt-3 border-top">
                                    <p class="text-muted small mb-0 custom-dark-text">
                                        Rekomendasi aktivitas relaksasi disesuaikan dengan tingkat stres ini. 🎯
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ==========================================
                 NAVIGASI FOOTER
            =========================================== --}}
            <div @class([
                'gap-3 border-top footer-navigation-padding pt-4',
                'd-flex justify-content-end justify-content-md-between' =>
                    auth()->user()->role === 'mahasiswa' &&
                    $pssAssessment->recommendations->count() == 0 &&
                    $pssAssessment->created_at->diffInMinutes(now()) <= 60,
                'd-none d-md-flex justify-content-center' => !(
                    auth()->user()->role === 'mahasiswa' &&
                    $pssAssessment->recommendations->count() == 0 &&
                    $pssAssessment->created_at->diffInMinutes(now()) <= 60
                ),
            ])>

                {{-- TOMBOL KEMBALI --}}
                <a href="{{ route('pss-assessments.index') }}"
                    class="btn btn-soft-secondary rounded-pill px-4 py-2 d-none d-md-flex align-items-center justify-content-center gap-2">
                    <i data-feather="arrow-left" class="icon-16"></i>
                    <span class="fw-medium">Kembali</span>
                </a>

                {{-- TOMBOL AKSI --}}
                @if (auth()->user()->role === 'mahasiswa' &&
                        $pssAssessment->recommendations->count() == 0 &&
                        $pssAssessment->created_at->diffInMinutes(now()) <= 60)
                    <a href="{{ route('recommendations.index', $pssAssessment->id) }}"
                        class="btn btn-soft-success rounded-pill px-3 px-sm-4 py-2 d-flex align-items-center justify-content-center gap-2 flex-fill flex-md-grow-0">
                        <span class="fw-medium">Lihat Kandidat Aktivitas</span>
                        <i data-feather="arrow-right" class="icon-16"></i>
                    </a>
                @endif

            </div>
        </div>
    </div>
@endsection
