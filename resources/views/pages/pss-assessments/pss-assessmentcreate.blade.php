@extends('layouts.main')
@section('title', 'Form PSS-10 - Tenangin App')
@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center border-bottom pb-4 mb-5">
                        <h2 class="fw-bold mb-2">Kuesioner PSS-10</h2>
                        <p class="text-muted mb-0">Pilih jawaban sesuai kondisi Anda dalam 1 bulan terakhir</p>
                    </div>

                    <div id="emptyAlert" class="alert-soft-danger mb-4" style="display: none;">
                        Harap menjawab seluruh pertanyaan PSS-10 sebelum menyelesaikan assessment.
                    </div>

                    <div id="questionAlert" class="alert-soft-danger mb-4" style="display: none;">
                        Masih ada pertanyaan yang belum dijawab. Silakan lengkapi terlebih dahulu.
                    </div>

                    <form id="pssForm" action="{{ route('pss-assessments.store') }}" method="POST">
                        @csrf
                        @php
                            $questions = [
                                1 => 'Seberapa sering kamu merasa kesal karena hal yang terjadi tiba-tiba?',
                                2 => 'Seberapa sering kamu merasa tidak bisa mengendalikan hal-hal penting dalam hidupmu?',
                                3 => 'Seberapa sering kamu merasa gugup atau tertekan (stres)?',
                                4 => 'Seberapa sering kamu berhasil mengatasi masalah kecil yang mengganggu?',
                                5 => 'Seberapa sering kamu merasa mampu menghadapi perubahan yang terjadi?',
                                6 => 'Seberapa sering kamu merasa kewalahan dengan semua hal yang harus kamu lakukan?',
                                7 => 'Seberapa sering kamu merasa percaya diri saat menghadapi masalah pribadi?',
                                8 => 'Seberapa sering kamu merasa situasi yang kamu hadapi masih dalam kendalimu?',
                                9 => 'Seberapa sering kamu merasa marah karena ada hal-hal yang tidak bisa kamu kendalikan?',
                                10 => 'Seberapa sering kamu merasa masalah yang kamu hadapi terlalu banyak sampai sulit diatasi?',
                            ];

                            $options = [
                                0 => 'Tidak Pernah',
                                1 => 'Hampir Tidak Pernah',
                                2 => 'Kadang-kadang',
                                3 => 'Cukup Sering',
                                4 => 'Sangat Sering',
                            ];
                        @endphp

                        @foreach ($questions as $number => $question)
                            <div class="mb-4 question-item" data-question="{{ $number }}">
                                <div class="p-4 rounded-4 question-card shadow-sm">
                                    <h6 class="fw-semibold mb-4">{{ $number }}. {{ $question }}</h6>

                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($options as $score => $label)
                                            <input type="radio" class="btn-check" name="answers[{{ $number }}]"
                                                id="question{{ $number }}_{{ $score }}"
                                                value="{{ $score }}" autocomplete="off">

                                            <label class="btn pss-option rounded-3 px-3"
                                                for="question{{ $number }}_{{ $score }}">
                                                {{ $label }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- TESTING BUTTON --}}
                        <div class="mb-4 text-end">
                            <button type="button" id="btnAutoFill" class="btn btn-soft-info rounded-pill px-4">
                                Isi Otomatis
                            </button>
                        </div>

                        <div class="border-top pt-4 mt-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('pss-assessments.index') }}"
                                    class="btn btn-soft-secondary rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                                    <i data-feather="arrow-left"></i>
                                    <span>Kembali</span>
                                </a>

                                <button type="submit"
                                    class="btn btn-soft-success rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                                    <span>Lihat Hasil</span>
                                    <i data-feather="arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
