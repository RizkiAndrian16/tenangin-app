//
// ======================================
// FEATHER ICON
// ======================================
//

document.addEventListener('DOMContentLoaded', () => {
    feather.replace();
});

//
// ======================================
// SCROLL TO TOP
// ======================================
//

const scrollButton = document.getElementById(
    'scrollTopButton'
);

if (scrollButton) {

    window.addEventListener('scroll', () => {

        scrollButton.style.display =
            window.scrollY > 300
                ? 'block'
                : 'none';

    });

    scrollButton.addEventListener('click', e => {

        e.preventDefault();

        window.scrollTo({

            top: 0,
            behavior: 'smooth'

        });

    });

}

//
// ======================================
// DARK MODE
// ======================================
//

document.addEventListener('DOMContentLoaded', () => {

    const toggleBtn = document.getElementById(
        'darkModeToggle'
    );

    const updateIcon = isDark => {

        if (!toggleBtn) return;

        toggleBtn.innerHTML = isDark
            ? feather.icons.sun.toSvg({
                class: 'align-middle'
            })
            : feather.icons.moon.toSvg({
                class: 'align-middle'
            });

    };

    const isDark =
        localStorage.getItem('theme') === 'dark';

    document.documentElement.classList.toggle(
        'dark-mode',
        isDark
    );

    updateIcon(isDark);

    toggleBtn?.addEventListener('click', e => {

        e.preventDefault();

        const darkMode = document.documentElement
            .classList.toggle('dark-mode');

        localStorage.setItem(
            'theme',
            darkMode ? 'dark' : 'light'
        );

        updateIcon(darkMode);

    });

});

//
// ======================================
// PSS FORM
// ======================================
//

if (window.pssForm) {

    // OPTION TOGGLE

    document.querySelectorAll('.btn-check')
        .forEach(radio => {

            radio.addEventListener('click', function () {

                if (this.wasChecked) {

                    this.checked = false;

                    this.wasChecked = false;

                } else {

                    document.querySelectorAll(
                        `input[name="${this.name}"]`
                    ).forEach(el => {

                        el.wasChecked = false;

                    });

                    this.wasChecked = true;

                }

            });

        });

    // VALIDATION

    pssForm.onsubmit = e => {

        const answered = document.querySelectorAll(
            '.btn-check:checked'
        ).length;

        const empty = [...document.querySelectorAll('.question-item')]
            .find(q =>
                !document.querySelector(
                    `input[name="answers[${q.dataset.question}]"]:checked`
                )
            );

        emptyAlert.style.display = 'none';

        questionAlert.style.display = 'none';

        document.querySelectorAll('.question-card')
            .forEach(card =>
                card.classList.remove('question-error')
            );

        // BELUM MENJAWAB SAMA SEKALI

        if (!answered) {

            e.preventDefault();

            emptyAlert.style.display = 'block';

            return window.scrollTo({

                top: 0,
                behavior: 'smooth'

            });

        }

        // MASIH ADA YANG KOSONG

        if (!empty) return;

        e.preventDefault();

        questionAlert.style.display = 'block';

        empty.querySelector('.question-card')
            .classList.add('question-error');

        empty.scrollIntoView({

            behavior: 'smooth',
            block: 'center'

        });

    };

    // AUTO FILL TESTING

    const btnAutoFill = document.getElementById('btnAutoFill');

    btnAutoFill?.addEventListener('click', () => {

        for (let i = 1; i <= 10; i++) {

            const randomValue = Math.floor(
                Math.random() * 5
            );

            document.getElementById(
                `question${i}_${randomValue}`
            )?.click();

        }

    });

}

//
// ======================================
// PREFERENCE FORM VALIDATION
// ======================================
//

if (window.preferenceForm) {

    preferenceForm.onsubmit = e => {

        const type = document.querySelector(
            'select[name="preferred_activity_type"]'
        ).value;

        const duration = document.querySelector(
            'select[name="preferred_duration"]'
        ).value;

        const intensity = document.querySelector(
            'select[name="preferred_intensity"]'
        ).value;

        const alertBox = document.getElementById('preferenceAlert');

        // Jika ada satu saja yang belum dipilih
        if (!type || !duration || !intensity) {

            e.preventDefault();

            alertBox.style.display = 'block';

            alertBox.scrollIntoView({

                behavior: 'smooth',
                block: 'center'

            });

        } else {

            // Sembunyikan alert jika sudah lengkap
            alertBox.style.display = 'none';

        }

    };

}

//
// ======================================
// BULK DELETE
// ======================================
//

const checkAll = document.getElementById(
    'checkAll'
);

const btnBulkDelete = document.getElementById(
    'btnBulkDelete'
);

const bulkDeleteForm = document.getElementById(
    'bulkDeleteForm'
);

if (checkAll && btnBulkDelete && bulkDeleteForm) {

    // TOGGLE BUTTON

    const toggleBulkButton = () => {

        btnBulkDelete.style.display =
            document.querySelectorAll(
                '.check-item:checked'
            ).length > 0
                ? 'inline-flex'
                : 'none';

    };

    // CHECK ALL

    checkAll.addEventListener('change', function () {

        document.querySelectorAll('.check-item')
            .forEach(cb => cb.checked = this.checked);

        toggleBulkButton();

    });

    // SINGLE CHECK

    document.querySelectorAll('.check-item')
        .forEach(cb => {

            cb.addEventListener('change', () => {

                const total = document.querySelectorAll(
                    '.check-item'
                ).length;

                const checked = document.querySelectorAll(
                    '.check-item:checked'
                ).length;

                checkAll.checked = total === checked;

                checkAll.indeterminate =
                    checked > 0 && checked < total;

                toggleBulkButton();

            });

        });

    // BULK DELETE

    btnBulkDelete.addEventListener('click', () => {

        const checked = document.querySelectorAll(
            '.check-item:checked'
        ).length;

        if (
            confirm(
                `Yakin ingin menghapus ${checked} item yang dipilih?`
            )
        ) {

            bulkDeleteForm.submit();

        }

    });

}

// SINGLE DELETE

const deleteSingle = id => {

    if (!confirm('Yakin ingin menghapus item ini?')) return;

    document.querySelectorAll('.check-item')
        .forEach(cb => cb.checked = false);

    document.querySelector(
        `.check-item[value="${id}"]`
    ).checked = true;

    bulkDeleteForm.submit();

};

//
// ======================================
// SINGLE DELETE (BUTTON HOOK)
// ======================================
//

document.querySelectorAll('.js-delete-single')
    .forEach(btn => {

        btn.addEventListener('click', () => {

            deleteSingle(btn.dataset.id);

        });

    });

//
// ======================================
// AUTO SUBMIT FILTER
// ======================================
//

document.querySelectorAll('.auto-submit-filter')
    .forEach(filter => {

        filter.addEventListener('change', () => {

            document.getElementById(
                'filterForm'
            )?.submit();

        });

    });

//
// ======================================
// AUTO SUBMIT SEARCH
// ======================================
//

const searchInput = document.querySelector('.search-input');

const DEBOUNCE_DELAY = 350;

if (searchInput) {

    let debounceTimer;

    let previousValue = searchInput.value;

    searchInput.addEventListener('input', () => {

        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {

            const currentValue =
                searchInput.value.trim();

            if (currentValue === previousValue) return;

            previousValue = currentValue;

            document.getElementById(
                'filterForm'
            )?.submit();

        }, DEBOUNCE_DELAY);

    });

}

//
// ======================================
// PROFILE PAGE
// ======================================
//

document.addEventListener('DOMContentLoaded', () => {

    function openModal(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.add('show');
        document.body.style.setProperty('overflow-y', 'scroll');
        document.body.style.setProperty('touch-action', 'none');
        if (window.feather) feather.replace();
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.remove('show');
        document.body.style.removeProperty('overflow-y');
        document.body.style.removeProperty('touch-action');
    }

    document.getElementById('openProfileModal')
        ?.addEventListener('click', () => openModal('profileModal'));

    document.getElementById('openUniversityModal')
        ?.addEventListener('click', () => openModal('universityModal'));

    document.getElementById('openPhotoModal')
        ?.addEventListener('click', () => openModal('photoModal'));

    document.getElementById('viewPhotoTrigger')
        ?.addEventListener('click', () => openModal('viewPhotoModal'));

    // Trigger transisi dari modal Lihat Foto LANGSUNG ke Pilih File
    document.getElementById('btnSwitchToUploadModal')?.addEventListener('click', () => {
        // Langsung "klik" input file yang tersembunyi tanpa membuka modal upload dulu
        document.getElementById('photoInput')?.click();
    });

    document.querySelectorAll('.js-close-modal').forEach(btn => {
        btn.addEventListener('click', () => closeModal(btn.dataset.target));
    });

    document.querySelectorAll('button[type="submit"]').forEach(btn => {
        btn.addEventListener('mousedown', function() {
            this.classList.add('force-focus');
            setTimeout(() => this.classList.remove('force-focus'), 300);
        });
    });

    document.querySelectorAll('.custom-popup-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) closeModal(overlay.id);
        });
    });

    document.addEventListener('keydown', e => {
        if (e.key !== 'Escape') return;
        document.querySelectorAll('.custom-popup-overlay.show')
            .forEach(el => closeModal(el.id));
    });

    // PHOTO DROP ZONE
    const photoInput     = document.getElementById('photoInput');
    const photoDropZone  = document.getElementById('photoDropZone');
    const photoPreview   = document.getElementById('photoPreviewImg');
    const photoDropIcon  = document.getElementById('photoDropIcon');
    const photoFileName  = document.getElementById('photoFileName');
    const submitPhotoBtn = document.getElementById('submitPhotoBtn');

    function handlePhotoFile(file) {
        if (!file) return;
        const allowed = ['image/png', 'image/jpeg', 'image/jpg'];
        if (!allowed.includes(file.type)) {
            alert('Format tidak didukung. Gunakan PNG atau JPG.');
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2 MB.');
            return;
        }
        const reader = new FileReader();
        reader.onload = e => {
            photoPreview.src = e.target.result;
            photoPreview.style.display = 'block';
            photoDropIcon.style.display = 'none';
            photoFileName.textContent = file.name;
            photoFileName.style.display = 'block';
            if (submitPhotoBtn) submitPhotoBtn.disabled = false;

            // === BARIS TAMBAHAN BARU ===
            // Tutup modal lihat foto (jika sedang terbuka) dan langsung buka modal upload/preview
            closeModal('viewPhotoModal');
            openModal('photoModal');
            // ===========================
        };
        reader.readAsDataURL(file);
    }

    photoDropZone?.addEventListener('click', () => photoInput?.click());
    photoInput?.addEventListener('change', () => handlePhotoFile(photoInput.files[0]));

    photoDropZone?.addEventListener('dragover', e => {
        e.preventDefault();
        photoDropZone.classList.add('dragover');
    });
    photoDropZone?.addEventListener('dragleave', () => {
        photoDropZone.classList.remove('dragover');
    });
    photoDropZone?.addEventListener('drop', e => {
        e.preventDefault();
        photoDropZone.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        const dt = new DataTransfer();
        dt.items.add(file);
        photoInput.files = dt.files;
        handlePhotoFile(file);
    });

    document.getElementById('photoModal')?.addEventListener('transitionend', e => {
        if (e.target.id !== 'photoModal' || e.target.classList.contains('show')) return;
        if (photoPreview)   { photoPreview.src = '#'; photoPreview.style.display = 'none'; }
        if (photoDropIcon)    photoDropIcon.style.display = 'block';
        if (photoFileName)  { photoFileName.textContent = ''; photoFileName.style.display = 'none'; }
        if (submitPhotoBtn)   submitPhotoBtn.disabled = true;
        if (photoInput)       photoInput.value = '';
    });

    // RESIDENCE STATUS — LAINNYA
    const selectResidence = document.getElementById('inputResidence');
    const inputOther      = document.getElementById('inputResidenceOther');

    if (selectResidence) {
        const fixedOptions = ['Rumah Orang Tua', 'Kos', 'Asrama', 'Kontrakan', 'Lainnya', ''];
        const currentVal   = selectResidence.dataset.current ?? '';
        if (currentVal && !fixedOptions.includes(currentVal)) {
            selectResidence.value = 'Lainnya';
            inputOther.style.display = 'block';
            inputOther.value = currentVal;
        }
    }

    selectResidence?.addEventListener('change', () => {
        if (selectResidence.value === 'Lainnya') {
            inputOther.style.display = 'block';
            inputOther.required = true;
        } else {
            inputOther.style.display = 'none';
            inputOther.required = false;
            inputOther.value = '';
        }
    });

    // ACTIVITY DETAIL POPUP
    document.querySelectorAll('.js-open-activity').forEach(btn => {
        btn.addEventListener('click', function() {

            const stress = this.dataset.stress;
            let stressLabel = stress;
            if (stress === 'Rendah,Sedang,Tinggi') stressLabel = 'Rendah, Sedang, Tinggi';
            else if (stress === 'Rendah,Sedang') stressLabel = 'Rendah & Sedang';
            else if (stress === 'Sedang,Tinggi') stressLabel = 'Sedang & Tinggi';

            const status = this.dataset.status;

            document.getElementById('popupTitleDetail').textContent  = this.dataset.title;
            document.getElementById('popupType').textContent         = this.dataset.type;
            document.getElementById('popupDuration').textContent     = this.dataset.duration;
            document.getElementById('popupIntensity').textContent    = this.dataset.intensity;
            document.getElementById('popupStress').textContent       = stressLabel;
            document.getElementById('popupStatusText').textContent   = status;
            document.getElementById('popupDescription').textContent  = this.dataset.description;

            document.getElementById('popupInstruction').textContent =
                this.dataset.instruction
                    ? this.dataset.instruction
                    : 'Belum ada instruksi aktivitas yang ditambahkan.';

                        openModal('activityModal');
        });
    });

    // RULE BASED DETAIL POPUP
    document.querySelectorAll('.js-open-rule').forEach(btn => {
        btn.addEventListener('click', function () {
            const stress = this.dataset.stress;
            let badge = '';
            if (stress === 'Rendah') {
                badge = `
                    <span class="badge badge-soft-success rounded-pill px-3 py-1">
                        Rendah
                    </span>
                `;

            } else if (stress === 'Sedang') {
                badge = `
                    <span class="badge badge-soft-warning rounded-pill px-3 py-1">
                        Sedang
                    </span>
                `;

            } else {
                badge = `
                    <span class="badge badge-soft-danger rounded-pill px-3 py-1">
                        Tinggi
                    </span>
                `;
            }

            document.getElementById(
                'popupRuleStressBadge'
            ).innerHTML = badge;

            document.getElementById(
                'popupRuleActivity'
            ).textContent = this.dataset.activity;

            document.getElementById(
                'popupRuleType'
            ).textContent = this.dataset.type;

            document.getElementById(
                'popupRuleIntensity'
            ).textContent = this.dataset.intensity;

            document.getElementById(
                'popupRuleDescription'
            ).textContent = this.dataset.description;

            openModal('ruleBasedRuleModal');

        });
    });

});

//
// ======================================
// AUTO HIDE SUCCESS ALERT
// ======================================
//

document.addEventListener('DOMContentLoaded', () => {

    const alert =
        document.getElementById('successAlert');

    if (!alert) return;

    setTimeout(() => {

        alert.style.transition =
            'all 0.4s ease';

        alert.style.opacity =
            '0';

        alert.style.transform =
            'translateY(-10px)';

        setTimeout(() => {

            alert.remove();

        }, 400);

    }, 3000);

});

//
// ======================================
// RESET FILTER ON HARD RELOAD
// ======================================
//

window.addEventListener('load', () => {

    const navigationEntries =
        performance.getEntriesByType('navigation');

    if (!navigationEntries.length) return;

    const navigationType =
        navigationEntries[0].type;

    if (navigationType !== 'reload') return;

    const url = new URL(window.location.href);

    const currentPage =
        url.searchParams.get('page');

    const hasFilter =
        url.searchParams.has('stress_level') ||
        url.searchParams.has('date') ||
        url.searchParams.has('status') ||
        url.searchParams.has('intensity_level') ||
        url.searchParams.has('search') ||
        url.searchParams.has('per_page') ||
        url.searchParams.has('is_completed') ||
        url.searchParams.has('is_helpful');

    if (!hasFilter) return;

    url.searchParams.delete('stress_level');
    url.searchParams.delete('date');
    url.searchParams.delete('status');
    url.searchParams.delete('intensity_level');
    url.searchParams.delete('search');
    url.searchParams.delete('per_page');
    url.searchParams.delete('is_completed');
    url.searchParams.delete('is_helpful');

    if (currentPage) {
        url.searchParams.set('page', currentPage);
    }

    window.location.replace(url.toString());

});

//
// ======================================
// SHOW MORE / SHOW LESS RECOMMENDATIONS
// ======================================
//

const btnShowMore = document.getElementById('btnShowMore');

if (btnShowMore)
{
    let isExpanded = false; // Penanda status awal (sedang ditutup)

    btnShowMore.addEventListener('click', () => {
        // Cari semua elemen rekomendasi yang disembunyikan
        const hiddenItems = document.querySelectorAll('.hidden-recommendation');

        if (!isExpanded) {
            // JIKA SEDANG DITUTUP -> TAMPILKAN SEMUA
            hiddenItems.forEach(item => item.classList.remove('d-none'));

            // Ubah tombol jadi "Tampilkan lebih sedikit" dengan panah ke atas
            btnShowMore.innerHTML = `
                <span>Tampilkan lebih sedikit</span>
                <i data-feather="chevron-up"></i>
            `;
            isExpanded = true; // Update status

        } else {
            // JIKA SEDANG DIBUKA -> SEMBUNYIKAN KEMBALI
            hiddenItems.forEach(item => item.classList.add('d-none'));

            // Kembalikan tombol ke bentuk semula dengan panah ke bawah
            btnShowMore.innerHTML = `
                <span>Lihat rekomendasi lainnya</span>
                <i data-feather="chevron-down"></i>
            `;
            isExpanded = false; // Update status

            // Menggulir layar sedikit ke arah tombol agar transisinya mulus (layar tidak loncat)
            btnShowMore.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // Karena kita menyuntikkan icon baru via innerHTML, kita harus memanggil ulang feather
        if (window.feather) feather.replace();
    });
}

// ======================================
// MOBILE OVERLAY CLICK TO CLOSE SIDEBAR
// ======================================
document.addEventListener('click', function(e) {
    if (window.innerWidth <= 991.98) {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.querySelector('.js-sidebar-toggle');
        // Jika sidebar SEDANG TERBUKA (di mobile, class 'collapsed' berarti terbuka)
        if (sidebar && sidebar.classList.contains('collapsed')) {
            // Jika area yang diklik BUKAN sidebar dan BUKAN tombol hamburger
            if (!sidebar.contains(e.target) && (!toggleBtn || !toggleBtn.contains(e.target))) {
                e.preventDefault(); // Cegah klik tembus ke elemen di bawahnya
                if (toggleBtn) toggleBtn.click(); // Tutup sidebar
            }
        }
    }
});

//
// ======================================
// FOCUS MODE TIMER (WITH SESSION STORAGE)
// ======================================
//
document.addEventListener("DOMContentLoaded", function() {
    const display = document.getElementById('timerDisplay');
    const timerCircle = document.getElementById('timerCircle');

    if (display) {
        let durationTextElement = document.getElementById('durationText');
        let durationText = durationTextElement ? durationTextElement.innerText : '5';

        // Ambil angka dari teks (Misal: "10-15 Menit" -> ambil 15)
        let matches = durationText.match(/\d+/g);
        let defaultMinutes = 5;

        if (matches && matches.length > 0) {
            defaultMinutes = parseInt(matches[matches.length - 1]);
        }

        let totalSeconds = defaultMinutes * 60;

        // KUNCI PENYIMPANAN UNIK (berdasarkan URL agar tidak bentrok dengan aktivitas lain)
        const timeKey = 'tenangin_time_' + window.location.pathname;
        const runKey = 'tenangin_run_' + window.location.pathname;

        // CEK MEMORI: Ambil sisa waktu dari sessionStorage jika ada, jika tidak gunakan totalSeconds
        let currentSeconds = sessionStorage.getItem(timeKey) ? parseInt(sessionStorage.getItem(timeKey)) : totalSeconds;
        let timerInterval = null;
        let isRunning = false;
        const circumference = 565.48;

        const btnStart = document.getElementById('btnStart');
        const btnPause = document.getElementById('btnPause');
        const btnReset = document.getElementById('btnReset');

        function updateDisplay() {
            let m = Math.floor(currentSeconds / 60).toString().padStart(2, '0');
            let s = (currentSeconds % 60).toString().padStart(2, '0');
            display.innerText = `${m}:${s}`;

            if (timerCircle) {
                let percentage = currentSeconds / totalSeconds;
                let offset = circumference - (percentage * circumference);
                timerCircle.style.strokeDashoffset = offset;
            }

            // SIMPAN SISA WAKTU KE MEMORI BROWSER
            sessionStorage.setItem(timeKey, currentSeconds);
        }

        function startTimer() {
            if (!isRunning && currentSeconds > 0) {
                isRunning = true;
                sessionStorage.setItem(runKey, 'true'); // Simpan status berjalan

                btnStart.classList.add('d-none');
                btnStart.classList.remove('d-flex');

                btnPause.classList.remove('d-none');
                btnPause.classList.add('d-flex');

                btnReset.classList.remove('d-none');
                btnReset.classList.add('d-flex');

                timerInterval = setInterval(() => {
                    currentSeconds--;
                    updateDisplay();

                    if (currentSeconds <= 0) {
                        clearInterval(timerInterval);
                        isRunning = false;

                        // BERSIHKAN MEMORI KETIKA WAKTU HABIS
                        sessionStorage.removeItem(timeKey);
                        sessionStorage.removeItem(runKey);

                        display.classList.remove('text-success');
                        display.classList.add('text-danger');
                        if(timerCircle) timerCircle.style.stroke = '#DC2626';

                        btnPause.classList.add('d-none');
                        btnPause.classList.remove('d-flex');
                    }
                }, 1000);
            }
        }

        function pauseTimer() {
            clearInterval(timerInterval);
            isRunning = false;
            sessionStorage.setItem(runKey, 'false'); // Simpan status jeda

            btnPause.classList.add('d-none');
            btnPause.classList.remove('d-flex');

            btnStart.classList.remove('d-none');
            btnStart.classList.add('d-flex');
            btnStart.innerHTML = '<i data-feather="play" style="width: 18px; height: 18px;" class="me-2"></i> Lanjutkan';

            if (typeof feather !== 'undefined') feather.replace();
        }

        function resetTimer() {
            clearInterval(timerInterval);
            isRunning = false;
            currentSeconds = totalSeconds;

            // BERSIHKAN MEMORI
            sessionStorage.removeItem(timeKey);
            sessionStorage.removeItem(runKey);

            display.classList.remove('text-danger');
            display.classList.add('text-success');

            if(timerCircle) {
                timerCircle.style.stroke = '#86EFAC';
                timerCircle.style.strokeDashoffset = 0;
            }

            updateDisplay();

            btnPause.classList.add('d-none');
            btnPause.classList.remove('d-flex');

            btnReset.classList.add('d-none');
            btnReset.classList.remove('d-flex');

            btnStart.classList.remove('d-none');
            btnStart.classList.add('d-flex');
            btnStart.innerHTML = '<i data-feather="play" style="width: 18px; height: 18px;" class="me-2"></i> Mulai';

            if (typeof feather !== 'undefined') feather.replace();
        }

        if (btnStart) btnStart.addEventListener('click', startTimer);
        if (btnPause) btnPause.addEventListener('click', pauseTimer);
        if (btnReset) btnReset.addEventListener('click', resetTimer);

        // ==========================================
        // AUTO-RESUME LOGIC (JIKA HALAMAN DI-RELOAD)
        // ==========================================
        updateDisplay(); // Panggil tampilan awal

        // Cek apakah sebelum reload timer sedang berjalan?
        if (sessionStorage.getItem(runKey) === 'true' && currentSeconds > 0) {
            // Langsung otomatis jalankan lagi tanpa perlu user klik
            startTimer();
        } else if (currentSeconds < totalSeconds && currentSeconds > 0) {
            // Jika sebelum reload timer sedang di-jeda (paused)
            btnReset.classList.remove('d-none');
            btnReset.classList.add('d-flex');
            btnStart.innerHTML = '<i data-feather="play" style="width: 18px; height: 18px;" class="me-2"></i> Lanjutkan';
            if (typeof feather !== 'undefined') feather.replace();
        }

        // ==========================================
        // HAPUS MEMORI JIKA PINDAH HALAMAN (KEMBALI / SELESAI)
        // ==========================================
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                let href = this.getAttribute('href');
                // Pastikan yang diklik adalah link pindah halaman sungguhan
                // Bukan link untuk modal popup ('#') atau aksi javascript
                if (href && href !== '#' && !href.startsWith('javascript:')) {
                    sessionStorage.removeItem(timeKey);
                    sessionStorage.removeItem(runKey);
                }
            });
        });
    }
});

//
// ======================================
// EVALUATION FORM TOGGLE (FEEDBACK)
// ======================================
//
document.addEventListener("DOMContentLoaded", function() {
    const evaluationSection = document.getElementById('evaluationQuestions');
    const completedYes = document.getElementById('completed_yes');
    const completedNo = document.getElementById('completed_no');

    // Pastikan script hanya berjalan JIKA elemen kuesioner evaluasi ada di halaman
    if (evaluationSection && completedYes && completedNo) {

        function toggleEvaluation() {
            if (completedNo.checked) {
                evaluationSection.style.display = 'none';

                // Reset semua radio button di dalam kuesioner jika user memilih "Tidak Selesai"
                const radios = evaluationSection.querySelectorAll('input[type="radio"]');
                radios.forEach(radio => radio.checked = false);
            } else {
                evaluationSection.style.display = 'block';
            }
        }

        completedYes.addEventListener('change', toggleEvaluation);
        completedNo.addEventListener('change', toggleEvaluation);
    }
});

//
// ======================================
// FEEDBACK CREATE FORM (EVALUATION & STARS)
// ======================================
//
document.addEventListener("DOMContentLoaded", function() {
    const formFeedback = document.getElementById('formFeedback');

    if (formFeedback) {
        // 1. LOGIKA BATAL PILIH (TOGGLE RESET)
        formFeedback.querySelectorAll('.feedback-radio').forEach(radio => {
            radio.addEventListener('click', function() {
                if (this.wasChecked) {
                    this.checked = false;
                    this.wasChecked = false;
                    this.dispatchEvent(new Event('change'));
                } else {
                    document.querySelectorAll(`input[name="${this.name}"]`).forEach(el => {
                        el.wasChecked = false;
                    });
                    this.wasChecked = true;
                }
            });
        });

        // 2. LOGIKA RATING BINTANG (STAR RATING KHUSUS)
        setTimeout(() => {
            const starLabels = document.querySelectorAll('.star-label');
            const starRadios = document.querySelectorAll('.star-radio');

            function updateStars(value) {
                starLabels.forEach(label => {
                    const starSvg = label.querySelector('svg');
                    if (starSvg) {
                        if (parseInt(label.dataset.value) <= value) {
                            starSvg.style.color = '#F59E0B'; // Garis tepi Emas
                            starSvg.style.fill = '#F59E0B';  // Isi Emas
                            starSvg.style.transform = 'scale(1.1)';
                        } else {
                            starSvg.style.color = '#cbd5e1'; // Abu-abu
                            starSvg.style.fill = 'none';     // Kosong
                            starSvg.style.transform = 'scale(1)';
                        }
                    }
                });
            }

            starLabels.forEach(label => {
                label.addEventListener('mouseover', function() {
                    updateStars(this.dataset.value);
                });

                label.addEventListener('mouseout', function() {
                    const checkedRadio = document.querySelector('.star-radio:checked');
                    updateStars(checkedRadio ? checkedRadio.value : 0);
                });
            });

            starRadios.forEach(radio => {
                radio.addEventListener('click', function() {
                    const clickedValue = parseInt(this.value);

                    if (this.wasStarChecked) {
                        this.checked = false;
                        this.wasStarChecked = false;

                        const newValue = clickedValue - 1;

                        if (newValue > 0) {
                            const prevRadio = document.getElementById('star_' + newValue);
                            if (prevRadio) {
                                prevRadio.checked = true;
                                prevRadio.wasStarChecked = true;
                            }
                            updateStars(newValue);
                        } else {
                            updateStars(0);
                        }
                    } else {
                        starRadios.forEach(r => r.wasStarChecked = false);
                        this.wasStarChecked = true;
                        updateStars(clickedValue);
                    }
                });
            });
        }, 100);
    }
});

//
// ======================================
// TOGGLE PASSWORD VISIBILITY
// ======================================
//
window.togglePassword = function(inputId, element) {
    const input = document.getElementById(inputId);
    if (!input) return;

    // Cek tipe input saat ini
    if (input.type === 'password') {
        input.type = 'text'; // Tampilkan password
        // PERBAIKAN: Gunakan class icon-18, HAPUS style="width: 18px;"
        element.innerHTML = '<i data-feather="eye-off" class="icon-18"></i>';
    } else {
        input.type = 'password'; // Sembunyikan password
        // PERBAIKAN: Gunakan class icon-18, HAPUS style="width: 18px;"
        element.innerHTML = '<i data-feather="eye" class="icon-18"></i>';
    }

    // Render ulang ikon feather
    if (window.feather) feather.replace();
};

//
// ======================================
// AUTO-OPEN PASSWORD MODAL (MAGIC SCRIPT)
// ======================================
//
document.addEventListener('DOMContentLoaded', () => {
    // Beri jeda 100ms agar DOM dan event listener lain selesai dimuat
    setTimeout(() => {
        const passwordModal = document.getElementById('passwordModal');
        if (!passwordModal) return;

        // Cek 1: Apakah ada parameter ?action=password di URL?
        const urlParams = new URLSearchParams(window.location.search);
        const hasPasswordAction = urlParams.get('action') === 'password';

        // Cek 2: Apakah ada peringatan error merah di dalam modal password? (Berarti gagal validasi backend)
        const hasPasswordError = passwordModal.querySelector('.alert-soft-danger') !== null;

        // Jika salah satu kondisi terpenuhi, otomatis buka modalnya!
        if (hasPasswordAction || hasPasswordError) {
            passwordModal.classList.add('show');
            document.body.style.setProperty('overflow-y', 'scroll');
            document.body.style.setProperty('touch-action', 'none');

            if (window.feather) feather.replace();

            // Jika dibuka karena parameter URL, bersihkan URL-nya agar tidak terus-terusan terbuka saat di-refresh
            if (hasPasswordAction && window.history.replaceState) {
                const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.replaceState({ path: cleanUrl }, '', cleanUrl);
            }
        }
    }, 100);
});
