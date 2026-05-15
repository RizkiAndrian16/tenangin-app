@props([
    'showStressLevel' => true,
    'showDate' => true,
])

<div class="filter-container">

    {{-- FILTER LEFT --}}
    <div class="filter-wrapper">

        <div class="filter-group">

            {{-- FILTER STRESS --}}
            @if ($showStressLevel)
                <div class="d-flex flex-column gap-1">

                    <label class="filter-label">
                        Tingkat Stres
                    </label>

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
                <div class="d-flex flex-column gap-1">

                    <label class="filter-label">
                        Tanggal
                    </label>

                    <input type="date" id="filterDateFrom" name="date" value="{{ request('date') }}"
                        class="form-control filter-input auto-submit-filter">

                </div>
            @endif

        </div>

    </div>

    {{-- RESET BUTTON --}}
    <a href="{{ route('pss-assessments.index') }}" id="btnResetFilter"
        class="btn btn-soft-secondary px-4
        {{ !request('stress_level') && !request('date') && !request('per_page') ? 'pe-none' : '' }}">

        Reset Filter

    </a>
</div>
