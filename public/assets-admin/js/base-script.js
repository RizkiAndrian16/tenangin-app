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
