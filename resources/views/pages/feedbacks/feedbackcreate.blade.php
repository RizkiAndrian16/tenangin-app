@extends('layouts.main')
@section('title', 'Evaluasi Aktivitas - Tenangin.')
@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">

                    {{-- HEADER MODEL PSS --}}
                    <div class="text-center border-bottom pb-4 mb-4">
                        <h2 class="fw-bold mb-2">Evaluasi Aktivitas</h2>
                        <p class="text-muted mb-0">Bagaimana perasaan Anda setelah melakukan aktivitas tadi? Umpan balik Anda
                            membantu sistem kami menjadi lebih baik.</p>
                    </div>

                    {{-- BLOK ERROR STANDAR --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-4 mb-4">
                            <div class="d-flex align-items-start gap-3">
                                <i data-feather="alert-circle"></i>
                                <div>
                                    <h6 class="fw-bold mb-2">Validasi gagal</h6>
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('feedbacks.store', $recommendationItem->id) }}" method="POST" id="formFeedback">
                        @csrf

                        {{-- 1. Status Penyelesaian --}}
                        <div class="mb-2 question-item">
                            <div class="p-4 rounded-4 question-card shadow-sm">
                                <h6 class="fw-semibold mb-4">Apakah Anda berhasil menyelesaikan aktivitas relaksasinya?</h6>

                                <div class="d-grid d-md-flex gap-3">
                                    <input type="radio" class="btn-check feedback-radio" name="is_completed"
                                        id="completed_yes" value="1" required autocomplete="off">
                                    <label
                                        class="btn pss-option rounded-pill px-4 py-2 d-flex align-items-center justify-content-center gap-2"
                                        for="completed_yes">
                                        <i data-feather="check-circle" class="icon-18"></i> Ya, Selesai
                                    </label>

                                    <input type="radio" class="btn-check feedback-radio" name="is_completed"
                                        id="completed_no" value="0" required autocomplete="off">
                                    <label
                                        class="btn pss-option rounded-pill px-4 py-2 d-flex align-items-center justify-content-center gap-2"
                                        for="completed_no">
                                        <i data-feather="x-circle" class="icon-18"></i> Tidak Selesai
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- WRAPPER KUESIONER MODEL INDIVIDU --}}
                        <div id="evaluationQuestions">

                            {{-- 2. Penilaian Manfaat --}}
                            <div class="mb-4 question-item">
                                <div class="p-4 rounded-4 question-card shadow-sm">
                                    <h6 class="fw-semibold mb-4">Secara umum, apakah aktivitas ini terasa bermanfaat?</h6>

                                    <div class="d-grid d-md-flex gap-3 mb-0">
                                        <input type="radio" class="btn-check feedback-radio" name="is_helpful"
                                            id="helpful_yes" value="1" autocomplete="off">
                                        <label
                                            class="btn pss-option rounded-pill px-4 py-2 d-flex align-items-center justify-content-center gap-2"
                                            for="helpful_yes">
                                            <i data-feather="thumbs-up" class="icon-18"></i> Bermanfaat
                                        </label>

                                        <input type="radio" class="btn-check feedback-radio" name="is_helpful"
                                            id="helpful_no" value="0" autocomplete="off">
                                        <label
                                            class="btn pss-option rounded-pill px-4 py-2 d-flex align-items-center justify-content-center gap-2"
                                            for="helpful_no">
                                            <i data-feather="thumbs-down" class="icon-18"></i> Tidak Bermanfaat
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- INFO SKALA PENILAIAN LIKERT --}}
                            <div class="profile-alert-card alert-soft-success mb-2 rounded-3 border-0 p-3">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="likert-info-text">
                                        Berikan penilaian Anda pada skala <strong>1 (Sangat Tidak Setuju)</strong> hingga
                                        <strong>5 (Sangat Setuju)</strong> untuk pertanyaan di bawah ini.
                                    </div>
                                </div>
                            </div>

                            {{-- BUNGKUS DENGAN ROW UNTUK MEMBUAT GRID 2 KOLOM --}}
                            <div class="row g-2 mb-2">

                                {{-- 3. Likert: Ketenangan --}}
                                <div class="col-12 col-lg-6">
                                    <div class="question-item h-100">
                                        <div class="p-4 rounded-4 question-card shadow-sm h-100">
                                            <h6 class="fw-semibold mb-4">1. Seberapa tenang perasaan Anda setelah melakukan
                                                aktivitas ini?</h6>
                                            <div
                                                class="d-flex justify-content-center justify-content-md-start align-items-center gap-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <input type="radio" class="btn-check feedback-radio"
                                                        name="calmness_score" id="calm_{{ $i }}"
                                                        value="{{ $i }}" autocomplete="off">
                                                    <label
                                                        class="btn pss-option rounded-circle d-flex align-items-center justify-content-center fw-bold fs-5 likert-choice-circle"
                                                        for="calm_{{ $i }}">{{ $i }}</label>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- 4. Likert: Kenyamanan --}}
                                <div class="col-12 col-lg-6">
                                    <div class="question-item h-100">
                                        <div class="p-4 rounded-4 question-card shadow-sm h-100">
                                            <h6 class="fw-semibold mb-4">2. Seberapa nyaman aktivitas relaksasi yang
                                                dilakukan?</h6>
                                            <div
                                                class="d-flex justify-content-center justify-content-md-start align-items-center gap-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <input type="radio" class="btn-check feedback-radio"
                                                        name="comfort_score" id="comfort_{{ $i }}"
                                                        value="{{ $i }}" autocomplete="off">
                                                    <label
                                                        class="btn pss-option rounded-circle d-flex align-items-center justify-content-center fw-bold fs-5 likert-choice-circle"
                                                        for="comfort_{{ $i }}">{{ $i }}</label>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- 5. Likert: Pengurangan Stres --}}
                                <div class="col-12 col-lg-6">
                                    <div class="question-item h-100">
                                        <div class="p-4 rounded-4 question-card shadow-sm h-100">
                                            <h6 class="fw-semibold mb-4">3. Apakah aktivitas ini membantu mengurangi stres
                                                yang dirasakan?</h6>
                                            <div
                                                class="d-flex justify-content-center justify-content-md-start align-items-center gap-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <input type="radio" class="btn-check feedback-radio"
                                                        name="stress_reduction_score" id="stress_{{ $i }}"
                                                        value="{{ $i }}" autocomplete="off">
                                                    <label
                                                        class="btn pss-option rounded-circle d-flex align-items-center justify-content-center fw-bold fs-5 likert-choice-circle"
                                                        for="stress_{{ $i }}">{{ $i }}</label>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- 6. Likert: Kesediaan --}}
                                <div class="col-12 col-lg-6">
                                    <div class="question-item h-100">
                                        <div class="p-4 rounded-4 question-card shadow-sm h-100">
                                            <h6 class="fw-semibold mb-4">4. Apakah Anda bersedia melakukan aktivitas ini
                                                kembali di kemudian hari?</h6>
                                            <div
                                                class="d-flex justify-content-center justify-content-md-start align-items-center gap-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <input type="radio" class="btn-check feedback-radio"
                                                        name="willingness_score" id="will_{{ $i }}"
                                                        value="{{ $i }}" autocomplete="off">
                                                    <label
                                                        class="btn pss-option rounded-circle d-flex align-items-center justify-content-center fw-bold fs-5 likert-choice-circle"
                                                        for="will_{{ $i }}">{{ $i }}</label>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 7. Penilaian Keseluruhan (Rating Bintang) --}}
                        <div class="mb-4 question-item">
                            <div class="p-4 rounded-4 question-card shadow-sm text-center">
                                <h6 class="fw-bold mb-1 fs-5">Penilaian Keseluruhan</h6>
                                <p class="text-muted small mb-4">Bagaimana pengalaman Anda secara keseluruhan dengan
                                    aktivitas ini?</p>

                                <div class="d-flex justify-content-center align-items-center flex-nowrap gap-1 gap-sm-2"
                                    id="starRatingContainer">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <input type="radio" class="d-none star-radio" name="overall_rating"
                                            id="star_{{ $i }}" value="{{ $i }}"
                                            autocomplete="off">

                                        <label class="star-label m-0 star-rating-label" for="star_{{ $i }}"
                                            data-value="{{ $i }}">
                                            <i data-feather="star" class="star-rating-icon"></i>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER BUTTONS MODEL PSS --}}
                        <div class="border-top pt-4 mt-4">
                            <div class="d-flex justify-content-end justify-content-md-between gap-3">

                                {{-- KEMBALI: Disembunyikan di HP --}}
                                <a href="javascript:history.back()"
                                    class="btn btn-soft-secondary rounded-pill px-4 py-2 d-none d-md-flex align-items-center justify-content-center gap-2">
                                    <i data-feather="arrow-left"></i>
                                    <span>Kembali</span>
                                </a>

                                {{-- AKSI: Memanjang (full-width) di HP, Normal di PC --}}
                                <button type="submit"
                                    class="btn btn-soft-success rounded-pill px-4 py-2 d-flex align-items-center justify-content-center gap-2 flex-fill flex-md-grow-0">
                                    <span>Kirim Evaluasi</span>
                                    <i data-feather="send"></i>
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
