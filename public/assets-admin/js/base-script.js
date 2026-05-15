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
// PROFILE PAGE — profile.js
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

    document.querySelectorAll('.js-close-modal').forEach(btn => {
        btn.addEventListener('click', () => closeModal(btn.dataset.target));
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

    function showToast(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `toast-item ${type}`;
        const icon = type === 'success' ? 'check-circle' : 'alert-circle';
        toast.innerHTML = `
            <i data-feather="${icon}" style="width:16px;height:16px;flex-shrink:0;"></i>
            <span>${message}</span>
        `;
        container.appendChild(toast);
        if (window.feather) feather.replace();

        setTimeout(() => {
            toast.style.transition = 'opacity 0.4s ease';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 400);
        }, 3500);
    }

    window.showToast = showToast;

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
            showToast('Format tidak didukung. Gunakan PNG atau JPG.', 'error');
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            showToast('Ukuran file maksimal 2 MB.', 'error');
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

    async function handleFormSubmit(form, onSuccess) {
        const btn = form.querySelector('[type="submit"]');
        const originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...`;

        try {
            const res  = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });
            const json = await res.json();

            if (res.ok && json.success) {
                showToast(json.message ?? 'Data berhasil disimpan!', 'success');
                onSuccess(json.data ?? {});
                const overlay = form.closest('.custom-popup-overlay');
                if (overlay) closeModal(overlay.id);
            } else {
                showToast(json.message ?? 'Terjadi kesalahan.', 'error');
            }
        } catch {
            showToast('Koneksi gagal. Periksa jaringan Anda.', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
            if (window.feather) feather.replace();
        }
    }

    document.getElementById('profileForm')?.addEventListener('submit', e => {
        e.preventDefault();
        handleFormSubmit(e.target, data => {
            if (data.name)   {
                document.getElementById('displayName')?.replaceChildren(document.createTextNode(data.name));
                document.getElementById('heroName')?.replaceChildren(document.createTextNode(data.name));
            }
            if (data.gender)       setText('displayGender', data.gender);
            if (data.age)          setText('displayAge', data.age + ' tahun');
            if (data.phone_number) setText('displayPhone', data.phone_number);
        });
    });

    document.getElementById('universityForm')?.addEventListener('submit', e => {
        e.preventDefault();
        handleFormSubmit(e.target, data => {
            if (data.university)       setText('displayUniversity', data.university);
            if (data.major)            setText('displayMajor', data.major);
            if (data.semester)         setText('displaySemester', 'Semester ' + data.semester);
            if (data.residence_status) setText('displayResidence', data.residence_status);
        });
    });

    document.getElementById('photoForm')?.addEventListener('submit', e => {
        e.preventDefault();
        handleFormSubmit(e.target, data => {
            if (!data.profile_photo_url) return;
            const placeholder = document.getElementById('heroAvatarPlaceholder');
            const existing    = document.getElementById('heroAvatar');
            if (existing) {
                existing.src = data.profile_photo_url;
            } else if (placeholder) {
                const img = document.createElement('img');
                img.src = data.profile_photo_url;
                img.alt = 'Profile';
                img.className = 'profile-avatar';
                img.id = 'heroAvatar';
                placeholder.replaceWith(img);
            }
        });
    });

    function setText(id, value) {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    }

});
