<div class="auth-right-body">
    <h1>Selamat Datang</h1>
    <p class="sub">Masuk ke akun Anda untuk melanjutkan</p>

    @if (session('status'))
        <div class="alert alert-soft-success mb-3 border-0 d-flex align-items-center gap-2">
            <i data-feather="check-circle" class="icon-18"></i>
            <p class="mb-0">{{ session('status') }}</p>
        </div>
    @endif

    @if ($errors->any() && !old('name'))
        <!-- Hanya tampilkan error login jika bukan dari register -->
        <div class="alert alert-soft-danger mb-3 border-0 d-flex align-items-center gap-2">
            <i data-feather="alert-circle" class="icon-18"></i>
            <p class="mb-0">{{ $errors->first() }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="auth-field-label" for="login_email">Email</label>
            <div class="auth-input-wrap">
                <input id="login_email" class="auth-input" type="email" name="email" value="{{ old('email') }}"
                    placeholder="nama@email.com" required autocomplete="username">
            </div>
        </div>

        <div class="mb-3">
            <label class="auth-field-label" for="login_password">Password</label>
            <div class="auth-input-wrap">
                <input id="login_password" class="auth-input has-toggle" type="password" name="password"
                    placeholder="Masukkan password" required autocomplete="current-password">
                <button type="button" class="auth-input-toggle" onclick="togglePassword('login_password', this)">
                    <i data-feather="eye-off" class="icon-18"></i>
                </button>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <label class="d-flex align-items-center gap-2 mb-0 cursor-pointer">
                <input class="form-check-input m-0" type="checkbox" name="remember"
                    style="position: relative; top: 1px;">
                <span class="text-muted" style="font-size: 13px;">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="auth-submit-btn mt-4">
            Masuk
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14"></path>
                <path d="m12 5 7 7-7 7"></path>
            </svg>
        </button>
    </form>

    <!-- DIVIDER -->
    <div class="auth-divider"><span>atau</span></div>

    <!-- LOGIN DENGAN GOOGLE -->
    {{-- Sesuaikan href dengan route Socialite Google yang tersedia di aplikasi --}}
    <a href="{{ Route::has('auth.google') ? route('auth.google') : '#' }}" class="auth-google-btn">
        <svg viewBox="0 0 24 24">
            <path fill="#4285F4"
                d="M23.52 12.27c0-.85-.08-1.67-.22-2.45H12v4.64h6.47c-.28 1.49-1.13 2.76-2.4 3.6v3h3.88c2.27-2.09 3.57-5.17 3.57-8.79z" />
            <path fill="#34A853"
                d="M12 24c3.24 0 5.96-1.07 7.95-2.9l-3.88-3c-1.08.72-2.45 1.15-4.07 1.15-3.13 0-5.78-2.11-6.73-4.95H1.27v3.11C3.25 21.3 7.28 24 12 24z" />
            <path fill="#FBBC05"
                d="M5.27 14.3c-.24-.72-.38-1.49-.38-2.3s.14-1.58.38-2.3V6.59H1.27C.46 8.19 0 10.04 0 12s.46 3.81 1.27 5.41z" />
            <path fill="#EA4335"
                d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.44-3.44C17.95 1.19 15.24 0 12 0 7.28 0 3.25 2.7 1.27 6.59l4 3.11C6.22 6.86 8.87 4.75 12 4.75z" />
        </svg>
        Masuk dengan Google
    </a>

    <div class="text-center mt-4">
        <small class="text-muted">
            Belum punya akun?
            <a onclick="toggleAuthMode(event, 'register')" class="auth-link">Daftar sekarang</a>
        </small>
    </div>
</div>
