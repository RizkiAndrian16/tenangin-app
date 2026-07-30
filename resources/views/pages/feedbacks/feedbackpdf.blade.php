<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Evaluasi Feedback Mahasiswa</title>
    <style>
        {!! file_get_contents(public_path('assets-admin/css/feedback-pdf.css')) !!}
    </style>
</head>

<body>
    <div class="report-header">
        <h1>TENANGIN</h1>
        <h2>LAPORAN EVALUASI UMPAN BALIK (FEEDBACK) MAHASISWA</h2>
        <p>Analisis Hasil dan Efektivitas Aktivitas Relaksasi Rekomendasi</p>
    </div>

    <hr class="header-line">

    <table class="report-info">
        <tr>
            <td class="label">Tanggal Cetak</td>
            <td class="separator">:</td>
            <td>{{ now()->translatedFormat('d F Y, H:i') }}</td>
        </tr>
        <tr>
            <td class="label">Status Penyelesaian</td>
            <td class="separator">:</td>
            <td>
                @if (is_null($filters['is_completed']))
                    Semua Status
                @else
                    {{ $filters['is_completed'] == 1 ? 'Selesai' : 'Tidak Selesai' }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Penilaian Manfaat</td>
            <td class="separator">:</td>
            <td>
                @if (is_null($filters['is_helpful']))
                    Semua Penilaian
                @else
                    {{ $filters['is_helpful'] == 1 ? 'Bermanfaat (Ya)' : 'Tidak Bermanfaat (Tidak)' }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Tanggal Feedback</td>
            <td class="separator">:</td>
            <td>
                @if (!empty($filters['date']))
                    {{ \Carbon\Carbon::parse($filters['date'])->translatedFormat('d F Y') }}
                @else
                    Semua Tanggal
                @endif
            </td>
        </tr>
        @if (!empty($filters['search']))
            <tr>
                <td class="label">Kata Kunci Pencarian</td>
                <td class="separator">:</td>
                <td>"{{ $filters['search'] }}"</td>
            </tr>
        @endif
    </table>

    <div class="section-title">
        Ringkasan Statistik Evaluasi
    </div>

    <table class="summary-table">
        <tr>
            <td width="25%">
                <div class="summary-box">
                    <div class="summary-number">{{ $summary['total_feedback'] }}</div>
                    <div class="summary-label">Total Feedback</div>
                </div>
            </td>
            <td width="25%">
                <div class="summary-box">
                    <div class="summary-number">{{ $summary['total_completed'] }}</div>
                    <div class="summary-label">Aktivitas Selesai</div>
                </div>
            </td>
            <td width="25%">
                <div class="summary-box">
                    <div class="summary-number">{{ $summary['avg_benefit'] }} / 5</div>
                    <div class="summary-label">Rata-rata Penilaian Manfaat</div>
                </div>
            </td>
            <td width="25%">
                <div class="summary-box">
                    <div class="summary-number">{{ $summary['avg_calmness_after'] }} / 5</div>
                    <div class="summary-label">Rata-rata Tingkat Ketenangan</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">
        Ringkasan Aktivitas Relaksasi
    </div>

    <table class="popularity-table">
        <tr>
            <td width="50%">
                <div class="popularity-box">
                    <div class="popularity-title">Aktivitas Terpopuler</div>
                    <div class="popularity-value">{{ $summary['popular_activity'] }}</div>
                </div>
            </td>
            <td width="50%">
                <div class="popularity-box">
                    <div class="popularity-title">Aktivitas dengan Rating Tertinggi</div>
                    <div class="popularity-value">{{ $summary['highest_rated_activity'] }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">
        Distribusi Penilaian Manfaat
    </div>

    <table class="distribution-table">
        <thead>
            <tr>
                <th width="34%">Penilaian</th>
                <th width="33%">Jumlah Evaluasi</th>
                <th width="33%">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 5; $i >= 1; $i--)
                @php
                    $dist = $summary['distribution'][$i];
                @endphp
                <tr>
                    <td class="text-center font-bold">
                        <span class="rating-stars">
                            @for ($s = 1; $s <= 5; $s++)
                                {{ $s <= $i ? '★' : '☆' }}
                            @endfor
                        </span>
                        ({{ $i }} Bintang)
                    </td>
                    <td class="text-center">{{ $dist['count'] }} Feedback</td>
                    <td class="text-center">{{ $dist['percentage'] }}%</td>
                </tr>
            @endfor
        </tbody>
    </table>

    <div class="section-title">
        Data Evaluasi Feedback Mahasiswa
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="15%">Nama Mahasiswa</th>
                <th width="18%">Aktivitas</th>
                <th width="8%">Skor PSS-10</th>
                <th width="12%">Tingkat Stres</th>
                <th width="9%">Penilaian Manfaat</th>
                <th width="9%">Tingkat Ketenangan</th>
                <th width="16%">Catatan</th>
                <th width="9%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($feedbacks as $feedback)
                @php
                    $recItem = $feedback->recommendationItem;
                    $activity = $recItem->activity ?? null;
                    $pssAssessment = $recItem->recommendation->pssAssessment ?? null;
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="student-name">{{ $feedback->user->name ?? 'Tidak Diketahui' }}</td>
                    <td>{{ $activity->title ?? 'Aktivitas Dihapus' }}</td>
                    <td class="text-center font-bold">
                        {{ $pssAssessment ? $pssAssessment->total_score : '-' }} / 40
                    </td>
                    <td class="text-center">
                        {{ $pssAssessment ? $pssAssessment->stress_level : '-' }}
                    </td>
                    <td class="text-center font-bold">
                        @if (!is_null($feedback->overall_rating))
                            {{ $feedback->overall_rating }} / 5
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center font-bold">
                        @if (!is_null($feedback->calmness_score))
                            {{ $feedback->calmness_score }} / 5
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $feedback->notes ?? '-' }}</td>
                    <td class="text-center">
                        {{ $feedback->created_at->format('d-m-Y') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="empty-data">
                        Tidak ada data evaluasi feedback mahasiswa yang tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="report-footer">
        <table class="report-footer-table">
            <tr>
                <td>Laporan dibuat melalui Sistem Tenangin.</td>
                <td class="footer-right">
                    Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }}
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
