<?php

namespace App\Http\Controllers;

use App\Models\PssAssessment;
use App\Models\RuleBasedRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserPreference;
use App\Models\Activity;
use Illuminate\Support\Collection;
use App\Models\Recommendation;
use App\Models\RecommendationItem;

class RecommendationController extends Controller
{
    public function index(PssAssessment $pssAssessment)
    {
        if ($pssAssessment->user_id !== Auth::id()) {

            abort(403);
        }

        $stressLevel = $pssAssessment->stress_level;

        $query = RuleBasedRule::with('activity')

            ->where('stress_level', $stressLevel)

            ->whereHas('activity', function ($query) {

                $query->whereIn('status', [
                    'Direkomendasikan',
                    'Direkomendasikan terbatas'
                ]);
            });

        // ======================================
        // RULE BASED IF-THEN
        // ======================================

        // IF tingkat stres = tinggi
        // THEN rekomendasikan aktivitas intensitas ringan
        if ($stressLevel == 'Tinggi') {

            $query->whereHas('activity', function ($query) {

                $query->where(
                    'intensity_level',
                    'Ringan'
                );
            });
        }

        // IF tingkat stres = sedang
        // THEN rekomendasikan aktivitas ringan hingga sedang
        elseif ($stressLevel == 'Sedang') {

            $query->whereHas('activity', function ($query) {

                $query->whereIn('intensity_level', [
                    'Ringan',
                    'Sedang'
                ]);
            });
        }

        // IF tingkat stres = rendah
        // THEN rekomendasikan aktivitas dengan variasi lebih luas
        else {

            // tidak perlu filter intensitas

        }

        $rules = $query
            ->oldest()
            ->get();

        return view('pages.recommendations.recommendation', compact('pssAssessment', 'rules', 'stressLevel'));
    }

    public function processPreferences(
        Request $request,
        PssAssessment $pssAssessment
    ) {
        if ($pssAssessment->user_id !== Auth::id()) {

            abort(403);
        }

        $validated = $request->validate([

            'preferred_activity_type' => [
                'required',
                'string'
            ],

            'preferred_duration' => [
                'required',
                'string'
            ],

            'preferred_intensity' => [
                'required',
                'string'
            ],

        ]);

        UserPreference::where(
            'user_id',
            Auth::id()
        )->update([
            'is_active' => false
        ]);

        UserPreference::create([

            'user_id' => Auth::id(),

            'preferred_activity_type' =>
            $validated['preferred_activity_type'],

            'preferred_duration' =>
            $validated['preferred_duration'],

            'preferred_intensity' =>
            $validated['preferred_intensity'],

            'is_active' => true,

        ]);

        return redirect()
            ->route('recommendations.final', $pssAssessment->id)
            ->with(
                'success',
                'Preferensi aktivitas berhasil disimpan.'
            );
    }

    public function generateFinalRecommendation(
        PssAssessment $pssAssessment
    ) {
        if ($pssAssessment->user_id !== Auth::id()) {

            abort(403);
        }

        $stressLevel = $pssAssessment->stress_level;

        $activePreference = UserPreference::where(
            'user_id',
            Auth::id()
        )
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$activePreference) {

            return redirect()
                ->route('recommendations.index', $pssAssessment->id)
                ->with(
                    'error',
                    'Preferensi aktivitas belum dipilih.'
                );
        }

        // ======================================
        // RULE BASED CANDIDATE ACTIVITIES
        // ======================================

        $query = RuleBasedRule::with('activity')

            ->where('stress_level', $stressLevel)

            ->whereHas('activity', function ($query) {

                $query->whereIn('status', [
                    'Direkomendasikan',
                    'Direkomendasikan terbatas'
                ]);
            });

        // stres tinggi
        if ($stressLevel == 'Tinggi') {

            $query->whereHas('activity', function ($query) {

                $query->where(
                    'intensity_level',
                    'Ringan'
                );
            });
        }

        // stres sedang
        elseif ($stressLevel == 'Sedang') {

            $query->whereHas('activity', function ($query) {

                $query->whereIn('intensity_level', [
                    'Ringan',
                    'Sedang'
                ]);
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

            // ======================================
            // JENIS AKTIVITAS
            // BOBOT = 3
            // ======================================

            if (
                $activity->activity_type ==
                $activePreference->preferred_activity_type
            ) {

                $score += 3;
            }

            // ======================================
            // DURASI
            // BOBOT = 2
            // ======================================

            if (
                $activity->duration_category ==
                $activePreference->preferred_duration
            ) {

                $score += 2;
            }

            // ======================================
            // INTENSITAS
            // BOBOT = 2
            // ======================================

            if (
                $activity->intensity_level ==
                $activePreference->preferred_intensity
            ) {

                $score += 2;
            }

            // ======================================
            // NORMALISASI SIMILARITY SCORE
            // TOTAL BOBOT = 7
            // ======================================

            $similarityScore = $score / 7;

            $recommendations->push([

                'activity' => $activity,

                'similarity_score' => $similarityScore,

                'matching_score' => $score,

            ]);
        }

        // ======================================
        // SORTING RANKING
        // ======================================

        $finalRecommendations = $recommendations
            ->sortByDesc('similarity_score')
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

        return view(
            'pages.recommendations.final-recommendation',
            compact(
                'pssAssessment',
                'stressLevel',
                'activePreference',
                'finalRecommendations'
            )
        );
    }

    public function history()
    {
        $recommendations = Recommendation::with([
            'pssAssessment',
            'userPreference',
            'recommendationItems'
        ])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view(
            'pages.recommendations.historyrecommendation',
            compact('recommendations')
        );
    }
}
