@extends('layouts.main')
@section('title', 'Riwayat Rekomendasi - Tenangin.')
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Riwayat Rekomendasi</h1>
            <p class="text-muted mb-0">
                Riwayat hasil rekomendasi aktivitas relaksasi pengguna.
            </p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tingkat Stres</th>
                            <th>Preference</th>
                            <th>Total Aktivitas</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($recommendations as $recommendation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    @if ($recommendation->pssAssessment)
                                        {{ $recommendation->pssAssessment->stress_level }}
                                    @else
                                        <span class="text-muted">Tidak tersedia</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($recommendation->userPreference)
                                        {{ $recommendation->userPreference->preferred_activity_type }}
                                        /
                                        {{ $recommendation->userPreference->preferred_duration }}
                                    @else
                                        <span class="text-muted">
                                            Preference tidak tersedia
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $recommendation->recommendationItems->count() }}
                                </td>

                                <td>
                                    {{ $recommendation->created_at->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @empty

                            <tr>
                                <td colspan="5" class="text-center py-5">Belum ada riwayat rekomendasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $recommendations->links() }}
    </div>

@endsection
