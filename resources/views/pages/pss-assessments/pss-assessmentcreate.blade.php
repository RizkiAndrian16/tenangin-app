@extends('layouts.main')
@section('title', 'Form PSS-10 - Tenangin.')
@section('content')

    @if (auth()->user()->isMahasiswa())
        <x-stepper :current-step="1" />
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center border-bottom pb-4 mb-4">
                        <h2 class="fw-bold mb-2">Kuesioner PSS-10</h2>
                        <p class="text-muted mb-0">Pilih jawaban sesuai kondisi Anda dalam 1 bulan terakhir</p>
                    </div>

                    <div id="emptyAlert" class="alert-soft-danger mb-4 is-hidden">
                        Harap menjawab seluruh pertanyaan PSS-10 sebelum menyelesaikan assessment.
                    </div>

                    <div id="questionAlert" class="alert-soft-danger mb-4 is-hidden">
                        Masih ada pertanyaan yang belum dijawab. Silakan lengkapi terlebih dahulu.
                    </div>

                    <form id="pssForm" action="{{ route('pss-assessments.store') }}" method="POST">
                        @csrf

                        @foreach ($questions as $number => $question)
                            <div class="mb-2 question-item" data-question="{{ $number }}">
                                <div class="p-4 rounded-4 question-card shadow-sm">
                                    <h6 class="fw-semibold mb-4">{{ $number }}. {{ $question }}</h6>

                                    {{-- PERBAIKAN: Tambahkan align-items-start agar lebar kotak pas dengan teks --}}
                                    <div class="d-flex flex-column flex-md-row flex-wrap align-items-start gap-2">
                                        @foreach ($options as $score => $label)
                                            <input type="radio" class="btn-check" name="answers[{{ $number }}]"
                                                id="question{{ $number }}_{{ $score }}"
                                                value="{{ $score }}" autocomplete="off">

                                            {{-- Class text-start dihapus karena lebarnya sudah pas dengan teks --}}
                                            <label class="btn pss-option rounded-3 px-3 py-1.5"
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

                        <div class="border-top pt-4 mt-4">
                            <div class="d-flex justify-content-end justify-content-md-between gap-3">

                                {{-- KEMBALI: Disembunyikan di HP (d-none), Muncul di PC (d-md-flex) --}}
                                <a href="{{ route('pss-assessments.index') }}"
                                    class="btn btn-soft-secondary rounded-pill px-4 py-2 d-none d-md-flex align-items-center justify-content-center gap-2">
                                    <i data-feather="arrow-left" class="icon-16"></i>
                                    <span class="fw-medium">Kembali</span>
                                </a>

                                {{-- AKSI: Full memanjang di HP (flex-fill), normal di PC (flex-md-grow-0) --}}
                                <button type="submit"
                                    class="btn btn-soft-success rounded-pill px-4 py-2 d-flex align-items-center justify-content-center gap-2 flex-fill flex-md-grow-0">
                                    <span class="fw-medium">Lihat Hasil</span>
                                    <i data-feather="arrow-right" class="icon-16"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
