{{-- ACTIVITY DETAIL MODAL --}}
<div class="custom-popup-overlay" id="activityModal">
    <div class="custom-popup activity-popup">
        <button class="custom-popup-close js-close-modal" data-target="activityModal">
            <i data-feather="x"></i>
        </button>

        <h4 class="fw-bold mb-1">Detail Aktivitas Relaksasi</h4>
        <p class="text-muted fw-semibold small mb-4">Rincian informasi aktivitas relaksasi.</p>

        {{-- NAMA --}}
        <div class="card border-0 rounded-4 mb-3 score-hero-bg activity-popup-card">
            <div class="card-body p-3">
                <p class="fw-bold mb-1">Nama Aktivitas</p>
                <p class="text-muted fw-semibold small mb-0" id="popupTitleDetail">—</p>
            </div>
        </div>

        {{-- JENIS, DURASI, INTENSITAS, STRES --}}
        <div class="card border-0 rounded-4 mb-3 score-hero-bg activity-popup-card">
            <div class="card-body p-0">
                <div class="row g-0 text-center">
                    <div class="col-6 p-3 border-end border-bottom popup-grid-cell">
                        <p class="fw-bold mb-1">Jenis Aktivitas</p>
                        <p class="text-muted fw-semibold small mb-0" id="popupType">—</p>
                    </div>
                    <div class="col-6 p-3 border-bottom popup-grid-cell">
                        <p class="fw-bold mb-1">Kategori Durasi</p>
                        <p class="text-muted fw-semibold small mb-0" id="popupDuration">—</p>
                    </div>
                    <div class="col-6 p-3 border-end popup-grid-cell">
                        <p class="fw-bold mb-1">Tingkat Intensitas</p>
                        <p class="text-muted fw-semibold small mb-0" id="popupIntensity">—</p>
                    </div>
                    <div class="col-6 p-3 popup-grid-cell">
                        <p class="fw-bold mb-1">Target Tingkat Stres</p>
                        <p class="text-muted fw-semibold small mb-0" id="popupStress">—</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATUS --}}
        <div class="card border-0 rounded-4 mb-3 score-hero-bg activity-popup-card">
            <div class="card-body p-3">
                <p class="fw-bold mb-1">Status Rekomendasi</p>
                <p class="text-muted fw-semibold small mb-0" id="popupStatusText">—</p>
            </div>
        </div>

        {{-- DESKRIPSI --}}
        <div class="card border-0 rounded-4 mb-3 score-hero-bg activity-popup-card">
            <div class="card-body p-3">
                <p class="fw-bold mb-1">Deskripsi Aktivitas</p>
                <p class="text-muted fw-semibold small mb-0" id="popupDescription">—</p>
            </div>
        </div>

        {{-- INSTRUKSI --}}
        <div class="card border-0 rounded-4 mb-3 score-hero-bg activity-popup-card">
            <div class="card-body p-3">
                <p class="fw-bold mb-1">Instruksi dan Konteks Pelaksanaan Aktivitas</p>
                <p class="text-muted fw-semibold small mb-0" id="popupInstruction">—</p>
            </div>
        </div>

    </div>
</div>
