<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\RuleBasedRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class RuleBasedRuleController extends Controller
{
    public function index()
    {
        $query = RuleBasedRule::with('activity');

        if (request('search')) {
            $search = request('search');

            $query->where(function ($q) use ($search) {
                $q->where('stress_level', 'like', "%{$search}%")
                    ->orWhereHas('activity', function ($activityQuery) use ($search) {
                        $activityQuery->where('title', 'like', "%{$search}%")
                            ->orWhere('activity_type', 'like', "%{$search}%");
                    });
            });
        }

        if (request('stress_level')) {
            $query->where('stress_level', request('stress_level'));
        }

        if (request('intensity_level')) {

            $query->whereHas('activity', function ($q) {

                $q->where(
                    'intensity_level',
                    request('intensity_level')
                );
            });
        }

        $perPage = request('per_page', 10);

        $rules = $query
            ->oldest()
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.rule-based-rules.rulebasedrule', compact('rules'));
    }


    public function create()
    {
        $activities = Activity::orderBy('title')->get();

        return view('pages.rule-based-rules.rulebasedrulecreate', compact('activities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'stress_level' => [
                'required',
                'in:Rendah,Sedang,Tinggi'
            ],

            'activity_id' => [
                'required',
                'exists:activities,id',

                Rule::unique('rule_based_rules')
                    ->where(function ($query) use ($request) {

                        return $query->where(
                            'stress_level',
                            $request->stress_level
                        );
                    })
            ],

            'description' => [
                'nullable',
                'string'
            ],

        ], [

            'stress_level.required' => 'Harap mengisi seluruh form Aturan Rekomendasi sebelum menyimpan.',
            'activity_id.required'  => 'Harap mengisi seluruh form Aturan Rekomendasi sebelum menyimpan.',
            'description.required'  => 'Harap mengisi seluruh form Aturan Rekomendasi sebelum menyimpan.',
            'activity_id.unique' => 'Aturan rekomendasi dengan tingkat stres dan aktivitas relaksasi tersebut sudah tersedia.',

        ]);

        RuleBasedRule::create($validated);

        return redirect()
            ->route('rule-based-rules.index')
            ->with('success', 'Aturan rekomendasi berhasil ditambahkan.');
    }

    public function edit(RuleBasedRule $ruleBasedRule)
    {
        $activities = Activity::orderBy('title')->get();

        return view('pages.rule-based-rules.rulebasedruleedit', compact('ruleBasedRule', 'activities'));
    }

    public function update(
        Request $request,
        RuleBasedRule $ruleBasedRule
    ) {
        $validated = $request->validate([

            'stress_level' => [
                'required',
                'in:Rendah,Sedang,Tinggi'
            ],

            'activity_id' => [
                'required',
                'exists:activities,id',

                Rule::unique('rule_based_rules')
                    ->where(function ($query) use ($request) {

                        return $query->where(
                            'stress_level',
                            $request->stress_level
                        );
                    })
                    ->ignore($ruleBasedRule->id)
            ],

            'description' => [
                'nullable',
                'string'
            ],

        ], [

            'stress_level.required' => 'Harap mengisi seluruh form Aturan Rekomendasi sebelum menyimpan.',
            'activity_id.required'  => 'Harap mengisi seluruh form Aturan Rekomendasi sebelum menyimpan.',
            'description.required'  => 'Harap mengisi seluruh form Aturan Rekomendasi sebelum menyimpan.',
            'activity_id.unique' => 'Aturan rekomendasi dengan tingkat stres dan aktivitas relaksasi tersebut sudah tersedia.',

        ]);

        $ruleBasedRule->update($validated);

        return redirect()
            ->route('rule-based-rules.index', [
                'page' => $request->page
            ])
            ->with('success', 'Aturan rekomendasi berhasil diperbarui.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer'
        ]);

        RuleBasedRule::whereIn('id', $request->ids)
            ->delete();

        return redirect()
            ->route('rule-based-rules.index')
            ->with('success', 'Aturan rekomendasi yang dipilih berhasil dihapus.');
    }

    public function destroy(RuleBasedRule $ruleBasedRule)
    {
        $ruleBasedRule->delete();

        return redirect()
            ->route('rule-based-rules.index')
            ->with('success', 'Aturan rekomendasi berhasil dihapus.');
    }
}
