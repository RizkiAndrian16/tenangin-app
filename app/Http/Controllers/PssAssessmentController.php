<?php

namespace App\Http\Controllers;

use App\Models\PssAssessment;
use App\Models\PssAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PssAssessmentController extends Controller
{
    public function index()
    {
        // Load relasi user agar nama mahasiswa bisa ditampilkan
        $query = PssAssessment::with(['answers', 'user']);

        // Jika login sebagai mahasiswa, batasi HANYA data miliknya
        // Jika admin, biarkan query mengambil SEMUA data
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        if (request('stress_level')) {
            $query->where('stress_level', request('stress_level'));
        }

        if (request('search')) {
            $search = (string) request('search');

            $days = [
                'senin' => 'Monday',
                'selasa' => 'Tuesday',
                'rabu' => 'Wednesday',
                'kamis' => 'Thursday',
                'jumat' => 'Friday',
                'sabtu' => 'Saturday',
                'minggu' => 'Sunday',
            ];

            $searchLower = strtolower($search);
            $englishDay = $days[$searchLower] ?? null;

            $query->where(function ($q) use ($search, $englishDay) {
                $q->where('stress_level', 'like', "%{$search}%")
                    ->orWhere('total_score', 'like', "%{$search}%")
                    ->orWhere('created_at', 'like', "%{$search}%");

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

        if (request('date')) {
            $query->whereDate('created_at', request('date'));
        }

        $perPage = request('per_page', 10);

        $assessments = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.pss-assessments.pss-assessment', compact('assessments'));
    }

    public function exportPdf(Request $request)
    {
        // Export hanya diperuntukkan bagi admin.
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $query = PssAssessment::with('user');

        // Filter tingkat stres
        if ($request->filled('stress_level')) {
            $query->where('stress_level', $request->stress_level);
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $search = (string) $request->search;

            $days = [
                'senin' => 'Monday',
                'selasa' => 'Tuesday',
                'rabu' => 'Wednesday',
                'kamis' => 'Thursday',
                'jumat' => 'Friday',
                'sabtu' => 'Saturday',
                'minggu' => 'Sunday',
            ];

            $searchLower = strtolower($search);
            $englishDay = $days[$searchLower] ?? null;

            $query->where(function ($q) use ($search, $englishDay) {
                $q->where('stress_level', 'like', "%{$search}%")
                    ->orWhere('total_score', 'like', "%{$search}%")
                    ->orWhere('created_at', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });

                if ($englishDay) {
                    $q->orWhereRaw('DAYNAME(created_at) = ?', [$englishDay]);
                }
            });
        }

        // Filter tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Export seluruh hasil filter, bukan hanya data pada halaman pagination.
        $assessments = $query
            ->latest()
            ->get();

        // Ringkasan laporan
        $summary = [
            'total' => $assessments->count(),
            'rendah' => $assessments->where('stress_level', 'Rendah')->count(),
            'sedang' => $assessments->where('stress_level', 'Sedang')->count(),
            'tinggi' => $assessments->where('stress_level', 'Tinggi')->count(),
        ];

        // Informasi filter untuk ditampilkan pada laporan.
        $filters = [
            'stress_level' => $request->stress_level,
            'date' => $request->date,
            'search' => $request->search,
        ];

        $pdf = Pdf::loadView('pages.pss-assessments.pss-assessmentpdf', compact('assessments', 'summary', 'filters'));

        $pdf->setPaper('a4', 'landscape');

        $filename = 'Laporan_PSS-10_Tenangin_' . now()->format('d-m-Y') . '.pdf';

        return $pdf->download($filename);
    }

    public function create()
    {
        // Cegah Admin mengakses halaman form pengisian tes
        if (Auth::user()->role === 'admin') {
            return redirect()->route('pss-assessments.index')->with('error', 'Admin tidak dapat melakukan assessment.');
        }

        $questions = PssAssessment::QUESTIONS;
        $options = PssAssessment::OPTIONS;

        return view('pages.pss-assessments.pss-assessmentcreate', compact('questions', 'options'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'answers' => ['required', 'array', 'size:10'],
            'answers.*' => ['required', 'integer', 'min:0', 'max:4'],
        ]);

        $answers = $request->answers;
        $positiveItems = [4, 5, 7, 8];
        $totalScore = 0;

        foreach ($answers as $questionNumber => $answerScore) {
            if (in_array($questionNumber, $positiveItems)) {
                $totalScore += (4 - $answerScore);
            } else {
                $totalScore += $answerScore;
            }
        }

        if ($totalScore >= 0 && $totalScore <= 13) {
            $stressLevel = 'Rendah';
        } elseif ($totalScore >= 14 && $totalScore <= 26) {
            $stressLevel = 'Sedang';
        } else {
            $stressLevel = 'Tinggi';
        }

        $assessment = PssAssessment::create([
            'user_id' => Auth::id(),
            'total_score' => $totalScore,
            'stress_level' => $stressLevel,
        ]);

        foreach ($answers as $questionNumber => $answerScore) {
            PssAnswer::create([
                'pss_assessment_id' => $assessment->id,
                'question_number' => $questionNumber,
                'answer_score' => $answerScore,
            ]);
        }

        return redirect()->route('pss-assessments.show', $assessment->id);
    }

    public function show(PssAssessment $pssAssessment)
    {
        // Admin diizinkan melihat. Jika mahasiswa, pastikan itu miliknya.
        if ($pssAssessment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $pssAssessment->load(['user', 'answers', 'recommendations']);

        $questions = PssAssessment::QUESTIONS;
        $options = PssAssessment::OPTIONS;

        return view('pages.pss-assessments.pss-assessmentshow', compact('pssAssessment', 'questions', 'options'));
    }

    public function edit(PssAssessment $pssAssessment)
    {
        //
    }

    public function update(Request $request, PssAssessment $pssAssessment)
    {
        //
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer'
        ]);

        $query = PssAssessment::whereIn('id', $request->ids);

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $assessments = $query->get();

        foreach ($assessments as $assessment) {
            $assessment->answers()->delete();
            $assessment->delete();
        }

        return redirect()
            ->route('pss-assessments.index')
            ->with('success', 'Assessment yang dipilih berhasil dihapus.');
    }

    public function destroy(PssAssessment $pssAssessment)
    {
        if ($pssAssessment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $pssAssessment->answers()->delete();
        $pssAssessment->delete();

        return redirect()
            ->route('pss-assessments.index')
            ->with('success', 'Assessment berhasil dihapus.');
    }
}
