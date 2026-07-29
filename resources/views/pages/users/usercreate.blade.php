@extends('layouts.main')
@section('title', 'Tambah Pengguna Baru - Tenangin.')
@section('content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Tambah Pengguna Baru</h1>
            <p class="text-muted mb-0">
                Masukkan informasi untuk mendaftarkan pengguna ke dalam sistem.
            </p>
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

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="form-control custom-input @error('name') is-invalid @enderror"
                            placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control custom-input @error('email') is-invalid @enderror"
                            placeholder="Masukkan alamat email" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select custom-input @error('role') is-invalid @enderror"
                            required>
                            <option value="">Pilih Role Akses</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                        <input type="hidden" name="password" value="12345678">
                        <input type="text" class="form-control custom-input" value="12345678" disabled>
                        <small class="text-muted d-block mt-1">
                            Otomatis diatur ke <b>12345678</b>. Pengguna dapat mengubahnya nanti.
                        </small>
                    </div>
                </div>

                {{-- NAVIGASI BUTTON --}}
                <div class="border-top pt-4 mt-4">
                    <div class="d-flex justify-content-end justify-content-md-between gap-3">
                        <a href="{{ route('users.index') }}"
                            class="btn btn-soft-secondary rounded-pill px-4 py-2 d-none d-md-flex align-items-center justify-content-center gap-2">
                            <i data-feather="arrow-left"></i>
                            <span>Kembali</span>
                        </a>

                        <button type="submit"
                            class="btn btn-soft-success rounded-pill px-4 py-2 d-flex align-items-center justify-content-center gap-2 flex-fill flex-md-grow-0">
                            <i data-feather="save"></i>
                            <span>Simpan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
