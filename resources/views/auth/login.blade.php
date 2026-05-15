<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - StressCheck</title>

    <!-- ADMIN KIT CSS -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>

    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <!-- HEADER -->
                        <div class="text-center mt-4">
                            <h1 class="h2">Welcome back</h1>
                            <p class="lead">
                                Sign in to your account
                            </p>
                        </div>

                        <!-- CARD -->
                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">

                                    <!-- AVATAR -->
                                    <div class="text-center mb-4">
                                        <img src="{{ asset('assets/img/avatars/avatar6.jpg') }}"
                                            class="img-fluid rounded-circle" width="120" height="120">
                                    </div>

                                    <!-- ERROR -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            {{ $errors->first() }}
                                        </div>
                                    @endif

                                    <!-- FORM -->
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <!-- EMAIL -->
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input class="form-control form-control-lg" type="email" name="email"
                                                value="{{ old('email') }}" placeholder="Enter your email" required>
                                        </div>

                                        <!-- PASSWORD -->
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password"
                                                placeholder="Enter your password" required>
                                        </div>

                                        <div class="mb-3 text-end">
                                            <a href="{{ route('password.request') }}">
                                                Lupa password?
                                            </a>
                                        </div>

                                        <!-- REMEMBER -->
                                        <div class="mb-3">
                                            <label class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember">
                                                <span class="form-check-label">
                                                    Remember me
                                                </span>
                                            </label>
                                        </div>

                                        <!-- BUTTON -->
                                        <div class="d-grid gap-2 mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary">
                                                Sign in
                                            </button>
                                        </div>

                                    </form>

                                    <!-- REGISTER LINK -->
                                    <div class="text-center mt-3">
                                        <small>
                                            Belum punya akun?
                                            <a href="{{ route('register') }}">Register</a>
                                        </small>
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
