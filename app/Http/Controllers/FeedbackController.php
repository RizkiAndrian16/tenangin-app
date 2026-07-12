<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RecommendationItem;
use App\Models\Feedback;

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
}
