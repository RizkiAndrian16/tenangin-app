@extends('layouts.main')
@section('title', 'Edit Aturan Rekomendasi - Tenangin.')
@section('content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Edit Aturan Rekomendasi</h1>
            <p class="text-muted mb-0">
                Perbarui aturan rekomendasi aktivitas berdasarkan tingkat stres.
            </p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert-soft-danger rounded-4 mb-4 shadow-sm p-3">
            @foreach (array_unique($errors->all()) as $error)
                <div class="mb-1 text-danger">
                    {{ $error }}
                </div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('rule-based-rules.update', $ruleBasedRule->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="page" value="{{ request('page', 1) }}">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tingkat Stres</label>

                        <select name="stress_level"
                            class="form-select custom-input @error('stress_level') is-invalid @enderror">

                            <option value="">Pilih Tingkat Stres</option>

                            <option value="Rendah"
                                {{ old('stress_level', $ruleBasedRule->stress_level) == 'Rendah' ? 'selected' : '' }}>
                                Rendah
                            </option>

                            <option value="Sedang"
                                {{ old('stress_level', $ruleBasedRule->stress_level) == 'Sedang' ? 'selected' : '' }}>
                                Sedang
                            </option>

                            <option value="Tinggi"
                                {{ old('stress_level', $ruleBasedRule->stress_level) == 'Tinggi' ? 'selected' : '' }}>
                                Tinggi
                            </option>

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Aktivitas Relaksasi</label>

                        <select name="activity_id"
                            class="form-select custom-input @error('activity_id') is-invalid @enderror">

                            <option value="">Pilih Aktivitas Relaksasi</option>

                            @foreach ($activities as $activity)
                                <option value="{{ $activity->id }}"
                                    {{ old('activity_id', $ruleBasedRule->activity_id) == $activity->id ? 'selected' : '' }}>

                                    {{ $activity->title }}

                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Deskripsi Aturan</label>

                        <textarea name="description" rows="5" class="form-control custom-input @error('description') is-invalid @enderror"
                            placeholder="Masukkan deskripsi aturan rekomendasi">{{ old('description', $ruleBasedRule->description) }}</textarea>
                    </div>

                </div>

                {{-- NAVIGASI BUTTON --}}
                <div class="border-top pt-4 mt-4">
                    <div class="d-flex justify-content-end justify-content-md-between gap-3">
                        <a href="{{ route('rule-based-rules.index') }}"
                            class="btn btn-soft-secondary rounded-pill px-4 py-2 d-none d-md-flex align-items-center justify-content-center gap-2">
                            <i data-feather="arrow-left"></i>
                            <span>Kembali</span>
                        </a>

                        <button type="submit"
                            class="btn btn-soft-success rounded-pill px-4 py-2 d-flex align-items-center justify-content-center gap-2 flex-fill flex-md-grow-0">
                            <i data-feather="save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
