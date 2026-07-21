@extends('layouts.main')
@section('title', 'Edit User - Tenangin.')
@section('content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Edit User</h1>
            <p class="text-muted mb-0">
                Perbarui informasi akun user dan hak akses.
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

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Parameter page untuk paginasi --}}
        <input type="hidden" name="page" value="{{ request('page', 1) }}">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <div class="row g-4">
                    {{-- NAMA LENGKAP --}}
                    <div class="col-12">
                        <label class="form-label text-muted fw-medium">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="form-control custom-input @error('name') is-invalid @enderror" required>
                    </div>

                    {{-- EMAIL --}}
                    <div class="col-12">
                        <label class="form-label text-muted fw-medium">Email</label>
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="email" class="form-control custom-input" value="{{ $user->email }}" disabled>
                    </div>

                    {{-- ROLE --}}
                    <div class="col-12">
                        <label class="form-label text-muted fw-medium">Role</label>
                        <select name="role" class="form-select custom-input @error('role') is-invalid @enderror"
                            required>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                            </option>
                            <option value="mahasiswa" {{ old('role', $user->role) == 'mahasiswa' ? 'selected' : '' }}>
                                Mahasiswa</option>
                        </select>
                    </div>

                    {{-- PASSWORD BARU DENGAN ICON MATA --}}
                    <div class="col-12">
                        <label class="form-label text-muted fw-medium">
                            Password <small class="text-muted fw-normal">(Kosongkan jika tidak ingin ganti)</small>
                        </label>
                        <div class="input-group">
                            <input type="password" name="password" id="inputPassword"
                                class="form-control custom-input border-end-0 @error('password') is-invalid @enderror">
                            <span class="input-group-text bg-white border-start-0 text-muted cursor-pointer"
                                onmousedown="event.preventDefault()" onclick="togglePassword('inputPassword', this)">
                                <i data-feather="eye" class="icon-18"></i>
                            </span>
                        </div>
                    </div>

                    {{-- KONFIRMASI PASSWORD DENGAN ICON MATA --}}
                    <div class="col-12">
                        <label class="form-label text-muted fw-medium">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="inputPasswordConfirm"
                                class="form-control custom-input border-end-0">
                            <span class="input-group-text bg-white border-start-0 text-muted cursor-pointer"
                                onmousedown="event.preventDefault()" onclick="togglePassword('inputPasswordConfirm', this)">
                                <i data-feather="eye" class="icon-18"></i>
                            </span>
                        </div>
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
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>

@endsection
