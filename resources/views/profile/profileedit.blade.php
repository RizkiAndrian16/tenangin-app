@extends('layouts.main')
@section('title', 'Profil Pengguna - Tenangin.')
@section('content')

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Profil Pengguna</h1>
        </div>
        @if (auth()->user()->isMahasiswa())
            <div>
                <a href="{{ route('dashboard') }}" class="text-decoration-none d-inline-flex align-items-center gap-1 fw-semibold text-secondary profile-dashboard-link" style="font-size: 14px;">
                    <span>Dashboard</span>
                    <i data-feather="chevron-right" style="width: 16px; height: 16px;"></i>
                </a>
            </div>
        @endif
    </div>

    {{-- ALERT SUKSES (Menangkap 'success' dari ProfileController DAN 'status' dari PasswordController) --}}
    @if (session('success') || session('status') === 'password-updated')
        <div class="profile-success-alert mb-4" id="successAlert">
            <div class="d-flex align-items-start gap-3">
                <div class="profile-success-icon">
                    <i data-feather="check-circle"></i>
                </div>

                <div>
                    <h6 class="fw-bold mb-1">Sukses!</h6>
                    <p class="mb-0">
                        {{ session('status') === 'password-updated' ? 'Password Anda berhasil diperbarui.' : session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- ALERT WARNING --}}
    @if (session('warning'))
        <div class="profile-warning-alert mb-4">
            <div class="d-flex align-items-start gap-3">
                <div class="profile-warning-icon">
                    <i data-feather="alert-circle"></i>
                </div>

                <div>
                    <h6 class="fw-bold mb-1">Lengkapi profilmu</h6>
                    <p class="mb-0">
                        {{ session('warning') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- CARD DASAR --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-3">
                {{-- CARD 1: STATUS PROFIL - KHUSUS MAHASISWA --}}
                @if (auth()->user()->isMahasiswa())
                    @php
                        $u = auth()->user();
                        $profileFilled = filled($u->gender)
                            && !is_null($u->age)
                            && filled($u->university)
                            && filled($u->major)
                            && !is_null($u->semester)
                            && filled($u->residence_status);
                    @endphp
                    <div class="col-12">
                        @if ($profileFilled)
                            {{-- PROFIL SUDAH LENGKAP --}}
                            <div class="profile-alert-card profile-complete-card rounded-4 p-3 shadow-sm w-100">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="icon-box-soft profile-complete-icon flex-shrink-0">
                                        <i data-feather="check-circle"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-2">Profil Lengkap</h6>
                                        <p class="mb-0 fs-6">
                                            Informasi profilmu sudah lengkap. Sistem siap memberikan
                                            pengalaman rekomendasi yang lebih personal untukmu.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- PROFIL BELUM LENGKAP --}}
                            <div class="profile-alert-card profile-incomplete-card rounded-4 p-3 shadow-sm w-100">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="icon-box-soft profile-incomplete-icon flex-shrink-0">
                                        <i data-feather="info"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-2">Profil Belum Lengkap</h6>
                                        <p class="mb-0 fs-6">
                                            Lengkapi informasi profil agar sistem dapat mengenalmu lebih baik
                                            dan memberikan pengalaman rekomendasi yang lebih personal.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif


                {{-- CARD 2: PROFILE HERO --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 mb-2">
                        <div class="card-body py-4 px-4 profile-hero-body">
                            <div
                                class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-center gap-3 text-center text-sm-start">
                                <div class="d-flex flex-column flex-sm-row align-items-center gap-3">
                                    <div id="viewPhotoTrigger" class="profile-photo-trigger" title="Lihat Foto">

                                        @if (auth()->user()->profile_photo)
                                            <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile"
                                                class="profile-avatar" id="heroAvatar">
                                        @else
                                            <div class="profile-avatar-placeholder" id="heroAvatarPlaceholder">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Teks Nama & Role --}}
                                    <div class="mt-1 mt-sm-0">
                                        <h5 class="fw-bold mb-1 profile-user-name" id="heroName">
                                            {{ auth()->user()->name }}
                                        </h5>
                                        <span class="profile-user-role">
                                            {{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="d-grid align-self-stretch align-self-sm-auto mt-2 mt-sm-0">
                                    <button type="button" id="openPhotoModal"
                                        class="btn btn-soft-secondary rounded-pill px-4 py-2 d-flex align-items-center justify-content-center gap-2">
                                        <i data-feather="camera"></i>
                                        <span>Edit Foto Profil</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 3: INFORMASI PRIBADI --}}
                {{-- Jika Admin, buat full width (col-12). Jika mahasiswa, bagi dua (col-lg-6) --}}
                <div class="{{ auth()->user()->role === 'admin' ? 'col-12' : 'col-lg-6' }}">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 profile-card-grid">

                            <div class="d-flex align-items-center gap-2 profile-card-title">
                                <div class="icon-box-soft icon-box-success">
                                    <i data-feather="user"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Informasi Pribadi</h5>
                            </div>

                            <div class="row g-0 profile-card-fields">
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
                                                {{ auth()->user()->age ? auth()->user()->age . ' Tahun' : '-' }}
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

                            <button type="button" id="openProfileModal"
                                class="btn btn-soft-secondary rounded-pill px-3 py-2 d-inline-flex align-items-center justify-content-center gap-2 profile-card-edit-btn">
                                <i data-feather="edit-2"></i>
                                <span>Edit</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- CARD 4: INFORMASI UNIVERSITAS (HANYA MUNCUL UNTUK MAHASISWA) --}}
                @if (auth()->user()->role === 'mahasiswa')
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4 profile-card-grid">

                                <div class="d-flex align-items-center gap-2 profile-card-title">
                                    <div class="icon-box-soft icon-box-success">
                                        <i data-feather="book-open"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Informasi Universitas</h5>
                                </div>

                                <div class="row g-0 profile-card-fields">
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
                                            <div class="col-5"><small class="text-muted">Jurusan / Program Studi</small>
                                            </div>
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
                                            <div class="col-5"><small class="text-muted">Tempat Tinggal</small></div>
                                            <div class="col-7">
                                                <p class="fw-semibold mb-0" id="displayResidence">
                                                    {{ auth()->user()->residence_status ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="openUniversityModal"
                                    class="btn btn-soft-secondary rounded-pill px-3 py-2 d-inline-flex align-items-center justify-content-center gap-2 profile-card-edit-btn">
                                    <i data-feather="edit-2"></i>
                                    <span>Edit</span>
                                </button>

                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('profile.profilshow')

@endsection
