@extends('layouts.main')
@section('title', 'Aturan Rekomendasi - Tenangin.')
@section('content')

    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center gap-2 gap-sm-3 mb-3 mb-sm-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Aturan Rekomendasi</h1>
            <p class="text-muted mb-0">
                Kelola aturan rekomendasi aktivitas relaksasi berdasarkan tingkat stres.
            </p>
        </div>

        <div class="d-grid d-sm-block">
            <a href="{{ route('rule-based-rules.create') }}"
                class="btn btn-soft-success rounded-pill px-4 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                <i data-feather="plus" class="icon-18 d-none d-sm-block"></i>
                <span>Tambah Aturan Rekomendasi</span>
            </a>
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
        <form id="filterForm" method="GET" action="{{ route('rule-based-rules.index') }}">
            <div class="card filter-card mb-2">
                <div class="card-body">
                    <x-filter-table :showStressLevel="true" :showDate="false" :showStatus="false" :showIntensity="true"
                        :resetRoute="route('rule-based-rules.index')" />
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

            <form id="bulkDeleteForm" action="{{ route('rule-based-rules.bulk-destroy') }}" method="POST"
                class="form-table-wrapper">
                @csrf
                @method('DELETE')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th width="2.5%"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                                <th width="3.5%">No</th>
                                <th>Tingkat Stres</th>
                                <th>Nama Aktivitas</th>
                                <th>Jenis Aktivitas</th>
                                <th>Intensitas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($rules as $rule)
                                <tr class="text-center">
                                    <td>
                                        <input type="checkbox" name="ids[]" value="{{ $rule->id }}"
                                            class="form-check-input check-item">
                                    </td>

                                    <td>{{ $rules->firstItem() + $loop->index }}</td>

                                    <td>
                                        @if ($rule->stress_level == 'Rendah')
                                            <span class="badge badge-soft-success rounded-pill px-3 py-2">
                                                Rendah
                                            </span>
                                        @elseif ($rule->stress_level == 'Sedang')
                                            <span class="badge badge-soft-warning rounded-pill px-3 py-2">
                                                Sedang
                                            </span>
                                        @else
                                            <span class="badge badge-soft-danger rounded-pill px-3 py-2">
                                                Tinggi
                                            </span>
                                        @endif
                                    </td>

                                    <td>{{ $rule->activity->title }}</td>
                                    <td>{{ $rule->activity->activity_type }}</td>
                                    <td>{{ $rule->activity->intensity_level }}</td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-nowrap">
                                            <button type="button"
                                                class="btn btn-soft-info btn-sm rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 js-open-rule"
                                                data-stress="{{ $rule->stress_level }}"
                                                data-activity="{{ $rule->activity->title }}"
                                                data-type="{{ $rule->activity->activity_type }}"
                                                data-intensity="{{ $rule->activity->intensity_level }}"
                                                data-description="{{ $rule->description }}">
                                                <span>Detail</span>
                                                <i data-feather="eye"></i>
                                            </button>

                                            <a href="{{ route('rule-based-rules.edit', [$rule->id, 'page' => request('page')]) }}"
                                                class="btn btn-soft-warning btn-sm rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1">
                                                <span>Edit</span>
                                                <i data-feather="edit"></i>
                                            </a>

                                            <button type="button" data-id="{{ $rule->id }}"
                                                class="btn btn-soft-danger btn-sm rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 js-delete-single">
                                                <span>Hapus</span>
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Belum ada data aturan rekomendasi.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </form>
            <div class="pagination-container">
                {{ $rules->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    @include('pages.rule-based-rules.rulebasedruleshow')

@endsection
