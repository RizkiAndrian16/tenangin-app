@extends('layouts.main')
@section('title', 'Profil Pengguna - Tenangin.')
@section('content')

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Profil Pengguna</h1>
            <p class="text-muted mb-0">Informasi data pengguna sistem.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="profile-success-alert mb-4" id="successAlert">
            <div class="d-flex align-items-start gap-3">
                <div class="profile-success-icon">
                    <i data-feather="check-circle"></i>
                </div>

                <div>
                    <h6 class="fw-bold mb-1">Sukses!</h6>
                    <p class="mb-0">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- CARD DASAR --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">

                {{-- CARD 1: INFORMASI PENTING --}}
                <div class="col-12">
                    <div class="profile-alert-card alert-soft-success rounded-4 p-3 shadow-sm w-100">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="icon-box-soft icon-box-success flex-shrink-0">
                                <i data-feather="info"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-2">Informasi Penting</h6>
                                <p class="mb-0 fs-6">
                                    Lengkapi profil anda agar sistem dapat mengenal lebih baik dan memberikan
                                    pengalaman penggunaan yang lebih nyaman. Tenang, seluruh data yang kamu isi akan dijaga
                                    kerahasiaannya dan privasimu tetap aman.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 2: PROFILE HERO --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body py-4 px-5 profile-hero-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    @if (auth()->user()->profile_photo)
                                        <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile"
                                            class="profile-avatar" id="heroAvatar">
                                    @else
                                        <div class="profile-avatar-placeholder" id="heroAvatarPlaceholder">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="ms-2">
                                        <h5 class="fw-bold mb-2 profile-user-name" id="heroName">
                                            {{ auth()->user()->name }}
                                        </h5>
                                        <span class="profile-user-role">
                                            {{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}
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

    @include('profile.profilshow')

@endsection
