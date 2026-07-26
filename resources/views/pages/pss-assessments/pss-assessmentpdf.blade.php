<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Laporan Riwayat PSS-10 Mahasiswa</title>

    <style>
        {!! file_get_contents(public_path('assets-admin/css/pss-pdf.css')) !!}
    </style>
</head>

<body>
    <div class="report-header">
        <h1>TENANGIN</h1>
        <h2>LAPORAN RIWAYAT TINGKAT STRES MAHASISWA</h2>
        <p>Berdasarkan PSS-10 (Perceived Stress Scale)</p>
    </div>

    <hr class="header-line">
    <table class="report-info">
        <tr>
            <td class="label">Tanggal Cetak</td>
            <td class="separator">:</td>
            <td>{{ now()->translatedFormat('d F Y, H:i') }}</td>
        </tr>

        <tr>
            <td class="label">Tingkat Stres</td>
            <td class="separator">:</td>
            <td>
                {{ !empty($filters['stress_level']) ? $filters['stress_level'] : 'Semua Tingkat Stres' }}
            </td>
        </tr>

        <tr>
            <td class="label">Tanggal Assessment</td>
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
                <td class="label">Pencarian</td>
                <td class="separator">:</td>
                <td>{{ $filters['search'] }}</td>
            </tr>
        @endif
    </table>

    <div class="section-title">
        Ringkasan Assessment
    </div>

    <table class="summary-table">
        <tr>
            <td width="25%">
                <div class="summary-box">
                    <div class="summary-number">
                        {{ $summary['total'] }}
                    </div>

                    <div class="summary-label">Total Assessment</div>
                </div>
            </td>

            <td width="25%">
                <div class="summary-box">
                    <div class="summary-number">
                        {{ $summary['rendah'] }}
                    </div>

                    <div class="summary-label">Stres Rendah</div>
                </div>
            </td>

            <td width="25%">
                <div class="summary-box">
                    <div class="summary-number">
                        {{ $summary['sedang'] }}
                    </div>

                    <div class="summary-label">Stres Sedang</div>
                </div>
            </td>

            <td width="25%">
                <div class="summary-box">
                    <div class="summary-number">
                        {{ $summary['tinggi'] }}
                    </div>

                    <div class="summary-label">Stres Tinggi</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">
        Data Riwayat PSS-10 Mahasiswa
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="28%">Nama Mahasiswa</th>
                <th width="25%">Tanggal Assessment</th>
                <th width="18%">Skor PSS-10</th>
                <th width="24%">Tingkat Stres</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($assessments as $assessment)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="student-name">{{ $assessment->user->name ?? 'Tidak Diketahui' }}</td>
                    <td class="text-center">{{ $assessment->created_at->translatedFormat('d F Y, H:i') }}</td>
                    <td class="text-center"><strong>{{ $assessment->total_score }}</strong> / 40</td>
                    <td class="text-center">{{ $assessment->stress_level }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="empty-data">
                        Tidak ada data PSS-10 Assessment yang tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="information-box">

        <div class="information-title">
            Keterangan Interpretasi Skor PSS-10
        </div>

        <p>Skor 0-13 : Tingkat stres rendah</p>
        <p>Skor 14-26 : Tingkat stres sedang</p>
        <p>Skor 27-40 : Tingkat stres tinggi</p>

        <p class="information-description">
            PSS-10 digunakan untuk mengukur persepsi individu terhadap stres
            berdasarkan pengalaman yang dirasakan dalam periode pengukuran.
        </p>
    </div>

    <div class="report-footer">
        <table class="report-footer-table">
            <tr>
                <td>Laporan dibuat melalui Sistem Tenangin.</td>
                <td class="footer-right">
                    Dicetak pada {{ now()->format('d-m-Y H:i') }}
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
