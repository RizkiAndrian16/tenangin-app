window.ChartJS4 = window.ChartJS4 || window.Chart;

document.addEventListener('DOMContentLoaded', function () {
    // 1. Terapkan warna tema global SEBELUM grafik digambar
    applyChartTheme();

    // 2. Gambar grafik (dengan animasi = true)
    initAdminDashboardCharts(true);
    initStudentDashboardChart(true);
});

// ======================================
// FUNGSI PENGATUR TEMA GLOBAL CHART.JS
// ======================================
function applyChartTheme() {
    if (!window.ChartJS4) return;

    const isDarkMode = localStorage.getItem('theme') === 'dark' || document.documentElement.classList.contains('dark-mode');

    // Warna TEKS (Angka di sumbu X dan Y)
    window.ChartJS4.defaults.color = isDarkMode ? '#CBD5E1' : '#64748B';

    // Warna GARIS (Garis tepi utama dan garis putus-putus)
    window.ChartJS4.defaults.borderColor = isDarkMode ? 'rgba(255, 255, 255, 0.2)' : '#E2E8F0';
}

// ======================================
// ADMIN DASHBOARD
// ======================================
// Tambahkan parameter "animate" dengan nilai bawaan true
function initAdminDashboardCharts(animate = true) {
    const newUserCanvas = document.getElementById('newUserChart');
    const assessmentCanvas = document.getElementById('assessmentChart');
    const feedbackCanvas = document.getElementById('feedbackChart');
    const dataEl = document.getElementById('dashboard-admin-data');

    if (!newUserCanvas || !assessmentCanvas || !feedbackCanvas || !dataEl || !window.ChartJS4) return;

    const data = JSON.parse(dataEl.textContent);

    const commonOptions = {
        animation: animate ? undefined : false, // <-- SAKLAR ANIMASI
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#ffffff', titleColor: '#212529', bodyColor: '#6c757d',
                borderColor: '#dee2e6', borderWidth: 1, padding: 10, usePointStyle: true
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                suggestedMax: 5,
                ticks: { precision: 0 },
                grid: { borderDash: [5, 5] }
            },
            x: {
                grid: { display: false }
            }
        }
    };

    new window.ChartJS4(newUserCanvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Pengguna Baru',
                data: data.users,
                borderColor: '#22c55e', backgroundColor: 'transparent', borderWidth: 2,
                pointBackgroundColor: '#22c55e', pointBorderColor: '#ffffff', pointBorderWidth: 2, pointRadius: 4, tension: 0.4
            }]
        },
        options: commonOptions
    });

    new window.ChartJS4(assessmentCanvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Assessment',
                data: data.assessments,
                borderColor: '#0ea5e9', backgroundColor: 'transparent', borderWidth: 2,
                pointBackgroundColor: '#0ea5e9', pointBorderColor: '#ffffff', pointBorderWidth: 2, pointRadius: 4, tension: 0.4
            }]
        },
        options: commonOptions
    });

    new window.ChartJS4(feedbackCanvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Feedback',
                data: data.feedbacks,
                borderColor: '#f59e0b', backgroundColor: 'transparent', borderWidth: 2,
                pointBackgroundColor: '#f59e0b', pointBorderColor: '#ffffff', pointBorderWidth: 2, pointRadius: 4, tension: 0.4
            }]
        },
        options: commonOptions
    });
}

// ======================================
// STUDENT DASHBOARD
// ======================================
function initStudentDashboardChart(animate = true) {
    const canvas = document.getElementById('pssTrendChart');
    const dataEl = document.getElementById('dashboard-student-data');

    if (!canvas || !dataEl || !window.ChartJS4) return;

    const data = JSON.parse(dataEl.textContent);
    const ctx = canvas.getContext('2d');

    // --- TAMBAHAN BARU: MAPPING WARNA DI FRONTEND ---
    // JavaScript yang menentukan warnanya berdasarkan teks yang dikirim Backend
    const generatedPointColors = data.stressLevels.map(level => {
        if (level === 'Rendah') return '#22c55e'; // Hijau Modern
        if (level === 'Sedang') return '#f59e0b'; // Oranye Modern
        return '#ef4444'; // Merah Modern (Tinggi)
    });
    // ------------------------------------------------

    new window.ChartJS4(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Total Skor',
                data: data.scores,
                borderColor: '#94A3B8',
                borderWidth: 2,
                backgroundColor: 'transparent',
                pointBackgroundColor: generatedPointColors, // <-- Gunakan warna yang baru di-generate di atas
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                tension: 0.4,
                clip: false // Mencegah marker terpotong di batas atas & bawah area grafik
            }]
        },
        options: {
            animation: animate ? undefined : false, // <-- SAKLAR ANIMASI
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: { left: 15, right: 15, top: 10, bottom: 10 } },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#ffffff', titleColor: '#212529', bodyColor: '#6c757d',
                    borderColor: '#dee2e6', borderWidth: 1, padding: 12, usePointStyle: true,
                    callbacks: {
                        label: function (context) { return ` Tingkat Stress: ${data.stressLevels[context.dataIndex]}`; },
                        afterLabel: function (context) { return ` Skor: ${context.parsed.y} / 40`; }
                    }
                }
            },
            scales: {
                y: {
                    min: 0,
                    max: 40,
                    grid: { borderDash: [5, 5] },
                    ticks: { stepSize: 5, precision: 0, autoSkip: false },
                    afterBuildTicks: function (axis) {
                        axis.ticks = [0, 5, 10, 15, 20, 25, 30, 35, 40].map(v => ({ value: v }));
                    }
                },
                x: {
                    offset: true,
                    grid: {
                        display: true,
                        borderDash: [5, 5]
                    }
                }
            }
        }
    });
}

// ======================================
// UPDATE GRAFIK SAAT TOMBOL DARK MODE DITEKAN
// ======================================
document.getElementById('darkModeToggle')?.addEventListener('click', function () {
    setTimeout(() => {

        // 1. Perbarui warna pengaturan global
        applyChartTheme();

        // 2. Hancurkan grafik lama
        if (window.ChartJS4 && window.ChartJS4.instances) {
            Object.values(window.ChartJS4.instances).forEach(chart => {
                chart.destroy();
            });
        }

        // 3. Gambar ulang TANPA ANIMASI (false) agar tidak bergerak dan tetap tajam!
        initAdminDashboardCharts(false);
        initStudentDashboardChart(false);

    }, 50);
});
