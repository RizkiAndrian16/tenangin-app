<x-guest-layout>
    <!-- Judul & Deskripsi -->
    <h1>Reset Password</h1>
    <p class="sub auth-mb-24">
        Masukkan email Anda untuk menerima link reset
    </p>

    <!-- Notifikasi Sukses -->
    @if (session('status'))
        <div class="alert alert-success auth-alert-custom">
            {{ session('status') }}
        </div>
    @endif

    <!-- Notifikasi Error -->
    @if ($errors->any())
        <div class="alert alert-danger auth-alert-custom">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Form Input -->
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="auth-mb-24">
            <label class="auth-field-label">Email</label>
            <div class="auth-input-wrap">
                <input type="email" name="email" class="auth-input" value="{{ old('email') }}"
                    placeholder="nama@email.com" required autofocus>
            </div>
        </div>

        <button type="submit" class="auth-submit-btn">
            Kirim Link Reset
        </button>
    </form>

    <!-- Link Kembali -->
    <div class="auth-footer-link">
        <span class="text-muted auth-fs-13">Ingat password Anda? </span>
        <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
    </div>
</x-guest-layout>
