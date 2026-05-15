<?php

namespace App\Http\Controllers;

use App\Models\PssAssessment;
use App\Models\PssAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PssAssessmentController extends Controller
{
    public function index()
    {
        $query = PssAssessment::with('answers')
            ->where('user_id', Auth::id());

        if (request('stress_level')) {

            $query->where(
                'stress_level',
                request('stress_level')
            );
        }

        if (request('search')) {

            $search = strtolower(request('search'));

            $days = [
                'senin' => 'Monday',
                'selasa' => 'Tuesday',
                'rabu' => 'Wednesday',
                'kamis' => 'Thursday',
                'jumat' => 'Friday',
                'sabtu' => 'Saturday',
                'minggu' => 'Sunday',
            ];

            $englishDay = $days[$search] ?? null;

            $query->where(function ($q) use ($search, $englishDay) {

                $q->whereRaw(
                    'LOWER(stress_level) LIKE ?',
                    ['%' . $search . '%']
                )

                    ->orWhereRaw(
                        'CAST(total_score AS CHAR) LIKE ?',
                        ['%' . $search . '%']
                    )

                    ->orWhereRaw(
                        "DATE_FORMAT(created_at, '%d-%m-%Y') LIKE ?",
                        ['%' . $search . '%']
                    )

                    ->orWhereRaw(
                        "DATE_FORMAT(created_at, '%Y-%m-%d') LIKE ?",
                        ['%' . $search . '%']
                    );

                if ($englishDay) {

                    $q->orWhereRaw(
                        'DAYNAME(created_at) = ?',
                        [$englishDay]
                    );
                }
            });
        }

        if (request('date')) {

            $query->whereDate(
                'created_at',
                request('date')
            );
        }

        $perPage = request('per_page', 10);

        $assessments = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.pss-assessments.pss-assessment', compact('assessments'));
    }

    public function create()
    {
        return view('pages.pss-assessments.pss-assessmentcreate');
    }

    public function store(Request $request)
    {
        $request->validate([

            'answers' => [
                'required',
                'array',
                'size:10'
            ],

            'answers.*' => [
                'required',
                'integer',
                'min:0',
                'max:4'
            ],

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

        return redirect()
            ->route('pss-assessments.show', $assessment->id)
            ->with('success', 'Assessment berhasil disimpan.');
    }

    public function show(PssAssessment $pssAssessment)
    {
        if ($pssAssessment->user_id !== Auth::id()) {

            abort(403);
        }

        $pssAssessment->load([
            'user',
            'answers',
            'recommendations'

        ]);

        return view('pages.pss-assessments.pss-assessmentshow', compact('pssAssessment'));
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

        $assessments = PssAssessment::whereIn('id', $request->ids)
            ->where('user_id', Auth::id())
            ->get();

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
        $pssAssessment->answers()->delete();
        $pssAssessment->delete();

        return redirect()
            ->route('pss-assessments.index')
            ->with('success', 'Assessment berhasil dihapus.');
    }
}
