@extends('layouts.main')

@section('title', 'Dashboard - Tenangin.')

@section('content')

    {{-- HEADER --}}
    <div class="mb-3">

        <h1 class="h3 d-inline align-middle">

            Dashboard

        </h1>

        <p class="text-muted mb-0">

            Selamat datang kembali di Tenangin. 👋

        </p>

    </div>

    {{-- ACTION BUTTON --}}
    <div class="row mb-4">

        <div class="col-12">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center flex-wrap">

                        <div>

                            <h4 class="mb-1">

                                Mulai PSS-10 Assessment

                            </h4>

                            <p class="text-muted mb-0">

                                Lakukan assessment untuk mengetahui tingkat stres Anda.

                            </p>

                        </div>

                        <div class="mt-3 mt-md-0">

                            <a href="{{ route('pss-assessments.create') }}" class="btn btn-primary">

                                Mulai PSS-10 Assessment

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- STATISTICS --}}
    <div class="row">

        {{-- TOTAL ASSESSMENT --}}
        <div class="col-xl-4 col-md-6">

            <div class="card">

                <div class="card-body">

                    <div class="row">

                        <div class="col mt-0">

                            <h5 class="card-title">

                                Total Assessment

                            </h5>

                        </div>

                        <div class="col-auto">

                            <div class="stat text-primary">

                                <i class="align-middle" data-feather="clipboard"></i>

                            </div>

                        </div>

                    </div>

                    <h1 class="mt-1 mb-3">

                        0

                    </h1>

                    <div class="mb-0">

                        <span class="text-muted">

                            Total assessment yang telah dilakukan

                        </span>

                    </div>

                </div>

            </div>

        </div>

        {{-- TOTAL RECOMMENDATION --}}
        <div class="col-xl-4 col-md-6">

            <div class="card">

                <div class="card-body">

                    <div class="row">

                        <div class="col mt-0">

                            <h5 class="card-title">

                                Total Recommendation

                            </h5>

                        </div>

                        <div class="col-auto">

                            <div class="stat text-success">

                                <i class="align-middle" data-feather="activity"></i>

                            </div>

                        </div>

                    </div>

                    <h1 class="mt-1 mb-3">

                        0

                    </h1>

                    <div class="mb-0">

                        <span class="text-muted">

                            Total rekomendasi aktivitas relaksasi

                        </span>

                    </div>

                </div>

            </div>

        </div>

        {{-- TOTAL FEEDBACK --}}
        <div class="col-xl-4 col-md-6">

            <div class="card">

                <div class="card-body">

                    <div class="row">

                        <div class="col mt-0">

                            <h5 class="card-title">

                                Feedback Activity

                            </h5>

                        </div>

                        <div class="col-auto">

                            <div class="stat text-warning">

                                <i class="align-middle" data-feather="message-square"></i>

                            </div>

                        </div>

                    </div>

                    <h1 class="mt-1 mb-3">

                        0

                    </h1>

                    <div class="mb-0">

                        <span class="text-muted">

                            Total feedback pengguna

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- LAST ASSESSMENT --}}
    <div class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-header">

                    <h5 class="card-title mb-0">

                        Assessment Terakhir

                    </h5>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered">

                            <thead>

                                <tr>

                                    <th>Total Score</th>
                                    <th>Tingkat Stres</th>
                                    <th>Tanggal</th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td>Belum ada data</td>
                                    <td>-</td>
                                    <td>-</td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
