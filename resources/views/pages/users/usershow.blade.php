@extends('layouts.main')
@section('title', 'Detail User - Tenangin.')
@section('content')

    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Detail User</h1>
        <p class="text-muted mb-0">Informasi lengkap data user yang terdaftar di dalam sistem.</p>
    </div>

    {{-- CARD UTAMA --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-3">

                {{-- CARD HERO: AVATAR + NAMA + ROLE --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 mb-2">
                        <div class="card-body py-4 px-4 profile-hero-body">
                            <div class="d-flex flex-column flex-sm-row align-items-center gap-3 text-center text-sm-start">

                                {{-- Avatar --}}
                                @if ($user->profile_photo)
                                    <img src="{{ $user->profile_photo_url }}" alt="Profile" class="profile-avatar cursor-pointer" id="viewUserPhotoTrigger">
                                @else
                                    <div class="profile-avatar-placeholder cursor-pointer" id="viewUserPhotoTrigger">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif

                                {{-- Nama dan Role --}}
                                <div class="mt-1 mt-sm-0">
                                    <h5 class="fw-bold mb-1 profile-user-name">{{ $user->name }}</h5>
                                    <span class="profile-user-role">
                                        {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD INFORMASI PRIBADI --}}
                {{-- Diperlebar (col-12) jika user adalah admin, dibagi dua (col-lg-6) jika mahasiswa --}}
                <div class="{{ $user->role === 'admin' ? 'col-12' : 'col-lg-6' }}">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="icon-box-soft icon-box-success">
                                    <i data-feather="user"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Informasi Pribadi</h5>
                            </div>

                            <div class="row g-0">
                                <div class="col-12 py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">Nama Lengkap</small></div>
                                        <div class="col-7">
                                            <p class="fw-semibold mb-0">{{ $user->name ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">Jenis Kelamin</small></div>
                                        <div class="col-7">
                                            <p class="fw-semibold mb-0">{{ $user->gender ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">Umur</small></div>
                                        <div class="col-7">
                                            <p class="fw-semibold mb-0">
                                                {{ $user->age ? $user->age . ' Tahun' : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">Alamat Email</small></div>
                                        <div class="col-7">
                                            <p class="fw-semibold mb-0">{{ $user->email ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 py-3">
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">Nomor Telepon</small></div>
                                        <div class="col-7">
                                            <p class="fw-semibold mb-0">{{ $user->phone_number ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- CARD INFORMASI UNIVERSITAS (HANYA DITAMPILKAN JIKA ROLE ADALAH MAHASISWA) --}}
                @if ($user->role === 'mahasiswa')
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">

                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <div class="icon-box-soft icon-box-success">
                                        <i data-feather="book-open"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Informasi Universitas</h5>
                                </div>

                                {{-- Karena sudah dipastikan mahasiswa, logika IF admin di dalam teks bisa dihapus agar bersih --}}
                                <div class="row g-0">
                                    <div class="col-12 py-3 border-bottom">
                                        <div class="row">
                                            <div class="col-5"><small class="text-muted">Universitas</small></div>
                                            <div class="col-7">
                                                <p class="fw-semibold mb-0">{{ $user->university ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 py-3 border-bottom">
                                        <div class="row">
                                            <div class="col-5"><small class="text-muted">Jurusan</small></div>
                                            <div class="col-7">
                                                <p class="fw-semibold mb-0">{{ $user->major ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 py-3 border-bottom">
                                        <div class="row">
                                            <div class="col-5"><small class="text-muted">Semester</small></div>
                                            <div class="col-7">
                                                <p class="fw-semibold mb-0">
                                                    {{ $user->semester ? 'Semester ' . $user->semester : '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 py-3">
                                        <div class="row">
                                            <div class="col-5"><small class="text-muted">Tempat Tinggal</small></div>
                                            <div class="col-7">
                                                <p class="fw-semibold mb-0">{{ $user->residence_status ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
                {{-- END CARD UNIVERSITAS --}}

                {{-- TOMBOL KEMBALI --}}
                <div class="col-12">
                    <div class="d-none d-md-flex justify-content-md-center gap-2 border-top pt-4 mt-4">
                        <a href="{{ route('users.index') }}"
                            class="btn btn-soft-secondary rounded-pill px-4 py-2 d-flex align-items-center justify-content-center gap-2">
                            <i data-feather="arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL LIHAT FOTO PROFIL BESAR (READ-ONLY) --}}
    <div class="custom-popup-overlay" id="viewUserPhotoModal">
        <div class="custom-popup view-photo-popup text-center">

            <button type="button" class="custom-popup-close js-close-modal" data-target="viewUserPhotoModal">
                <i data-feather="x"></i>
            </button>

            <div class="mb-4">
                <h4 class="fw-bold mb-1">Foto Profil</h4>
            </div>

            <div class="d-flex justify-content-center mb-0">
                @if ($user->profile_photo)
                    <img src="{{ $user->profile_photo_url }}" alt="Profile"
                        class="profile-avatar profile-avatar-lg shadow-sm">
                @else
                    <div
                        class="profile-avatar-placeholder profile-avatar-lg shadow-sm d-flex align-items-center justify-content-center">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const trigger = document.getElementById('viewUserPhotoTrigger');
            const modal = document.getElementById('viewUserPhotoModal');

            if (trigger && modal) {
                trigger.addEventListener('click', () => {
                    modal.classList.add('show');
                    document.body.style.setProperty('overflow-y', 'scroll');
                    document.body.style.setProperty('touch-action', 'none');
                });
            }
        });
    </script>
@endpush
