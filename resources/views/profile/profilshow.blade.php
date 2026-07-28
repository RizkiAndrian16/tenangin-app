{{-- ═══════════════════════════════════════
         MODAL 1 — EDIT PROFIL PRIBADI
    ═══════════════════════════════════════ --}}
<div class="custom-popup-overlay" id="profileModal">
    <div class="custom-popup">

        <button type="button" class="custom-popup-close js-close-modal" data-target="profileModal">
            <i data-feather="x"></i>
        </button>

        <div class="mb-4">
            <h2 class="fw-bold mb-1">Edit Informasi Profil</h2>
            <p class="text-muted mb-0">Perbarui info pribadi Anda</p>
        </div>

        <form id="profileForm" action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

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
                    <input type="number" id="inputAge" name="age" class="form-control custom-input" min="1"
                        max="99" value="{{ auth()->user()->age }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold" for="inputEmail">Alamat Email</label>
                    <input type="email" id="inputEmail" class="form-control custom-input"
                        value="{{ auth()->user()->email }}" disabled>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold" for="inputPhone">Nomor Telepon</label>
                    <input type="tel" id="inputPhone" name="phone_number" class="form-control custom-input"
                        value="{{ auth()->user()->phone_number }}">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3 mt-4">
                <button type="button" class="btn btn-soft-secondary rounded-pill px-4 py-2 js-close-modal"
                    data-target="profileModal">
                    Tutup
                </button>
                <button type="submit"
                    class="btn btn-soft-success rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                    <i data-feather="save"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ═══════════════════════════════════════
         MODAL 2 — EDIT UNIVERSITAS (HANYA MAHASISWA)
    ═══════════════════════════════════════ --}}
@if (auth()->user()->role === 'mahasiswa')
    <div class="custom-popup-overlay" id="universityModal">
        <div class="custom-popup">

            <button type="button" class="custom-popup-close js-close-modal" data-target="universityModal">
                <i data-feather="x"></i>
            </button>

            <div class="mb-4">
                <h2 class="fw-bold mb-1">Edit Informasi Universitas</h2>
                <p class="text-muted mb-0">Perbarui data akademik Anda</p>
            </div>

            <form id="universityForm" action="{{ route('profile.university.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    <div class="col-12">
                        <label class="form-label fw-semibold" for="inputUniversity">Universitas</label>
                        <input type="text" id="inputUniversity" name="university" class="form-control custom-input"
                            value="{{ auth()->user()->university }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold" for="inputMajor">Jurusan / Program Studi</label>
                        <input type="text" id="inputMajor" name="major" class="form-control custom-input"
                            value="{{ auth()->user()->major }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="inputSemester">Semester</label>
                        <input type="number" id="inputSemester" name="semester" class="form-control custom-input"
                            min="1" max="14" value="{{ auth()->user()->semester }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="inputResidence">Tempat Tinggal</label>
                        <select id="inputResidence" name="residence_status" class="form-select custom-input"
                            data-current="{{ auth()->user()->residence_status }}">
                            <option value="">Pilih</option>
                            @foreach (['Rumah Orang Tua', 'Kos', 'Asrama', 'Kontrakan', 'Lainnya'] as $status)
                                <option value="{{ $status }}"
                                    {{ auth()->user()->residence_status === $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" id="inputResidenceOther" name="residence_status_other"
                            class="form-control custom-input mt-3 is-hidden"
                            placeholder="Tuliskan status tempat tinggal Anda...">
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
                        <span>Simpan</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
@endif


{{-- ═══════════════════════════════════════
         MODAL 3 — UBAH FOTO PROFIL
    ═══════════════════════════════════════ --}}
<div class="custom-popup-overlay" id="photoModal">
    <div class="custom-popup">

        <button type="button" class="custom-popup-close js-close-modal" data-target="photoModal">
            <i data-feather="x"></i>
        </button>

        <div class="mb-4">
            <h2 class="fw-bold mb-1">Edit Foto Profil</h2>
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
                        <i data-feather="upload-cloud" class="photo-upload-icon"></i>
                        <p class="mt-3 mb-1 fw-semibold text-dark">Drag &amp; drop foto di sini</p>
                        <p class="text-muted small mb-0">atau klik untuk memilih file</p>
                        <p class="text-muted small">PNG, JPG — maks. 5 MB</p>
                    </div>
                    <p id="photoFileName" class="text-muted small mb-0 is-hidden"></p>
                </div>
            </div>

            <input type="file" id="photoInput" name="profile_photo" accept="image/png,image/jpeg,image/jpg"
                class="is-hidden">

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

{{-- ═══════════════════════════════════════
         MODAL 4 — LIHAT FOTO PROFIL BESAR
    ═══════════════════════════════════════ --}}
<div class="custom-popup-overlay" id="viewPhotoModal">
    <div class="custom-popup view-photo-popup text-center">

        <button type="button" class="custom-popup-close js-close-modal" data-target="viewPhotoModal">
            <i data-feather="x"></i>
        </button>

        <div class="mb-4">
            <h4 class="fw-bold mb-1">Foto Profil</h4>
        </div>

        <div class="d-flex justify-content-center mb-4">
            @if (auth()->user()->profile_photo)
                <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile"
                    class="profile-avatar profile-avatar-lg shadow-sm">
            @else
                <div
                    class="profile-avatar-placeholder profile-avatar-lg shadow-sm d-flex align-items-center justify-content-center">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
        </div>

        <div>
            <button type="button" id="btnSwitchToUploadModal"
                class="btn btn-soft-secondary rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                <i data-feather="camera"></i>
                <span>Edit Foto Profil</span>
            </button>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════
         MODAL 5 — UBAH PASSWORD
    ═══════════════════════════════════════ --}}
<div class="custom-popup-overlay" id="passwordModal">
    <div class="custom-popup">

        <button type="button" class="custom-popup-close js-close-modal" data-target="passwordModal">
            <i data-feather="x"></i>
        </button>

        <div class="mb-4">
            @if (auth()->user()->password)
                <h2 class="fw-bold mb-1">Ubah Password</h2>
                <p class="text-muted mb-0">
                    Pastikan akun Anda menggunakan kata sandi yang kuat.
                </p>
            @else
                <h2 class="fw-bold mb-1">Atur Password</h2>
                <p class="text-muted mb-0">
                    Buat password agar Anda juga dapat masuk menggunakan email dan password.
                </p>
            @endif
        </div>

        {{-- ALERT JIKA GAGAL UBAH PASSWORD (DIPINDAH KE SINI) --}}
        @if ($errors->updatePassword->any())
            <div class="alert alert-soft-danger rounded-3 mb-4 p-3">
                <div class="d-flex align-items-start gap-2">
                    <i data-feather="alert-triangle" class="text-danger flex-shrink-0 mt-1"></i>
                    <ul class="mb-0 ps-3 small text-danger">
                        @foreach ($errors->updatePassword->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form id="passwordForm" action="{{ route('password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">
                {{-- Cek apakah user mendaftar manual dan memiliki password --}}
                @if (auth()->user()->password)
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="current_password">Password Saat Ini</label>
                        <div class="position-relative">
                            <input type="password" id="current_password" name="current_password"
                                class="form-control custom-input pe-5" required>
                            <button type="button" tabindex="-1"
                                class="btn btn-transparent border-0 shadow-none position-absolute top-50 end-0 translate-middle-y text-muted"
                                onmousedown="event.preventDefault()"
                                onclick="togglePassword('current_password', this)">
                                <i data-feather="eye" class="icon-18"></i>
                            </button>
                        </div>
                    </div>
                @else
                    {{-- Jika login Google (password null), tampilkan info ini --}}
                    <div class="col-12">
                        <div class="alert alert-soft-info border-0 rounded-3 mb-0 p-3">
                            <div class="d-flex align-items-start gap-2">
                                <i data-feather="info" class="text-info flex-shrink-0 mt-1 icon-18"></i>
                                <span class="small text-info">Kamu mendaftar pakai akun Google. Yuk, buat password di
                                    bawah ini sebagai alternatif login-mu nanti!</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-12">
                    <label class="form-label fw-semibold" for="password">Password Baru</label>
                    <div class="position-relative">
                        <input type="password" id="password" name="password" class="form-control custom-input pe-5"
                            required>
                        {{-- PERBAIKAN: Memanggil btn-transparent --}}
                        <button type="button" tabindex="-1"
                            class="btn btn-transparent border-0 shadow-none position-absolute top-50 end-0 translate-middle-y text-muted"
                            onmousedown="event.preventDefault()" onclick="togglePassword('password', this)">
                            {{-- PERBAIKAN: Memanggil icon-18 --}}
                            <i data-feather="eye" class="icon-18"></i>
                        </button>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold" for="password_confirmation">Konfirmasi Password Baru</label>
                    <div class="position-relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control custom-input pe-5" required>
                        {{-- PERBAIKAN: Memanggil btn-transparent --}}
                        <button type="button" tabindex="-1"
                            class="btn btn-transparent border-0 shadow-none position-absolute top-50 end-0 translate-middle-y text-muted"
                            onmousedown="event.preventDefault()"
                            onclick="togglePassword('password_confirmation', this)">
                            {{-- PERBAIKAN: Memanggil icon-18 --}}
                            <i data-feather="eye" class="icon-18"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3 mt-5">
                <button type="button" class="btn btn-soft-secondary rounded-pill px-4 py-2 js-close-modal"
                    data-target="passwordModal">
                    Batal
                </button>
                <button type="submit"
                    class="btn btn-soft-success rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                    <i data-feather="save"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>
