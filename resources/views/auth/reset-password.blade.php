<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Reset Password - StressCheck</title>

    <!-- ADMIN KIT CSS -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>

    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-md-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <!-- HEADER -->
                        <div class="text-center mt-4">
                            <h1 class="h2">Reset Password</h1>
                            <p class="lead">
                                Masukkan password baru Anda
                            </p>
                        </div>

                        <!-- CARD -->
                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">

                                    <!-- ERROR -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            {{ $errors->first() }}
                                        </div>
                                    @endif

                                    <!-- FORM -->
                                    <form method="POST" action="{{ route('password.store') }}">
                                        @csrf

                                        <!-- TOKEN -->
                                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                        <!-- EMAIL -->
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control form-control-lg"
                                                value="{{ old('email', $request->email) }}" required readonly>
                                        </div>

                                        <!-- PASSWORD -->
                                        <div class="mb-3">
                                            <label class="form-label">Password Baru</label>
                                            <input type="password" name="password" class="form-control form-control-lg"
                                                placeholder="Masukkan password baru" required>
                                        </div>

                                        <!-- CONFIRM PASSWORD -->
                                        <div class="mb-3">
                                            <label class="form-label">Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation"
                                                class="form-control form-control-lg" placeholder="Ulangi password"
                                                required>
                                        </div>

                                        <!-- BUTTON -->
                                        <div class="d-grid mt-3">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                Reset Password
                                            </button>
                                        </div>

                                    </form>

                                    <!-- BACK -->
                                    <div class="text-center mt-3">
                                        <a href="{{ route('login') }}">Kembali ke login</a>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- ADMIN KIT JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
