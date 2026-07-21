@extends('layouts.main')
@section('title', 'Users - Tenangin.')
@section('content')

    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center gap-2 gap-sm-3 mb-3 mb-sm-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Data User</h1>
            <p class="text-muted mb-0">Pengelolaan data User yang terdaftar di sistem.</p>
        </div>

        <div class="d-grid d-sm-block">
            {{-- Ditambahkan d-inline-flex, align-items-center, justify-content-center, dan gap-2 --}}
            <a href="{{ route('users.create') }}"
                class="btn btn-soft-success rounded-pill px-4 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                {{-- Ikon plus disembunyikan di HP (d-none) dan dimunculkan di layar sm ke atas (d-sm-block) --}}
                <i data-feather="plus" class="icon-18 d-none d-sm-block"></i>
                <span>Tambah Pengguna</span>
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
        <form id="filterForm" method="GET" action="{{ route('users.index') }}">
            <div class="card filter-card mb-2">
                <div class="card-body">
                    {{-- Kita panggil x-filter-table dengan Role dan Gender bernilai True --}}
                    <x-filter-table :showStressLevel="false" :showDate="false" :showStatus="false" :showIntensity="false"
                        :showRole="true" :showGender="true" :resetRoute="route('users.index')" />
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

            <form id="bulkDeleteForm" action="{{ route('users.bulk-destroy') }}" method="POST" class="form-table-wrapper">
                @csrf
                @method('DELETE')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th width="2.5%"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                                <th width="3.5%">No</th>
                                <th>Nama Pengguna</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Jenis Kelamin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($users as $user)
                                <tr class="text-center">
                                    <td>
                                        <input type="checkbox" name="ids[]" value="{{ $user->id }}"
                                            class="form-check-input check-item">
                                    </td>
                                    <td>{{ $users->firstItem() + $loop->index }}</td>
                                    <td class="fw-medium">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>

                                    <td>
                                        @if ($user->role == 'admin')
                                            <span class="badge badge-soft-success rounded-pill px-2">Admin</span>
                                        @else
                                            <span class="badge badge-soft-success rounded-pill px-2">Mahasiswa</span>
                                        @endif
                                    </td>

                                    <td>{{ $user->gender ?? '-' }}</td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-nowrap">
                                            <a href="{{ route('users.show', $user->id) }}"
                                                class="btn btn-soft-info btn-sm rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1">
                                                <span>Detail</span>
                                                <i data-feather="eye"></i>
                                            </a>

                                            <a href="{{ route('users.edit', [$user->id, 'page' => request('page')]) }}"
                                                class="btn btn-soft-warning btn-sm rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1">
                                                <span>Edit</span>
                                                <i data-feather="edit"></i>
                                            </a>

                                            <button type="button" data-id="{{ $user->id }}"
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
                                        Belum ada data pengguna yang terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="pagination-container">
                {{ $users->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection
