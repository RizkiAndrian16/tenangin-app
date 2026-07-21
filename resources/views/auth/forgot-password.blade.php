<x-guest-layout>

    <!-- Judul & Deskripsi -->
    <h1>Reset Password</h1>
    <p class="sub" style="margin-bottom: 24px;">
        Masukkan email Anda untuk menerima link reset
    </p>

    <!-- Notifikasi Sukses -->
    @if (session('status'))
        <div class="alert alert-success"
            style="font-size: 13px; border-radius: 12px; padding: 12px 16px; margin-bottom: 20px;">
            {{ session('status') }}
        </div>
    @endif

    <!-- Notifikasi Error -->
    @if ($errors->any())
        <div class="alert alert-danger"
            style="font-size: 13px; border-radius: 12px; padding: 12px 16px; margin-bottom: 20px;">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Form Input -->
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div style="margin-bottom: 24px;">
            <label class="auth-field-label">Email</label>
            <div class="auth-input-wrap">
                <input type="email" name="email" class="auth-input" value="{{ old('email') }}"
                    placeholder="nama@email.com" required autofocus>
            </div>
        </div>

        <button type="submit" class="auth-submit-btn">
            Kirim Link Reset <i data-feather="arrow-right"></i>
        </button>
    </form>

    <!-- Link Kembali -->
    <div style="text-align: center; margin-top: 24px;">
        <span style="color: #64748B; font-size: 13px;">Ingat password Anda? </span>
        <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
    </div>

</x-guest-layout>
