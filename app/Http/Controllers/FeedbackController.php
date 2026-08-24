<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RecommendationItem;
use App\Models\Feedback;
use Barryvdh\DomPDF\Facade\Pdf;

class FeedbackController extends Controller
{
    // ======================================
    // 1. DAFTAR UMPAN BALIK (INDEX)
    // ======================================
    public function index(Request $request)
    {
        // Tambahkan relasi 'user' agar bisa menampilkan nama mahasiswa
        $query = Feedback::with(['user', 'recommendationItem' => function ($query) {
            $query->withTrashed()->with('activity');
        }]);

        // HANYA filter user_id jika bukan Admin
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        // ======================================
        // 1. FILTER PENCARIAN (SEARCH)
        // ======================================
        if (request('search')) {
            $search = (string) request('search');
            $searchLower = strtolower($search);

            $days = [
                'senin' => 'Monday',
                'selasa' => 'Tuesday',
                'rabu' => 'Wednesday',
                'kamis' => 'Thursday',
                'jumat' => 'Friday',
                'sabtu' => 'Saturday',
                'minggu' => 'Sunday',
            ];
            $englishDay = $days[$searchLower] ?? null;

            $query->where(function ($q) use ($search, $englishDay) {
                $q->whereHas('recommendationItem', function ($subQ) use ($search) {
                    $subQ->withTrashed()->whereHas('activity', function ($subQ2) use ($search) {
                        $subQ2->where('title', 'like', "%{$search}%")
                            ->orWhere('activity_type', 'like', "%{$search}%");
                    });
                })->orWhere('created_at', 'like', "%{$search}%");

                // Admin bisa mencari berdasarkan nama mahasiswa
                if (Auth::user()->role === 'admin') {
                    $q->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
                }

                if ($englishDay) {
                    $q->orWhereRaw('DAYNAME(created_at) = ?', [$englishDay]);
                }
            });

        }

        // ======================================
        // 2. FILTER TANGGAL (DATE)
        // ======================================
        if (request('date')) {
            $query->whereDate('created_at', request('date'));
        }

        // ======================================
        // 3. FILTER STATUS PENYELESAIAN
        // ======================================
        // PERBAIKAN: Ubah '' menjadi null
        if (request()->has('is_completed') && request('is_completed') !== null) {
            $query->where('is_completed', request('is_completed'));
        }

        // ======================================
        // 4. FILTER BERMANFAAT
        // ======================================
        // PERBAIKAN: Ubah '' menjadi null
        if (request()->has('is_helpful') && request('is_helpful') !== null) {
            $query->where('is_helpful', request('is_helpful'));
        }

        // ======================================
        // 5. PAGINATION
        // ======================================
        $perPage = request('per_page', 10);
        $feedbacks = $query->latest()->paginate($perPage)->withQueryString();

        return view('pages.feedbacks.feedback', compact('feedbacks'));
    }

    // ======================================
    // 2. HALAMAN PELAKSANAAN (MODE FOKUS)
    // ======================================
    public function focus(RecommendationItem $recommendationItem)
    {
        // Panggil relasi parent (recommendation) untuk cek kepemilikan data
        $recommendationItem->load(['recommendation', 'activity']);

        // Pastikan keamanan: hanya pemilik riwayat yang boleh mengakses halamannya
        if ($recommendationItem->recommendation->user_id !== Auth::id()) {
            abort(403);
        }

        if (is_null($recommendationItem->started_at)) {
            $recommendationItem->update([
                'started_at' => now(),
            ]);
        }

        // Cek apakah aktivitas ini sudah pernah diberi feedback sebelumnya
        $existingFeedback = Feedback::where('recommendation_item_id', $recommendationItem->id)
            ->where('user_id', Auth::id())
            ->first();

        // Jika sudah pernah memberi feedback, kembalikan ke riwayat (mencegah pengerjaan ulang yang tidak perlu)
        if ($existingFeedback) {
            return redirect()
                ->route('recommendations.history')
                ->with('error', 'Anda sudah memberikan umpan balik untuk aktivitas ini.');
        }

        return view('pages.feedbacks.feedbackfocus', compact('recommendationItem'));
    }

    // ======================================
    // 3. HALAMAN FORM EVALUASI (CREATE FEEDBACK)
    // ======================================
    public function create(RecommendationItem $recommendationItem)
    {
        $recommendationItem->load(['recommendation', 'activity']);

        // Pastikan keamanan: hanya pemilik riwayat yang boleh mengakses
        if ($recommendationItem->recommendation->user_id !== Auth::id()) {
            abort(403);
        }

        // Cek apakah aktivitas ini sudah pernah diberi feedback sebelumnya
        $existingFeedback = Feedback::where('recommendation_item_id', $recommendationItem->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingFeedback) {
            return redirect()
                ->route('recommendations.history')
                ->with('error', 'Anda sudah memberikan umpan balik untuk aktivitas ini.');
        }

        // Arahkan ke file form feedback yang baru kita buat
        return view('pages.feedbacks.feedbackcreate', compact('recommendationItem'));
    }

    // ======================================
    // 4. SIMPAN UMPAN BALIK (STORE)
    // ======================================
    public function store(Request $request, RecommendationItem $recommendationItem)
    {
        // Pastikan keamanan: hanya pemilik riwayat yang boleh mengirim feedback
        $recommendationItem->load('recommendation');
        if ($recommendationItem->recommendation->user_id !== Auth::id()) {
            abort(403);
        }

        // Validasi data input dari form feedback
        $validated = $request->validate([
            'is_completed' => ['required', 'boolean'],
            'is_helpful' => ['nullable', 'boolean'],
            'calmness_score' => ['nullable', 'integer', 'min:1', 'max:5'],
            'comfort_score' => ['nullable', 'integer', 'min:1', 'max:5'],
            'stress_reduction_score' => ['nullable', 'integer', 'min:1', 'max:5'],
            'willingness_score' => ['nullable', 'integer', 'min:1', 'max:5'],
            'overall_rating' => 'required_if:is_completed,1|nullable|integer|min:1|max:5',
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        // Proteksi ganda: Cek kembali agar tidak ada duplikasi data feedback jika tombol di-klik 2 kali
        $existingFeedback = Feedback::where('recommendation_item_id', $recommendationItem->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingFeedback) {
            return redirect()
                ->route('recommendations.history');
        }

        // Simpan feedback ke database
        Feedback::create([
            'user_id' => Auth::id(),
            'recommendation_item_id' => $recommendationItem->id,
            'is_completed' => $validated['is_completed'],
            'is_helpful' => $validated['is_helpful'] ?? null,
            'calmness_score' => $validated['calmness_score'] ?? null,
            'comfort_score' => $validated['comfort_score'] ?? null,
            'stress_reduction_score' => $validated['stress_reduction_score'] ?? null,
            'willingness_score' => $validated['willingness_score'] ?? null,
            'overall_rating' => $validated['overall_rating'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Arahkan kembali ke halaman Riwayat Rekomendasi dengan pesan sukses
        return redirect()
            ->route('recommendations.history')
            ->with('success', 'Terima kasih! Umpan balik Anda akan membantu kami menyusun rekomendasi yang lebih baik.');
    }

    // ======================================
    // 5. DETAIL FEEDBACK (SHOW)
    // ======================================
    public function show(Feedback $feedback)
    {
        // Izinkan jika pemilik data OR jika Admin
        if ($feedback->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $feedback->load(['user', 'recommendationItem' => function ($query) {
            $query->withTrashed()->with(['activity', 'recommendation' => function ($q) {
                $q->withTrashed()->with('pssAssessment');
            }]);
        }]);

        return view('pages.feedbacks.feedbackshow', compact('feedback'));
    }

    // ======================================
    // 6. BULK DELETE UMPAN BALIK
    // ======================================
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:feedbacks,id',
        ]);

        // 1. Mulai query berdasarkan ID yang dikirim
        $query = Feedback::whereIn('id', $request->ids);

        // 2. Terapkan filter kepemilikan HANYA jika yang login bukan Admin
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $feedbacks = $query->get();

        if ($feedbacks->isEmpty()) {
            return back()->with('error', 'Tidak ada data yang valid untuk dihapus.');
        }

        // 3. Eksekusi delete pada query yang sudah difilter
        $deletedCount = $query->delete();

        return redirect()->route('feedbacks.index')
            ->with('success', $deletedCount . ' data umpan balik berhasil dihapus.');
    }

    // ======================================
    // 7. HAPUS UMPAN BALIK (SINGLE)
    // ======================================
    public function destroy(Feedback $feedback)
    {
        // Tambahkan pengecekan role admin
        if ($feedback->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $feedback->delete();

        return redirect()->route('feedbacks.index')
            ->with('success', 'Data umpan balik berhasil dihapus.');
    }

    // ======================================
    // 8. EKSPOR EVALUASI FEEDBACK KE PDF
    // ======================================
    public function exportPdf(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $query = Feedback::with([
            'user',
            'recommendationItem' => function ($q) {
                $q->withTrashed()->with([
                    'activity',
                    'recommendation.pssAssessment'
                ]);
            }
        ]);

        // ======================================
        // 1. FILTER PENCARIAN (SEARCH)
        // ======================================
        if ($request->filled('search')) {
            $search = (string) $request->search;
            $searchLower = strtolower($search);

            $days = [
                'senin' => 'Monday',
                'selasa' => 'Tuesday',
                'rabu' => 'Wednesday',
                'kamis' => 'Thursday',
                'jumat' => 'Friday',
                'sabtu' => 'Saturday',
                'minggu' => 'Sunday',
            ];
            $englishDay = $days[$searchLower] ?? null;

            $query->where(function ($q) use ($search, $englishDay) {
                $q->whereHas('recommendationItem', function ($subQ) use ($search) {
                    $subQ->withTrashed()->whereHas('activity', function ($subQ2) use ($search) {
                        $subQ2->where('title', 'like', "%{$search}%")
                            ->orWhere('activity_type', 'like', "%{$search}%");
                    });
                })
                    ->orWhere('created_at', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($subQ) use ($search) {
                        $subQ->where('name', 'like', "%{$search}%");
                    });

                if ($englishDay) {
                    $q->orWhereRaw('DAYNAME(created_at) = ?', [$englishDay]);
                }
            });
        }

        // ======================================
        // 2. FILTER TANGGAL (DATE)
        // ======================================
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // ======================================
        // 3. FILTER STATUS PENYELESAIAN
        // ======================================
        if ($request->has('is_completed') && $request->is_completed !== null) {
            $query->where('is_completed', $request->is_completed);
        }

        // ======================================
        // 4. FILTER BERMANFAAT
        // ======================================
        if ($request->has('is_helpful') && $request->is_helpful !== null) {
            $query->where('is_helpful', $request->is_helpful);
        }

        $feedbacks = $query->latest()->get();

        // 1. Total Feedback
        $totalFeedback = $feedbacks->count();

        // 2. Total Aktivitas Selesai & Tidak Selesai
        $totalCompleted = $feedbacks->where('is_completed', true)->count();
        $totalUncompleted = $feedbacks->where('is_completed', false)->count();

        // 3. Rata-rata Penilaian Manfaat (overall_rating)
        $averageBenefit = $feedbacks->whereNotNull('overall_rating')->avg('overall_rating') ?? 0;

        // 4. Rata-rata Tingkat Ketenangan (calmness_score)
        $averageCalmnessAfter = $feedbacks->whereNotNull('calmness_score')->avg('calmness_score') ?? 0;

        // 5. Distribusi Penilaian Manfaat (1-5 Bintang)
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = $feedbacks->where('overall_rating', $i)->count();
            $percentage = $totalFeedback > 0 ? ($count / $totalFeedback) * 100 : 0;
            $distribution[$i] = [
                'count' => $count,
                'percentage' => number_format($percentage, 1),
            ];
        }

        // 6. Aktivitas Terpopuler (Hanya dari yang diselesaikan/is_completed = true)
        $activityCounts = [];
        foreach ($feedbacks->where('is_completed', true) as $fb) {
            $actTitle = $fb->recommendationItem->activity->title ?? null;
            if ($actTitle) {
                $activityCounts[$actTitle] = ($activityCounts[$actTitle] ?? 0) + 1;
            }
        }
        arsort($activityCounts);
        $mostPopularActivity = key($activityCounts) ?? 'Tidak Ada Data';
        $mostPopularCount = current($activityCounts) ?: 0;

        // 7. Aktivitas dengan Rata-rata Rating Tertinggi
        $activityRatings = [];
        foreach ($feedbacks as $fb) {
            $actTitle = $fb->recommendationItem->activity->title ?? null;
            $rating = $fb->overall_rating;
            if ($actTitle && !is_null($rating)) {
                if (!isset($activityRatings[$actTitle])) {
                    $activityRatings[$actTitle] = ['sum' => 0, 'count' => 0];
                }
                $activityRatings[$actTitle]['sum'] += $rating;
                $activityRatings[$actTitle]['count'] += 1;
            }
        }
        $highestRatedActivity = 'Tidak Ada Data';
        $highestAverage = 0;
        foreach ($activityRatings as $actTitle => $data) {
            $avg = $data['sum'] / $data['count'];
            if ($avg > $highestAverage) {
                $highestAverage = $avg;
                $highestRatedActivity = $actTitle;
            }
        }

        $summary = [
            'total_feedback' => $totalFeedback,
            'total_completed' => $totalCompleted,
            'total_uncompleted' => $totalUncompleted,
            'avg_benefit' => number_format($averageBenefit, 1),
            'avg_calmness_after' => number_format($averageCalmnessAfter, 1),
            'distribution' => $distribution,
            'popular_activity' => $mostPopularActivity !== 'Tidak Ada Data' ? $mostPopularActivity . ' (' . $mostPopularCount . ' kali)' : 'Tidak Ada Data',
            'highest_rated_activity' => $highestRatedActivity !== 'Tidak Ada Data' ? $highestRatedActivity . ' (' . number_format($highestAverage, 1) . ' / 5)' : 'Tidak Ada Data',
        ];

        $filters = [
            'is_completed' => $request->is_completed,
            'is_helpful' => $request->is_helpful,
            'date' => $request->date,
            'search' => $request->search,
        ];

        $pdf = Pdf::loadView('pages.feedbacks.feedbackpdf', compact('feedbacks', 'summary', 'filters'));
        $pdf->setPaper('a4', 'portrait');

        $filename = 'Laporan_Evaluasi_Aktivitas_Tenangin_' . now()->format('d-m-Y') . '.pdf';
        return $pdf->download($filename);
    }
}
