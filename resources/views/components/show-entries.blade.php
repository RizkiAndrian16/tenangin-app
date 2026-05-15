<div class="show-entries-wrapper d-flex align-items-center gap-2 mb-3">

    <span class="show-entries-text">
        Show
    </span>

    <select name="per_page" class="form-select show-entries-select auto-submit-filter" form="filterForm">

        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>
            5
        </option>

        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>
            10
        </option>

        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>
            20
        </option>

        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>
            50
        </option>

    </select>

    <span class="show-entries-text">
        entries
    </span>

</div>
