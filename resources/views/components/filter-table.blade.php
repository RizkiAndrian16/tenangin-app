@props([
    'showStressLevel' => true,
    'showDate' => true,
    'showStatus' => false,
    'showIntensity' => false,
    'showIsCompleted' => false, // PROPERTI BARU
    'showIsHelpful' => false, // PROPERTI BARU
    'resetRoute' => null,
])

<div class="filter-container">

    {{-- FILTER LEFT --}}
    <div class="filter-wrapper">

        <div class="filter-group">

            {{-- FILTER STRESS --}}
            @if ($showStressLevel)
                <div class="d-flex flex-column gap-1 filter-field">

                    <label class="filter-label">Tingkat Stres</label>

                    <select id="filterStressLevel" name="stress_level" class="form-select filter-input auto-submit-filter">

                        <option value="">
                            Semua Tingkat Stres
                        </option>

                        <option value="Rendah" {{ request('stress_level') == 'Rendah' ? 'selected' : '' }}>
                            Rendah
                        </option>

                        <option value="Sedang" {{ request('stress_level') == 'Sedang' ? 'selected' : '' }}>
                            Sedang
                        </option>

                        <option value="Tinggi" {{ request('stress_level') == 'Tinggi' ? 'selected' : '' }}>
                            Tinggi
                        </option>

                    </select>

                </div>
            @endif

            {{-- FILTER DATE --}}
            @if ($showDate)
                <div class="d-flex flex-column gap-1 filter-field">

                    <label class="filter-label">Tanggal</label>

                    <input type="date" id="filterDateFrom" name="date" value="{{ request('date') }}"
                        class="form-control filter-input auto-submit-filter">

                </div>
            @endif

            {{-- FILTER INTENSITAS --}}
            @if ($showIntensity)
                <div class="d-flex flex-column gap-1 filter-field">

                    <label class="filter-label">Intensitas</label>

                    <select name="intensity_level" class="form-select filter-input auto-submit-filter">

                        <option value="">
                            Semua Intensitas
                        </option>

                        <option value="Ringan" {{ request('intensity_level') == 'Ringan' ? 'selected' : '' }}>
                            Ringan
                        </option>

                        <option value="Sedang" {{ request('intensity_level') == 'Sedang' ? 'selected' : '' }}>
                            Sedang
                        </option>

                    </select>
                </div>
            @endif

            {{-- FILTER STATUS REKOMENDASI --}}
            @if ($showStatus)
                <div class="d-flex flex-column gap-1 filter-field">

                    <label class="filter-label">Status Rekomendasi</label>

                    <select name="status" class="form-select filter-input filter-status auto-submit-filter">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="Direkomendasikan"
                            {{ request('status') == 'Direkomendasikan' ? 'selected' : '' }}>
                            Direkomendasikan
                        </option>

                        <option value="Direkomendasikan terbatas"
                            {{ request('status') == 'Direkomendasikan terbatas' ? 'selected' : '' }}>
                            Direkomendasikan terbatas
                        </option>

                        <option value="Tidak direkomendasikan"
                            {{ request('status') == 'Tidak direkomendasikan' ? 'selected' : '' }}>
                            Tidak direkomendasikan
                        </option>

                        <option value="Perlu perhatian" {{ request('status') == 'Perlu perhatian' ? 'selected' : '' }}>
                            Perlu perhatian
                        </option>

                    </select>
                </div>
            @endif

            {{-- FILTER STATUS PENYELESAIAN --}}
            @if ($showIsCompleted)
                <div class="d-flex flex-column gap-1 filter-field">
                    <label class="filter-label">Status Penyelesaian</label>
                    <select name="is_completed" class="form-select filter-input auto-submit-filter">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('is_completed') === '1' ? 'selected' : '' }}>Selesai</option>
                        <option value="0" {{ request('is_completed') === '0' ? 'selected' : '' }}>Tidak Selesai
                        </option>
                    </select>
                </div>
            @endif

            {{-- FILTER BERMANFAAT --}}
            @if ($showIsHelpful)
                <div class="d-flex flex-column gap-1 filter-field">
                    <label class="filter-label">Bermanfaat?</label>
                    <select name="is_helpful" class="form-select filter-input auto-submit-filter">
                        <option value="">Semua Penilaian</option>
                        <option value="1" {{ request('is_helpful') === '1' ? 'selected' : '' }}>Bermanfaat (Ya)
                        </option>
                        <option value="0" {{ request('is_helpful') === '0' ? 'selected' : '' }}>Tidak Bermanfaat
                        </option>
                    </select>
                </div>
            @endif

        </div>

    </div>

    {{-- RESET BUTTON --}}
    <a href="{{ $resetRoute }}" id="btnResetFilter"
        class="btn btn-soft-secondary px-4
    {{ !request()->hasAny(['stress_level', 'date', 'status', 'intensity_level', 'search', 'per_page', 'is_completed', 'is_helpful']) ? 'pe-none' : '' }}">
        Reset Filter
    </a>
</div>
