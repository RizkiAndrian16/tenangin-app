<?php

namespace App\Http\Controllers;

use App\Models\PssAssessment;
use App\Models\RuleBasedRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserPreference;
use App\Models\Recommendation;
use App\Models\RecommendationItem;
use App\Models\Feedback;

class RecommendationController extends Controller
{
    public function index(PssAssessment $pssAssessment)
    {
        if ($pssAssessment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $stressLevel = $pssAssessment->stress_level;

        $query = RuleBasedRule::with('activity')

            ->where('stress_level', $stressLevel)

            ->whereHas('activity', function ($query) {

                $query->whereIn('status', ['Direkomendasikan', 'Direkomendasikan terbatas']);
            });

        // ======================================
        // RULE BASED IF-THEN
        // ======================================

        // IF tingkat stres = tinggi
        // THEN rekomendasikan aktivitas intensitas ringan
        if ($stressLevel == 'Tinggi') {

            $query->whereHas('activity', function ($query) {

                $query->where('intensity_level', 'Ringan');
            });
        }

        // IF tingkat stres = sedang
        // THEN rekomendasikan aktivitas ringan hingga sedang
        elseif ($stressLevel == 'Sedang') {

            $query->whereHas('activity', function ($query) {

                $query->whereIn('intensity_level', ['Ringan', 'Sedang']);
            });
        }

        // IF tingkat stres = rendah
        // THEN rekomendasikan aktivitas dengan variasi lebih luas
        else {
        }

        $rules = $query
            ->oldest()
            ->get();

        // Ambil data preferensi terakhir dari user yang sedang login
        $lastPreference = \App\Models\UserPreference::where('user_id', Auth::id())
            ->latest('id')
            ->first();

        // Ekstrak nilai unik untuk dropdown opsi input
        $activityTypes = $rules->pluck('activity.activity_type')->unique();
        $durations     = $rules->pluck('activity.duration_category')->unique();
        $intensities   = $rules->pluck('activity.intensity_level')->unique();

        return view('pages.recommendations.recommendation', compact(
            'pssAssessment',
            'rules',
            'stressLevel',
            'lastPreference',
            'activityTypes',
            'durations',
            'intensities'
        ));
    }

    public function processPreferences(Request $request, PssAssessment $pssAssessment)
    {
        if ($pssAssessment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'preferred_activity_type' => ['required', 'string'],
            'preferred_duration' => ['required', 'string'],
            'preferred_intensity' => ['required', 'string'],
        ]);

        // Cukup buat data baru, SoftDeletes akan mengurus yang lama saat riwayat dihapus
        UserPreference::create([
            'user_id' => Auth::id(),
            'preferred_activity_type' => $validated['preferred_activity_type'],
            'preferred_duration' => $validated['preferred_duration'],
            'preferred_intensity' => $validated['preferred_intensity'],
        ]);

        return redirect()
            ->route('recommendations.final', $pssAssessment->id)
            ->with('success', 'Preferensi aktivitas berhasil disimpan.');
    }

    public function generateFinalRecommendation(PssAssessment $pssAssessment)
    {
        if ($pssAssessment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $stressLevel = $pssAssessment->stress_level;

        // Ambil data tanpa filter is_active
        $activePreference = UserPreference::where('user_id', Auth::id())
            ->latest('id')
            ->first();

        if (!$activePreference) {
            return redirect()
                ->route('recommendations.index', $pssAssessment->id)
                ->with('error', 'Preferensi aktivitas belum dipilih.');
        }

        // ======================================
        // RULE BASED CANDIDATE ACTIVITIES
        // ======================================

        $query = RuleBasedRule::with('activity')

            ->where('stress_level', $stressLevel)

            ->whereHas('activity', function ($query) {

                $query->whereIn('status', ['Direkomendasikan', 'Direkomendasikan terbatas']);
            });

        // stres tinggi
        if ($stressLevel == 'Tinggi') {

            $query->whereHas('activity', function ($query) {

                $query->where('intensity_level', 'Ringan');
            });
        }

        // stres sedang
        elseif ($stressLevel == 'Sedang') {

            $query->whereHas('activity', function ($query) {

                $query->whereIn('intensity_level', ['Ringan', 'Sedang']);
            });
        }

        $rules = $query
            ->oldest()
            ->get();

        // ======================================
        // CONTENT BASED FILTERING
        // ======================================

        $recommendations = collect();

        foreach ($rules as $rule) {
            $activity = $rule->activity;

            $score = 0;

            if ($activity->activity_type == $activePreference->preferred_activity_type) {
                $score += 3;
            }

            if ($activity->duration_category == $activePreference->preferred_duration) {
                $score += 2;
            }

            if ($activity->intensity_level == $activePreference->preferred_intensity) {
                $score += 2;
            }

            // ======================================
            // NORMALISASI SIMILARITY SCORE
            // TOTAL BOBOT = 7
            // ======================================

            $similarityScore = $score / 7;

            // ======================================
            // THE MAGIC FEEDBACK LOOP (REWARD/PENALTY)
            // ======================================
            $finalSortingScore = $similarityScore;

            $pastFeedback = Feedback::where('user_id', Auth::id())
                ->whereHas('recommendationItem', function ($q) use ($activity) {
                    $q->withTrashed()->where('activity_id', $activity->id);
                })
                ->latest()
                ->first();

            if ($pastFeedback) {
                if ($pastFeedback->willingness_score == 1 || $pastFeedback->willingness_score == 2) {
                    $finalSortingScore -= 1.0;
                } elseif ($pastFeedback->is_completed == 1 && $pastFeedback->is_helpful == 1) {
                    $finalSortingScore += 1.0;
                }
            }

            $recommendations->push([
                'activity' => $activity,
                'similarity_score' => $similarityScore,
                'matching_score' => $score,
                'final_sorting_score' => $finalSortingScore,
            ]);
        }

        $finalRecommendations = $recommendations
            ->sortByDesc('final_sorting_score')
            ->values();

        // ======================================
        // CEK RECOMMENDATION EXISTING
        // ======================================

        $recommendation = Recommendation::where(
            'user_id',
            Auth::id()
        )
            ->where(
                'pss_assessment_id',
                $pssAssessment->id
            )
            ->first();

        // ======================================
        // JIKA BELUM ADA
        // MAKA SIMPAN RECOMMENDATION
        // ======================================

        if (!$recommendation) {

            $recommendation = Recommendation::create([

                'user_id' => Auth::id(),
                'pss_assessment_id' => $pssAssessment->id,
                'user_preference_id' => $activePreference->id,

            ]);

            // ======================================
            // SIMPAN RECOMMENDATION ITEMS
            // ======================================

            foreach ($finalRecommendations as $index => $recommendationData) {

                RecommendationItem::create([

                    'recommendation_id' => $recommendation->id,

                    'activity_id' =>
                    $recommendationData['activity']->id,

                    'similarity_score' =>
                    $recommendationData['similarity_score'],

                    'matching_score' =>
                    $recommendationData['matching_score'],

                    'ranking' => $index + 1,

                ]);
            }
        }

        // Ambil item rekomendasi yang sudah disimpan beserta data aktivitas terkait
        $recommendationItems = RecommendationItem::with('activity')
            ->where('recommendation_id', $recommendation->id)
            ->orderBy('ranking')
            ->get();

        return view('pages.recommendations.final-recommendation', compact(
            'pssAssessment',
            'stressLevel',
            'activePreference',
            'recommendationItems'
        ));
    }

    public function history()
    {
        $query = Recommendation::with([
            'user',
            'pssAssessment' => function ($query) {
                $query->withTrashed();
            },
            'userPreference',
            'recommendationItems'
        ]);

        // HANYA filter berdasarkan user_id jika dia Mahasiswa
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        // ======================================
        // 1. FILTER PENCARIAN (SEARCH)
        // ======================================
        if (request('search')) {
            $search = (string) request('search');
            $searchLower = strtolower($search);
            // Mapping hari bahasa Indonesia ke bahasa Inggris untuk pencarian hari
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
                // Cari berdasarkan tingkat stres di tabel relasi pssAssessment
                $q->whereHas('pssAssessment', function ($subQ) use ($search) {
                    $subQ->where('stress_level', 'like', "%{$search}%");
                })
                    // Cari berdasarkan Preferensi Aktivitas, Durasi, dan Intensitas
                    ->orWhereHas('userPreference', function ($subQ) use ($search) {
                        $subQ->where('preferred_activity_type', 'like', "%{$search}%")
                            ->orWhere('preferred_duration', 'like', "%{$search}%")
                            ->orWhere('preferred_intensity', 'like', "%{$search}%");
                    })
                    ->orWhere('created_at', 'like', "%{$search}%");
                // Jika mengetik nama hari, cari berdasarkan nama harinya
                if ($englishDay) {
                    $q->orWhereRaw('DAYNAME(created_at) = ?', [$englishDay]);
                }
            });
        }

        // ======================================
        // 2. FILTER TINGKAT STRES
        // ======================================
        if (request('stress_level')) {
            $query->whereHas('pssAssessment', function ($q) {
                $q->where('stress_level', (string) request('stress_level'));
            });
        }

        // ======================================
        // 3. FILTER TANGGAL
        // ======================================
        if (request('date')) {
            $query->whereDate('created_at', (string) request('date'));
        }

        // ======================================
        // 4. PAGINATION (ENTRIES PER PAGE)
        // ======================================
        $perPage = request('per_page', 10);

        $recommendations = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.recommendations.historyrecommendation', compact('recommendations'));
    }

    // ======================================
    // DETAIL RIWAYAT REKOMENDASI (SNAPSHOT)
    // ======================================
    public function showHistory(Recommendation $recommendation)
    {
        // IZINKAN jika pemilik OR jika yang login adalah admin
        if ($recommendation->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        // TAMBAHKAN withTrashed DI SINI JUGA
        $recommendation->load([
            'pssAssessment' => function ($query) {
                $query->withTrashed();
            },
            'userPreference',
            'recommendationItems.activity'
        ]);

        $historyItems = $recommendation->recommendationItems->sortBy('ranking');

        // Cek secara efisien apakah user sudah memberikan feedback untuk riwayat sesi ini
        $itemIds = $historyItems->pluck('id')->toArray();
        $hasAnyFeedback = Feedback::whereIn('recommendation_item_id', $itemIds)
            ->where('user_id', Auth::id())
            ->exists();

        return view('pages.recommendations.history-detail', compact('recommendation', 'historyItems', 'hasAnyFeedback'));
    }

    // ======================================
    // BULK DELETE RIWAYAT REKOMENDASI
    // ======================================
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:recommendations,id',
        ]);

        // 1. Ambil data dengan filter dinamis
        $query = Recommendation::whereIn('id', $request->ids);

        // JIKA BUKAN ADMIN, batasi hanya data miliknya sendiri
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $recommendations = $query->get();

        if ($recommendations->isEmpty()) {
            return back()->with('error', 'Tidak ada data yang valid untuk dihapus.');
        }

        $recommendationIds = $recommendations->pluck('id')->toArray();
        $preferenceIds = $recommendations->pluck('user_preference_id')->filter()->toArray();

        // 2. HAPUS ANAK (Recommendation Items)
        RecommendationItem::whereIn('recommendation_id', $recommendationIds)->delete();

        // 3. HAPUS INDUK (Recommendations)
        Recommendation::whereIn('id', $recommendationIds)->delete();

        // 4. HAPUS PASANGAN (User Preferences)
        if (!empty($preferenceIds)) {
            UserPreference::whereIn('id', $preferenceIds)->delete();
        }

        return redirect()->route('recommendations.history')
            ->with('success', count($recommendationIds) . ' riwayat rekomendasi berhasil dihapus.');
    }
}
