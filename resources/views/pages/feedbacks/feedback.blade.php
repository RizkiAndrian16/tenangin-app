@extends('layouts.main')
@section('title', 'Feedback - Tenangin.')
@section('content')

    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center gap-2 gap-sm-3 mb-3 mb-sm-4">
        <div>
            <h1 class="h3 fw-bold mb-1">
                {{ auth()->user()->role === 'admin' ? 'Data Evaluasi Aktivitas' : 'Evaluasi Aktivitas' }}
            </h1>
            <p class="text-muted mb-0">
                {{ auth()->user()->role === 'admin'
                    ? 'Pantau hasil evaluasi aktivitas relaksasi yang diberikan oleh seluruh mahasiswa.'
                    : 'Hasil evaluasi aktivitas relaksasi yang telah Anda lakukan.' }}
            </p>
        </div>

        @if (auth()->user()->role === 'admin')
            <div class="d-grid d-sm-block">
                <a href="{{ route('feedbacks.export.pdf', [
                    'is_completed' => request('is_completed'),
                    'is_helpful' => request('is_helpful'),
                    'date' => request('date'),
                    'search' => request('search'),
                ]) }}"
                    class="btn btn-soft-danger rounded-pill px-4 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                    <i data-feather="file-text" class="icon-18"></i>
                    <span>Export PDF</span>
                </a>
            </div>
        @endif
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
        <form id="filterForm" method="GET" action="{{ route('feedbacks.index') }}">
            <div class="card filter-card mb-2">
                <div class="card-body">
                    <x-filter-table :showStressLevel="false" :showDate="true" :showStatus="false" :showIntensity="false"
                        :showIsCompleted="true" :showIsHelpful="true" :resetRoute="route('feedbacks.index')" />
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
                    {{-- Tombol Bulk Delete (Disembunyikan secara default oleh JS) --}}
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

            {{-- Bungkus tabel dengan Form Bulk Delete --}}
            <form id="bulkDeleteForm" action="{{ route('feedbacks.bulk-destroy') }}" method="POST"
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
                                <th>Aktivitas Relaksasi</th>
                                <th>Status Penyelesaian</th>
                                <th>Bermanfaat?</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($feedbacks as $feedback)
                                <tr class="text-center">
                                    <td>
                                        <input type="checkbox" name="ids[]" value="{{ $feedback->id }}"
                                            class="form-check-input check-item">
                                    </td>
                                    <td>{{ $feedbacks->firstItem() + $loop->index }}</td>

                                    @if (auth()->user()->role === 'admin')
                                        <td class="fw-medium">
                                            {{ $feedback->user->name ?? 'Tidak Diketahui' }}
                                        </td>
                                    @endif

                                    <td data-date="{{ $feedback->created_at->format('Y-m-d') }}">
                                        {{ $feedback->created_at->translatedFormat('l, d-m-Y') }}
                                    </td>

                                    <td class="text-center">
                                        <span class="fw-medium text-dark">
                                            {{ $feedback->recommendationItem->activity->title ?? 'Aktivitas Tidak Ditemukan' }}
                                        </span><br>
                                        <small class="text-muted">
                                            {{ $feedback->recommendationItem->activity->activity_type ?? '-' }}
                                        </small>
                                    </td>

                                    <td>
                                        @if ($feedback->is_completed)
                                            <span class="badge badge-soft-success rounded-pill">Selesai</span>
                                        @else
                                            <span class="badge badge-soft-danger rounded-pill">Tidak Selesai</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($feedback->is_helpful === true)
                                            <span class="badge badge-soft-success rounded-pill">Ya</span>
                                        @elseif ($feedback->is_helpful === false)
                                            <span class="badge badge-soft-danger rounded-pill">Tidak</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('feedbacks.show', $feedback->id) }}"
                                                class="btn btn-soft-info btn-sm rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1">
                                                <span>Detail</span>
                                                <i data-feather="eye"></i>
                                            </a>

                                            {{-- Tombol Hapus Satuan --}}
                                            <button type="button" data-id="{{ $feedback->id }}"
                                                class="btn btn-soft-danger btn-sm rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 js-delete-single">
                                                <span>Hapus</span>
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Belum ada data riwayat umpan balik.
                                    </td>
                                </tr>
                            @endforelse
                            <tr id="emptyFilterRow" class="is-hidden">
                                <td colspan="7" class="text-center text-muted py-4">
                                    Tidak ada data riwayat umpan balik yang sesuai.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="pagination-container">
                {{ $feedbacks->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
