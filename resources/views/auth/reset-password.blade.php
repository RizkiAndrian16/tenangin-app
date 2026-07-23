<x-guest-layout>

    <style>
        /* Memangkas ruang kosong khusus di layar HP (Mobile) */
        @media (max-width: 860px) {
            .sliding-wrapper.auth-static-wrapper .form-login-side {
                padding: 50px 24px !important;
                /* Ubah angka 30px menjadi lebih kecil jika masih kurang rapat */
            }
        }
    </style>
    <!-- Judul & Deskripsi -->
    <h1>Reset Password</h1>
    <p class="sub" style="margin-bottom: 24px;">
        Masukkan password baru Anda
    </p>

    <!-- Notifikasi Error -->
    @if ($errors->any())
        <div class="alert alert-danger"
            style="font-size: 13px; border-radius: 12px; padding: 12px 16px; margin-bottom: 20px;">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Form Input -->
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- TOKEN -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- EMAIL -->
        <div style="margin-bottom: 20px;">
            <label class="auth-field-label">Email</label>
            <div class="auth-input-wrap">
                <input type="email" name="email" class="auth-input" value="{{ old('email', $request->email) }}"
                    required readonly style="background-color: #F8FAFC; color: #94A3B8;">
            </div>
        </div>

        <!-- PASSWORD BARU -->
        <div style="margin-bottom: 20px;">
            <label class="auth-field-label">Password Baru</label>
            <div class="auth-input-wrap">
                <input id="reset_password" type="password" name="password" class="auth-input has-toggle"
                    placeholder="Masukkan password baru" required>
                <!-- Tombol Intip Password -->
                <button type="button" class="auth-input-toggle" tabindex="-1"
                    onclick="togglePassword('reset_password', this)">
                    <i data-feather="eye-off" class="icon-18"></i>
                </button>
            </div>
        </div>

        <!-- KONFIRMASI PASSWORD -->
        <div style="margin-bottom: 24px;">
            <label class="auth-field-label">Konfirmasi Password</label>
            <div class="auth-input-wrap">
                <input id="reset_password_confirmation" type="password" name="password_confirmation"
                    class="auth-input has-toggle" placeholder="Ulangi password baru" required>
                <!-- Tombol Intip Password -->
                <button type="button" class="auth-input-toggle" tabindex="-1"
                    onclick="togglePassword('reset_password_confirmation', this)">
                    <i data-feather="eye-off" class="icon-18"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="auth-submit-btn">
            Simpan Password Baru
        </button>
    </form>

    <!-- Link Kembali -->
    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ route('login') }}" class="auth-link">Kembali ke login</a>
    </div>

</x-guest-layout>
