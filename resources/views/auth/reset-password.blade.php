<x-guest-layout>
    <!-- Judul & Deskripsi -->
    <h1>Reset Password</h1>
    <p class="sub auth-mb-24">
        Masukkan password baru Anda
    </p>

    <!-- Notifikasi Error -->
    @if ($errors->any())
        <div class="alert alert-danger auth-alert-custom">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Form Input -->
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <!-- TOKEN -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- EMAIL -->
        <div class="mb-3">
            <label class="auth-field-label">Email</label>
            <div class="auth-input-wrap">
                <input type="email" name="email" class="auth-input auth-input-readonly"
                    value="{{ old('email', $request->email) }}" required readonly>
            </div>
        </div>

        <!-- PASSWORD BARU -->
        <div class="mb-3">
            <label class="auth-field-label">Password Baru</label>
            <div class="auth-input-wrap">
                <input id="reset_password" type="password" name="password" class="auth-input has-toggle"
                    placeholder="Masukkan password baru" required>
                <!-- Tombol Intip Password -->
                <button type="button" class="auth-input-toggle" tabindex="-1" data-password-toggle="reset_password">
                    <i data-feather="eye-off" class="icon-18"></i>
                </button>
            </div>
        </div>

        <!-- KONFIRMASI PASSWORD -->
        <div class="auth-mb-24">
            <label class="auth-field-label">Konfirmasi Password</label>
            <div class="auth-input-wrap">
                <input id="reset_password_confirmation" type="password" name="password_confirmation"
                    class="auth-input has-toggle" placeholder="Ulangi password baru" required>
                <!-- Tombol Intip Password -->
                <button type="button" class="auth-input-toggle" tabindex="-1"
                    data-password-toggle="reset_password_confirmation">
                    <i data-feather="eye-off" class="icon-18"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="auth-submit-btn">
            Simpan Password Baru
        </button>
    </form>

    <!-- Link Kembali -->
    <div class="auth-footer-link">
        <a href="{{ route('login') }}" class="auth-link">Kembali ke login</a>
    </div>
</x-guest-layout>
