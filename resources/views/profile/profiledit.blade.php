@extends('layouts.main')
@section('title', 'Profil Pengguna - Tenangin App')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Profil Pengguna</h1>
            <p class="text-muted mb-0">Informasi data pengguna sistem.</p>
        </div>
    </div>

    {{-- CARD DASAR --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">

                {{-- CARD 1: INFORMASI PENTING --}}
                <div class="col-12">
                    <div class="profile-alert-card rounded-4 p-4 shadow-sm w-100">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="icon-box-soft icon-box-success flex-shrink-0">
                                <i data-feather="info"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-2">Informasi Penting</h6>
                                <p class="mb-0 fs-6">
                                    Bantu kami mendapatkan hasil riset yang akurat
                                    dengan melengkapi data pribadi Anda.
                                    Jangan khawatir, keamanan dan privasi data Anda
                                    adalah prioritas utama kami dan hanya digunakan
                                    untuk kepentingan analisis penelitian.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 2: PROFILE HERO --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                                <div class="d-flex align-items-center gap-3">
                                    @if (auth()->user()->profile_photo_url)
                                        <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile"
                                            class="profile-avatar" id="heroAvatar">
                                    @else
                                        <div class="profile-avatar-placeholder" id="heroAvatarPlaceholder">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="ms-2">
                                        <h5 class="fw-bold mb-1" id="heroName">{{ auth()->user()->name }}</h5>
                                        <span class="text-success-emphasis fw-semibold">
                                            {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                                        </span>
                                    </div>
                                </div>

                                <button type="button" id="openPhotoModal"
                                    class="btn btn-soft-secondary rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                                    <i data-feather="camera"></i>
                                    <span>Ubah Foto Profil</span>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 3: INFORMASI PRIBADI --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="icon-box-soft icon-box-success">
                                        <i data-feather="user"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Informasi Pribadi</h5>
                                </div>
                                <button type="button" id="openProfileModal"
                                    class="btn btn-soft-secondary rounded-pill px-3 py-2 d-inline-flex align-items-center gap-2">
                                    <i data-feather="edit-2"></i>
                                    <span>Edit</span>
                                </button>
                            </div>

                            <div class="row g-0">
                                <div class="col-12 py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">Nama Lengkap</small></div>
                                        <div class="col-7">
                                            <p class="fw-semibold mb-0" id="displayName">{{ auth()->user()->name ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">Jenis Kelamin</small></div>
                                        <div class="col-7">
                                            <p class="fw-semibold mb-0" id="displayGender">
                                                {{ auth()->user()->gender ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">Umur</small></div>
                                        <div class="col-7">
                                            <p class="fw-semibold mb-0" id="displayAge">
                                                {{ auth()->user()->age ? auth()->user()->age . ' tahun' : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">Alamat Email</small></div>
                                        <div class="col-7">
                                            <p class="fw-semibold mb-0">{{ auth()->user()->email ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 py-3">
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">Nomor Telepon</small></div>
                                        <div class="col-7">
                                            <p class="fw-semibold mb-0" id="displayPhone">
                                                {{ auth()->user()->phone_number ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- CARD 4: INFORMASI UNIVERSITAS --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="icon-box-soft icon-box-success">
                                        <i data-feather="book-open"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Informasi Universitas</h5>
                                </div>
                                <button type="button" id="openUniversityModal"
                                    class="btn btn-soft-secondary rounded-pill px-3 py-2 d-inline-flex align-items-center gap-2">
                                    <i data-feather="edit-2"></i>
                                    <span>Edit</span>
                                </button>
                            </div>

                            <div class="row g-0">
                                <div class="col-12 py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">Universitas</small></div>
                                        <div class="col-7">
                                            <p class="fw-semibold mb-0" id="displayUniversity">
                                                {{ auth()->user()->university ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">Jurusan</small></div>
                                        <div class="col-7">
                                            <p class="fw-semibold mb-0" id="displayMajor">
                                                {{ auth()->user()->major ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">Semester</small></div>
                                        <div class="col-7">
                                            <p class="fw-semibold mb-0" id="displaySemester">
                                                {{ auth()->user()->semester ? 'Semester ' . auth()->user()->semester : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 py-3">
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">Status Tempat Tinggal</small></div>
                                        <div class="col-7">
                                            <p class="fw-semibold mb-0" id="displayResidence">
                                                {{ auth()->user()->residence_status ?? '-' }}</p>
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


    {{-- ═══════════════════════════════════════
         MODAL 1 — EDIT PROFIL PRIBADI
    ═══════════════════════════════════════ --}}
    <div class="custom-popup-overlay" id="profileModal">
        <div class="custom-popup">

            <button type="button" class="custom-popup-close js-close-modal" data-target="profileModal">
                <i data-feather="x"></i>
            </button>

            <div class="mb-4">
                <h2 class="fw-bold mb-1">Ubah Informasi Profil</h2>
                <p class="text-muted mb-0">Perbarui informasi pribadi Anda</p>
            </div>

            <form id="profileForm" action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="fw-bold mb-4">Informasi Pribadi</h5>

                <div class="row g-4">

                    <div class="col-12">
                        <label class="form-label fw-semibold" for="inputName">Nama Lengkap</label>
                        <input type="text" id="inputName" name="name" class="form-control custom-input"
                            value="{{ auth()->user()->name }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                        <div class="d-flex gap-3 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="genderMale"
                                    value="Laki-Laki" {{ auth()->user()->gender === 'Laki-Laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="genderMale">Laki-Laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="genderFemale"
                                    value="Perempuan" {{ auth()->user()->gender === 'Perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="genderFemale">Perempuan</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="inputAge">Umur</label>
                        <input type="number" id="inputAge" name="age" class="form-control custom-input"
                            min="1" max="99" value="{{ auth()->user()->age }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold" for="inputPhone">Nomor Telepon</label>
                        <input type="tel" id="inputPhone" name="phone_number" class="form-control custom-input"
                            value="{{ auth()->user()->phone_number }}">
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-3 mt-5">
                    <button type="button" class="btn btn-soft-secondary rounded-pill px-4 py-2 js-close-modal"
                        data-target="profileModal">
                        Tutup
                    </button>
                    <button type="submit"
                        class="btn btn-soft-success rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                        <i data-feather="save"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>

            </form>
        </div>
    </div>


    {{-- ═══════════════════════════════════════
         MODAL 2 — EDIT UNIVERSITAS
    ═══════════════════════════════════════ --}}
    <div class="custom-popup-overlay" id="universityModal">
        <div class="custom-popup">

            <button type="button" class="custom-popup-close js-close-modal" data-target="universityModal">
                <i data-feather="x"></i>
            </button>

            <div class="mb-4">
                <h2 class="fw-bold mb-1">Ubah Informasi Universitas</h2>
                <p class="text-muted mb-0">Perbarui data akademik Anda</p>
            </div>

            <form id="universityForm" action="{{ route('profile.university.update') }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="fw-bold mb-4">Informasi Akademik</h5>

                <div class="row g-4">

                    <div class="col-12">
                        <label class="form-label fw-semibold" for="inputUniversity">Universitas</label>
                        <input type="text" id="inputUniversity" name="university" class="form-control custom-input"
                            value="{{ auth()->user()->university }}" placeholder="Contoh: Universitas Indonesia">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold" for="inputMajor">Jurusan / Program Studi</label>
                        <input type="text" id="inputMajor" name="major" class="form-control custom-input"
                            value="{{ auth()->user()->major }}" placeholder="Contoh: Teknik Informatika">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="inputSemester">Semester</label>
                        <select id="inputSemester" name="semester" class="form-select custom-input">
                            <option value="">— Pilih Semester —</option>
                            @for ($s = 1; $s <= 14; $s++)
                                <option value="{{ $s }}"
                                    {{ auth()->user()->semester == $s ? 'selected' : '' }}>
                                    Semester {{ $s }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="inputResidence">Status Tempat Tinggal</label>
                        <select id="inputResidence" name="residence_status" class="form-select custom-input">
                            <option value="">— Pilih Status —</option>
                            @foreach (['Kos', 'Kontrak', 'Rumah Sendiri', 'Menumpang', 'Asrama'] as $status)
                                <option value="{{ $status }}"
                                    {{ auth()->user()->residence_status === $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-3 mt-5">
                    <button type="button" class="btn btn-soft-secondary rounded-pill px-4 py-2 js-close-modal"
                        data-target="universityModal">
                        Tutup
                    </button>
                    <button type="submit"
                        class="btn btn-soft-success rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                        <i data-feather="save"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>

            </form>
        </div>
    </div>


    {{-- ═══════════════════════════════════════
         MODAL 3 — UBAH FOTO PROFIL
    ═══════════════════════════════════════ --}}
    <div class="custom-popup-overlay" id="photoModal">
        <div class="custom-popup">

            <button type="button" class="custom-popup-close js-close-modal" data-target="photoModal">
                <i data-feather="x"></i>
            </button>

            <div class="mb-4">
                <h2 class="fw-bold mb-1">Ubah Foto Profil</h2>
                <p class="text-muted mb-0">Upload foto baru untuk profil Anda</p>
            </div>

            <form id="photoForm" action="{{ route('profile.photo.update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="photo-upload-area" id="photoDropZone">
                    <div class="d-flex flex-column align-items-center gap-3">
                        <img id="photoPreviewImg" class="photo-preview-img" src="#" alt="Preview">
                        <div id="photoDropIcon">
                            <i data-feather="upload-cloud" style="width:48px;height:48px;color:#9ca3af;"></i>
                            <p class="mt-3 mb-1 fw-semibold text-dark">Drag &amp; drop foto di sini</p>
                            <p class="text-muted small mb-0">atau klik untuk memilih file</p>
                            <p class="text-muted small">PNG, JPG — maks. 2 MB</p>
                        </div>
                        <p id="photoFileName" class="text-muted small mb-0" style="display:none;"></p>
                    </div>
                </div>

                <input type="file" id="photoInput" name="profile_photo" accept="image/png,image/jpeg,image/jpg"
                    style="display:none;">

                <div class="d-flex justify-content-end gap-3 mt-4">
                    <button type="button" class="btn btn-soft-secondary rounded-pill px-4 py-2 js-close-modal"
                        data-target="photoModal">
                        Tutup
                    </button>
                    <button type="submit" id="submitPhotoBtn"
                        class="btn btn-soft-success rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2"
                        disabled>
                        <i data-feather="upload"></i>
                        <span>Upload Foto</span>
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- TOAST CONTAINER --}}
    <div class="toast-container-custom" id="toastContainer"></div>

@endsection

@push('scripts')
    <script src="{{ asset('js/profile.js') }}"></script>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => showToast("{{ session('success') }}", 'success'));
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => showToast("{{ session('error') }}", 'error'));
        </script>
    @endif
@endpush
