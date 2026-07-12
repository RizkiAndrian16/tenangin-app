@extends('layouts.main')
@section('title', 'Riwayat Rekomendasi - Tenangin.')
@section('content')
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">
                    {{ auth()->user()->role === 'admin' ? 'Data Riwayat Rekomendasi' : 'Riwayat Rekomendasi' }}
                </h1>
                <p class="text-muted mb-0">
                    {{ auth()->user()->role === 'admin'
                        ? 'Pantau seluruh riwayat rekomendasi dari semua mahasiswa.'
                        : 'Riwayat hasil rekomendasi aktivitas relaksasi Anda.' }}
                </p>
            </div>
        </div>
    </div>
    @if (session('success'))
        <div class="profile-success-alert mb-4" id="successAlert">
            <div class="d-flex align-items-start gap-3">
                <div class="profile-success-icon">
                    <i data-feather="check-circle"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Sukses!</h6>
                    <p class="mb-0">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="collapse d-sm-block" id="collapseFilter">
        <form id="filterForm" method="GET" action="{{ route('recommendations.history') }}">
            <div class="card filter-card mb-2">
                <div class="card-body">
                    <x-filter-table :showStressLevel="true" :showDate="true" :showStatus="false" :showIntensity="false"
                        :resetRoute="route('recommendations.history')" />
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body table-card-body">
            <div class="table-toolbar">
                <div class="d-flex justify-content-between align-items-center align-self-stretch">
                    <x-show-entries />

                    <button
                        class="btn btn-soft-secondary d-inline-flex d-sm-none justify-content-center align-items-center rounded-3"
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false"
                        aria-controls="collapseFilter">
                        <i data-feather="filter" class="icon-16"></i>
                    </button>
                </div>

                <div class="toolbar-actions">
                    <button type="button" id="btnBulkDelete"
                        class="btn btn-soft-danger btn-sm rounded-pill px-3 py-2 align-items-center gap-1">
                        <i data-feather="trash-2"></i>
                    </button>
                    <div class="search-wrapper">
                        <i data-feather="search" class="search-icon"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control search-input" placeholder="Search..." form="filterForm">
                    </div>
                </div>
            </div>

            <!-- Bungkus tabel dengan Form Bulk Delete -->
            <form id="bulkDeleteForm" action="{{ route('recommendations.bulk-destroy') }}" method="POST"
                class="form-table-wrapper">
                @csrf
                @method('DELETE')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th width="2.5%"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                                <th width="3.5%">No</th>

                                @if (auth()->user()->role === 'admin')
                                    <th>Nama Mahasiswa</th>
                                @endif

                                <th>Tanggal</th>
                                <th>Tingkat Stres</th>
                                <th>Preferensi Aktivitas</th>
                                <th>Total Aktivitas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recommendations as $recommendation)
                                <tr class="text-center">
                                    <td>
                                        <input type="checkbox" name="ids[]" value="{{ $recommendation->id }}"
                                            class="form-check-input check-item">
                                    </td>
                                    <td>{{ $recommendations->firstItem() + $loop->index }}</td>

                                    @if (auth()->user()->role === 'admin')
                                        <td class="fw-medium">
                                            {{ $recommendation->user->name ?? 'Tidak Diketahui' }}</td>
                                    @endif

                                    <td data-date="{{ $recommendation->created_at->format('Y-m-d') }}">
                                        {{ $recommendation->created_at->translatedFormat('l, d-m-Y') }}</td>
                                    <td>
                                        @if ($recommendation->pssAssessment)
                                            <div class="d-flex flex-column align-items-center gap-1">
                                                @if ($recommendation->pssAssessment->stress_level == 'Rendah')
                                                    <span class="badge badge-soft-success rounded-pill"
                                                        data-stress="Rendah">Rendah</span>
                                                @elseif ($recommendation->pssAssessment->stress_level == 'Sedang')
                                                    <span class="badge badge-soft-warning rounded-pill"
                                                        data-stress="Sedang">Sedang</span>
                                                @else
                                                    <span class="badge badge-soft-danger rounded-pill"
                                                        data-stress="Tinggi">Tinggi</span>
                                                @endif

                                                {{-- Cek apakah datanya diambil dari tong sampah --}}
                                                @if ($recommendation->pssAssessment->trashed())
                                                    <span class="text-muted" style="font-size: 0.75rem;">(Assessment
                                                        Dihapus)</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">Data Tidak Tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($recommendation->userPreference)
                                            {{ $recommendation->userPreference->preferred_activity_type }} /
                                            {{ $recommendation->userPreference->preferred_duration }} /
                                            {{ $recommendation->userPreference->preferred_intensity }}
                                        @else
                                            <span class="text-muted">Preference tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $recommendation->recommendationItems->count() }}</strong> Aktivitas
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            @if ($recommendation->pssAssessment)
                                                <a href="{{ route('recommendations.history.show', $recommendation->id) }}"
                                                    class="btn btn-soft-info btn-sm rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1">
                                                    <span>Detail</span>
                                                    <i data-feather="eye"></i>
                                                </a>
                                            @else
                                                <button
                                                    class="btn btn-soft-secondary btn-sm rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1"
                                                    disabled>
                                                    <span>Detail</span>
                                                    <i data-feather="eye-off"></i>
                                                </button>
                                            @endif

                                            <!-- Tombol Hapus Satuan -->
                                            <button type="button" data-id="{{ $recommendation->id }}"
                                                class="btn btn-soft-danger btn-sm rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 js-delete-single">
                                                <span>Hapus</span>
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data riwayat
                                        rekomendasi.
                                    </td>
                                </tr>
                            @endforelse
                            <tr id="emptyFilterRow" class="is-hidden">
                                <td colspan="7" class="text-center text-muted py-4">Tidak ada data riwayat
                                    rekomendasi
                                    yang sesuai.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
            <div class="pagination-container">
                {{ $recommendations->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
