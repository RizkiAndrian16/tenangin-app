<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Feedback;
use App\Models\PssAssessment;
use App\Models\Recommendation;
use App\Models\RuleBasedRule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return view('dashboard', $this->getAdminData());
        }

        return view('dashboard', $this->getMahasiswaData($user));
    }

    private function getAdminData(): array
    {
        $totalUsers = User::count();
        $totalAssessments = PssAssessment::count();
        $totalActivities = Activity::count();
        $totalFeedbacks = Feedback::count();
        $totalRules = RuleBasedRule::count();
        $totalRecommendations = Recommendation::count();

        $usersHighStress = User::where('role', 'mahasiswa')
            ->whereHas('latestPssAssessment', function ($query) {
                $query->where('stress_level', 'Tinggi');
            })
            ->count();

        // Tren bulanan (Januari tahun berjalan s.d. bulan sekarang)
        $monthlyLabels = [];
        $monthlyUsers = [];
        $monthlyAssessments = [];
        $monthlyFeedbacks = [];

        $limit = now()->month - 1;

        for ($i = $limit; $i >= 0; $i--) {
            $startOfMonth = now()->subMonths($i)->startOfMonth();
            $endOfMonth = now()->subMonths($i)->endOfMonth();

            $monthlyLabels[] = $startOfMonth->format('M Y');

            $monthlyUsers[] = User::where('role', 'mahasiswa')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();

            $monthlyAssessments[] = PssAssessment::whereBetween('created_at', [
                $startOfMonth,
                $endOfMonth,
            ])->count();

            $monthlyFeedbacks[] = Feedback::whereBetween('created_at', [
                $startOfMonth,
                $endOfMonth,
            ])->count();
        }

        $latestUsers = User::latest()->take(5)->get();
        $latestAssessments = PssAssessment::with('user')->latest()->take(5)->get();
        $latestFeedbacks = Feedback::with(['user', 'recommendationItem.activity'])
            ->latest()
            ->take(5)
            ->get();

        return compact(
            'totalUsers',
            'totalAssessments',
            'totalActivities',
            'totalFeedbacks',
            'totalRules',
            'totalRecommendations',
            'usersHighStress',
            'monthlyLabels',
            'monthlyUsers',
            'monthlyAssessments',
            'monthlyFeedbacks',
            'latestUsers',
            'latestAssessments',
            'latestFeedbacks'
        );
    }

    private function getMahasiswaData(User $user): array
    {
        // 1. Data Grafik (10 Assessment Terakhir)
        $chartData = $user->pssAssessments()->latest()->take(10)->get()->reverse()->values();

        $labels = [];
        $scores = [];
        $stressLevels = [];

        foreach ($chartData as $item) {
            $labels[] = $item->created_at->format('d M');
            $scores[] = $item->total_score;
            $stressLevels[] = $item->stress_level;
        }

        if (empty($labels)) {
            $labels = ['', '', '', '', ''];
        }

        // 2. Data Tabel (Assessment Terakhir)
        $lastAssessment = $user->pssAssessments()->latest()->first();
        $stressScore = $lastAssessment->total_score ?? 0;

        // 3. Statistik Kartu Mahasiswa
        $totalAssessments = $user->pssAssessments()->count();
        $totalRecommendations = $user->recommendations()->count();
        $totalFeedbacks = $user->feedbacks()->count();

        // 4. Preferensi Aktivitas Relaksasi Aktif
        $activePreference = $user->activePreference;

        return compact(
            'chartData',
            'labels',
            'scores',
            'stressLevels',
            'lastAssessment',
            'stressScore',
            'totalAssessments',
            'totalRecommendations',
            'totalFeedbacks',
            'activePreference'
        );
    }
}
