{{-- RULE BASED RULE DETAIL MODAL --}}
<div class="custom-popup-overlay" id="ruleBasedRuleModal">
    <div class="custom-popup activity-popup">
        <button class="custom-popup-close js-close-modal" data-target="ruleBasedRuleModal">
            <i data-feather="x"></i>
        </button>

        <h4 class="fw-bold mb-1">Detail Aturan Rekomendasi</h4>
        <p class="text-muted fw-semibold small mb-4">
            Rincian aturan rekomendasi berdasarkan tingkat stres.
        </p>

        {{-- TINGKAT STRES --}}
        <div class="card border-0 rounded-4 mb-3 score-hero-bg activity-popup-card overflow-hidden">
            <div class="card-body p-3">
                <p class="fw-bold mb-1 text-center">Kategori Tingkat Stres</p>

                <div id="popupRuleStressBadge" class="d-flex justify-content-center align-items-center">
                    —
                </div>
            </div>
        </div>

        {{-- AKTIVITAS, JENIS, INTENSITAS --}}
        <div class="card border-0 rounded-4 mb-3 score-hero-bg activity-popup-card overflow-hidden">
            <div class="card-body p-0 overflow-hidden">
                <div class="row g-0 text-center">

                    <div class="col-12 p-3 border-bottom popup-grid-cell">
                        <p class="fw-bold mb-1">Nama Aktivitas Relaksasi</p>
                        <p class="text-muted fw-semibold small mb-0" id="popupRuleActivity">
                            —
                        </p>
                    </div>

                    <div class="col-6 p-3 border-end popup-grid-cell">
                        <p class="fw-bold mb-1">Jenis Aktivitas</p>
                        <p class="text-muted fw-semibold small mb-0" id="popupRuleType">
                            —
                        </p>
                    </div>

                    <div class="col-6 p-3 popup-grid-cell">
                        <p class="fw-bold mb-1">Tingkat Intensitas</p>
                        <p class="text-muted fw-semibold small mb-0" id="popupRuleIntensity">
                            —
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- DESKRIPSI --}}
        <div class="card border-0 rounded-4 mb-3 score-hero-bg activity-popup-card overflow-hidden">
            <div class="card-body p-3">
                <p class="fw-bold mb-1">Deskripsi Aturan</p>

                <p class="text-muted fw-semibold small mb-0" id="popupRuleDescription">
                    —
                </p>
            </div>
        </div>

    </div>
</div>
