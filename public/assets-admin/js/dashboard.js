document.addEventListener('DOMContentLoaded', function () {
    initAdminDashboardCharts();
    initStudentDashboardChart();
});

// ======================================
// ADMIN DASHBOARD
// ======================================
function initAdminDashboardCharts() {
    const newUserCanvas = document.getElementById('newUserChart');
    const assessmentCanvas = document.getElementById('assessmentChart');
    const feedbackCanvas = document.getElementById('feedbackChart');
    const dataEl = document.getElementById('dashboard-admin-data');

    // Guard: hanya jalan jika seluruh canvas Admin tersedia (role Admin)
    if (!newUserCanvas || !assessmentCanvas || !feedbackCanvas || !dataEl || !window.ChartJS4) {
        return;
    }

    const data = JSON.parse(dataEl.textContent);
    const labels = data.labels;
    const usersData = data.users;
    const assessmentsData = data.assessments;
    const feedbacksData = data.feedbacks;

    // Konfigurasi Umum agar kodenya tidak berulang
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#ffffff',
                titleColor: '#212529',
                bodyColor: '#6c757d',
                borderColor: '#dee2e6',
                borderWidth: 1,
                padding: 10,
                usePointStyle: true
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                suggestedMax: 5, // Mencegah grafik loncat ekstrem saat data masih sedikit
                ticks: {
                    precision: 0
                },
                grid: {
                    color: '#f8f9fa',
                    borderDash: [5, 5],
                    drawBorder: false
                }
            },
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    font: {
                        size: 10
                    }
                }
            }
        }
    };

    // 1. Chart Pengguna Baru (Line Chart)
    new window.ChartJS4(newUserCanvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pengguna Baru',
                data: usersData,
                borderColor: '#22c55e',
                backgroundColor: 'transparent',
                borderWidth: 2,
                pointBackgroundColor: '#22c55e',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                tension: 0.4 // Membuat garis melengkung halus
            }]
        },
        options: commonOptions
    });

    // 2. Chart Assessment (Line Chart)
    new window.ChartJS4(assessmentCanvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Assessment',
                data: assessmentsData,
                borderColor: '#0ea5e9',
                backgroundColor: 'transparent',
                borderWidth: 2,
                pointBackgroundColor: '#0ea5e9',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                tension: 0.4
            }]
        },
        options: commonOptions
    });

    // 3. Chart Feedback (Line Chart)
    new window.ChartJS4(feedbackCanvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Feedback',
                data: feedbacksData,
                borderColor: '#f59e0b',
                backgroundColor: 'transparent',
                borderWidth: 2,
                pointBackgroundColor: '#f59e0b',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                tension: 0.4
            }]
        },
        options: commonOptions
    });
}

// ======================================
// STUDENT DASHBOARD
// ======================================
function initStudentDashboardChart() {
    const canvas = document.getElementById('pssTrendChart');
    const dataEl = document.getElementById('dashboard-student-data');

    // Guard: hanya jalan jika canvas Mahasiswa tersedia (role Mahasiswa)
    if (!canvas || !dataEl || !window.ChartJS4) {
        return;
    }

    const data = JSON.parse(dataEl.textContent);
    const labels = data.labels;
    const scores = data.scores;
    const pointColors = data.pointColors;
    const stressLevels = data.stressLevels;

    const ctx = canvas.getContext('2d');

    new window.ChartJS4(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Skor',
                data: scores,
                borderColor: '#dee2e6',
                borderWidth: 2,
                backgroundColor: 'transparent',
                pointBackgroundColor: pointColors,
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 15,
                    right: 15
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#ffffff',
                    titleColor: '#212529',
                    bodyColor: '#6c757d',
                    borderColor: '#dee2e6',
                    borderWidth: 1,
                    padding: 12,
                    usePointStyle: true,
                    callbacks: {
                        label: function (context) {
                            return ` Tingkat Stress: ${stressLevels[context.dataIndex]}`;
                        },
                        afterLabel: function (context) {
                            return ` Skor: ${context.parsed.y} / 40`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    min: 0,
                    max: 40,
                    grid: {
                        color: '#f8f9fa',
                        borderDash: [5, 5],
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 5,
                        precision: 0,
                        autoSkip: false
                    },
                    afterBuildTicks: function (axis) {
                        axis.ticks = [0, 5, 10, 15, 20, 25, 30, 35, 40].map(function (v) {
                            return {
                                value: v
                            };
                        });
                    }
                },
                x: {
                    offset: true,
                    grid: {
                        display: true,
                        color: '#f8f9fa',
                        borderDash: [5, 5],
                        drawBorder: false
                    }
                }
            }
        }
    });
}
