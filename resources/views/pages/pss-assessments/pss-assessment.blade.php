@extends('layouts.main')
@section('title', 'PSS-10 - Tenangin.')
@section('content')

    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center gap-2 gap-sm-3 mb-3 mb-sm-4">
        <div>
            <h1 class="h3 fw-bold mb-1">
                {{ auth()->user()->role === 'admin' ? 'Data PSS-10 Assessment' : 'PSS-10 Assessment' }}
            </h1>

            <p class="text-muted mb-0">
                {{ auth()->user()->role === 'admin'
                    ? 'Pantau seluruh hasil PSS-10 Assessment mahasiswa.'
                    : 'Riwayat hasil PSS-10 Assessment Anda.' }}
            </p>
        </div>

        {{-- ======================================
         ACTION BUTTON
        ====================================== --}}
        <div class="d-grid d-sm-block">
            {{-- MAHASISWA --}}
            @if (auth()->user()->role === 'mahasiswa')
                <a href="{{ route('pss-assessments.create') }}"
                    class="btn btn-soft-success rounded-pill px-4 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                    <i data-feather="plus" class="icon-18 d-none d-sm-block"></i>
                    <span>Mulai PSS-10 Assessment</span>
                </a>
            @endif

            {{-- ADMIN --}}
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('pss-assessments.export.pdf', [
                    'stress_level' => request('stress_level'),
                    'date' => request('date'),
                    'search' => request('search'),
                ]) }}"
                    class="btn btn-soft-danger rounded-pill px-4 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                    <i data-feather="file-text" class="icon-18"></i>
                    <span>Export PDF</span>
                </a>
            @endif
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

    @if (session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="collapse d-sm-block" id="collapseFilter">
        <form id="filterForm" method="GET" action="{{ route('pss-assessments.index') }}">
            <div class="card filter-card mb-2">
                <div class="card-body">
                    <x-filter-table :showStressLevel="true" :showDate="true" :resetRoute="route('pss-assessments.index')" />
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

            <form id="bulkDeleteForm" action="{{ route('pss-assessments.bulk-destroy') }}" method="POST"
                class="form-table-wrapper">
                @csrf
                @method('DELETE')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th width="2.5%"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                                <th width="3.5%">No</th>
                                {{-- Tambahkan kolom Nama Mahasiswa jika Admin --}}
                                @if (auth()->user()->role === 'admin')
                                    <th>Nama Mahasiswa</th>
                                @endif
                                <th>Tanggal</th>
                                <th>Tingkat Stres</th>
                                <th>Skor PSS-10</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($assessments as $assessment)
                                <tr class="text-center">
                                    <td>
                                        <input type="checkbox" name="ids[]" value="{{ $assessment->id }}"
                                            class="form-check-input check-item">
                                    </td>
                                    <td>
                                        {{ $assessments->firstItem() + $loop->index }}
                                    </td>

                                    {{-- Tampilkan Nama Mahasiswa jika Admin --}}
                                    @if (auth()->user()->role === 'admin')
                                        <td class="fw-medium">{{ $assessment->user->name ?? 'Tidak Diketahui' }}
                                        </td>
                                    @endif

                                    <td data-date="{{ $assessment->created_at->format('Y-m-d') }}">
                                        {{ $assessment->created_at->translatedFormat('l, d-m-Y') }}
                                    </td>
                                    <td>
                                        @if ($assessment->stress_level == 'Rendah')
                                            <span class="badge badge-soft-success rounded-pill" data-stress="Rendah">
                                                Rendah</span>
                                        @elseif ($assessment->stress_level == 'Sedang')
                                            <span class="badge badge-soft-warning rounded-pill" data-stress="Sedang">
                                                Sedang
                                            </span>
                                        @else
                                            <span class="badge badge-soft-danger rounded-pill" data-stress="Tinggi">
                                                Tinggi
                                            </span>
                                        @endif
                                    </td>

                                    <td><strong>{{ $assessment->total_score }}</strong> / 40</td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('pss-assessments.show', $assessment->id) }}"
                                                class="btn btn-soft-info btn-sm rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1">
                                                <span>Detail</span>
                                                <i data-feather="eye"></i>
                                            </a>

                                            <button type="button"
                                                class="btn btn-soft-danger btn-sm rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 js-delete-single"
                                                data-id="{{ $assessment->id }}">
                                                <span>Hapus</span>
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    {{-- Sesuaikan colspan (tambah 1) jika admin --}}
                                    <td colspan="{{ auth()->user()->role === 'admin' ? '7' : '6' }}"
                                        class="text-center text-muted py-4">
                                        Belum ada data PSS-10 Assessment.
                                    </td>
                                </tr>
                            @endforelse

                            <tr id="emptyFilterRow" class="is-hidden">
                                <td colspan="{{ auth()->user()->role === 'admin' ? '7' : '6' }}"
                                    class="text-center text-muted py-4">
                                    Tidak ada data PSS-10 Assessment yang sesuai.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
            <div class="pagination-container">
                {{ $assessments->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
