<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Forgot Password - StressCheck</title>

    <!-- ADMIN KIT CSS -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
</head>

<body>

    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-md-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2">Reset Password</h1>
                            <p class="lead">
                                Masukkan email untuk mendapatkan link reset
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">

                                    <!-- SUCCESS -->
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <!-- ERROR -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            {{ $errors->first() }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf

                                        <!-- EMAIL -->
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control form-control-lg"
                                                value="{{ old('email') }}" placeholder="Enter your email" required>
                                        </div>

                                        <!-- BUTTON -->
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                Kirim Link Reset
                                            </button>
                                        </div>

                                    </form>

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

</body>

</html>
