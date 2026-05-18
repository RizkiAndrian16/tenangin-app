@extends('layouts.main')
@section('title', 'Edit Katalog Aktivitas - Tenangin.')
@section('content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Edit Katalog Aktivitas Relaksasi</h1>
            <p class="text-muted mb-0">Perbarui informasi aktivitas relaksasi yang tersedia di dalam sistem.</p>
        </div>
    </div>

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

    <form action="{{ route('activities.update', $activity->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="page" value="{{ request('page', 1) }}">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label fw-bold">Nama Aktivitas</label>

                        <input type="text" name="title" value="{{ old('title', $activity->title) }}"
                            class="form-control custom-input @error('title') is-invalid @enderror"
                            placeholder="Masukkan nama aktivitas relaksasi">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Deskripsi Aktivitas</label>

                        <textarea name="description" rows="5" class="form-control custom-input @error('description') is-invalid @enderror"
                            placeholder="Masukkan deskripsi aktivitas relaksasi">{{ old('description', $activity->description) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jenis Aktivitas</label>

                        <input type="text" name="activity_type"
                            value="{{ old('activity_type', $activity->activity_type) }}"
                            class="form-control custom-input @error('activity_type') is-invalid @enderror"
                            placeholder="Masukkan jenis aktivitas relaksasi">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kategori Durasi Aktivitas</label>

                        <select name="duration_category"
                            class="form-select custom-input @error('duration_category') is-invalid @enderror">

                            <option value="">Pilih Durasi</option>

                            <option value="<= 15 menit"
                                {{ old('duration_category', $activity->duration_category) == '<= 15 menit' ? 'selected' : '' }}>
                                <= 15 menit </option>

                            <option value="10 - 30 menit"
                                {{ old('duration_category', $activity->duration_category) == '10 - 30 menit' ? 'selected' : '' }}>
                                10 - 30 menit
                            </option>

                            <option value="> 30 menit"
                                {{ old('duration_category', $activity->duration_category) == '> 30 menit' ? 'selected' : '' }}>
                                > 30 menit
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tingkat Intensitas Aktivitas</label>

                        <select name="intensity_level"
                            class="form-select custom-input @error('intensity_level') is-invalid @enderror">

                            <option value="">Pilih Tingkat Intensitas</option>

                            <option value="Ringan"
                                {{ old('intensity_level', $activity->intensity_level) == 'Ringan' ? 'selected' : '' }}>
                                Ringan
                            </option>

                            <option value="Sedang"
                                {{ old('intensity_level', $activity->intensity_level) == 'Sedang' ? 'selected' : '' }}>
                                Sedang
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Target Tingkat Stres</label>

                        <select name="stress_level_target"
                            class="form-select custom-input @error('stress_level_target') is-invalid @enderror">

                            <option value="">Pilih Tingkat Stres</option>

                            <option value="Rendah"
                                {{ old('stress_level_target', $activity->stress_level_target) == 'Rendah' ? 'selected' : '' }}>
                                Rendah
                            </option>

                            <option value="Rendah,Sedang"
                                {{ old('stress_level_target', $activity->stress_level_target) == 'Rendah,Sedang' ? 'selected' : '' }}>
                                Rendah & Sedang
                            </option>

                            <option value="Sedang,Tinggi"
                                {{ old('stress_level_target', $activity->stress_level_target) == 'Sedang,Tinggi' ? 'selected' : '' }}>
                                Sedang & Tinggi
                            </option>

                            <option value="Rendah,Sedang,Tinggi"
                                {{ old('stress_level_target', $activity->stress_level_target) == 'Rendah,Sedang,Tinggi' ? 'selected' : '' }}>
                                Semua Tingkat Stres
                            </option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Status Rekomendasi Aktivitas</label>

                        <select name="status" class="form-select custom-input @error('status') is-invalid @enderror">

                            <option value="">Pilih Status</option>

                            <option value="Direkomendasikan"
                                {{ old('status', $activity->status) == 'Direkomendasikan' ? 'selected' : '' }}>
                                Direkomendasikan
                            </option>

                            <option value="Direkomendasikan terbatas"
                                {{ old('status', $activity->status) == 'Direkomendasikan terbatas' ? 'selected' : '' }}>
                                Direkomendasikan terbatas
                            </option>

                            <option value="Tidak direkomendasikan"
                                {{ old('status', $activity->status) == 'Tidak direkomendasikan' ? 'selected' : '' }}>
                                Tidak direkomendasikan
                            </option>

                            <option value="Perlu perhatian"
                                {{ old('status', $activity->status) == 'Perlu perhatian' ? 'selected' : '' }}>
                                Perlu perhatian
                            </option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Instruksi dan Konteks Pelaksanaan Aktivitas</label>
                        <textarea name="instruction" rows="5"
                            class="form-control custom-input
                        @error('instruction') is-invalid @enderror"
                            placeholder="Masukkan instruksi dan konteks pelaksanaan aktivitas relaksasi">{{ old('instruction', $activity->instruction) }}</textarea>
                    </div>
                </div>

                <div class="border-top pt-4 mt-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <a href="{{ route('activities.index') }}"
                            class="btn btn-soft-secondary rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                            <i data-feather="arrow-left"></i>
                            <span>Kembali</span>
                        </a>

                        <button type="submit"
                            class="btn btn-soft-success rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                            <i data-feather="save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
