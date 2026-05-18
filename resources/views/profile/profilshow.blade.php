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
                    <label class="form-label fw-semibold" for="inputResidence">Status Tempat Tinggal</label>
                    <select id="inputResidence" name="residence_status" class="form-select custom-input"
                        data-current="{{ auth()->user()->residence_status }}">
                        <option value="">Pilih Status</option>
                        @foreach (['Rumah Orang Tua', 'Kos', 'Asrama', 'Kontrakan', 'Lainnya'] as $status)
                            <option value="{{ $status }}"
                                {{ auth()->user()->residence_status === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" id="inputResidenceOther" name="residence_status_other"
                        class="form-control custom-input mt-3" placeholder="Tuliskan status tempat tinggal Anda..."
                        style="display:none;">
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
