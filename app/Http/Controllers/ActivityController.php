<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $query = Activity::query();

        if (request('search')) {
            $search = strtolower(request('search'));

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('activity_type', 'like', "%{$search}%")
                    ->orWhere('duration_category', 'like', "%{$search}%")
                    ->orWhere('intensity_level', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        if (request('stress_level')) {

            $query->where(
                'stress_level_target',
                'LIKE',
                '%' . request('stress_level') . '%'
            );
        }

        if (request('status')) {

            $query->where(
                'status',
                request('status')
            );
        }

        if (request('intensity_level')) {

            $query->where(
                'intensity_level',
                request('intensity_level')
            );
        }

        $perPage = request('per_page', 10);

        $activities = $query
            ->oldest()
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.activities.activity', compact('activities'));
    }

    public function create()
    {
        return view('pages.activities.activitycreate');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'required',
                'string'
            ],

            'activity_type' => [
                'required',
                'string',
                'max:100'
            ],

            'duration_category' => [
                'required',
                'in:<= 15 menit,10 - 30 menit,> 30 menit'
            ],

            'intensity_level' => [
                'required',
                'in:Ringan,Sedang'
            ],

            'stress_level_target' => [
                'required',
                'string',
                'max:255'
            ],

            'status' => [
                'required',
                'in:Direkomendasikan,Direkomendasikan terbatas,Tidak direkomendasikan,Perlu perhatian'
            ],

            'instruction' => [
                'nullable',
                'string'
            ],

        ]);

        Activity::create($validated);

        return redirect()
            ->route('activities.index')
            ->with('success', 'Aktivitas relaksasi berhasil ditambahkan.');
    }

    // public function show(Activity $activity)
    // {
    //     return view('pages.activities.activityshow', compact('activity'));
    // }

    public function edit(Activity $activity)
    {
        return view('pages.activities.activityedit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'required',
                'string'
            ],

            'activity_type' => [
                'required',
                'string',
                'max:100'
            ],

            'duration_category' => [
                'required',
                'in:<= 15 menit,10 - 30 menit,> 30 menit'
            ],

            'intensity_level' => [
                'required',
                'in:Ringan,Sedang'
            ],

            'stress_level_target' => [
                'required',
                'string',
                'max:255'
            ],

            'status' => [
                'required',
                'in:Direkomendasikan,Direkomendasikan terbatas,Tidak direkomendasikan,Perlu perhatian'
            ],

            'instruction' => [
                'nullable',
                'string'
            ],

        ]);

        $activity->update($validated);

        return redirect()
            ->route('activities.index', [
                'page' => $request->page
            ])
            ->with('success', 'Aktivitas relaksasi berhasil diperbarui.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer'
        ]);

        Activity::whereIn('id', $request->ids)
            ->delete();

        return redirect()
            ->route('activities.index')
            ->with(
                'success',
                'Aktivitas relaksasi yang dipilih berhasil dihapus.'
            );
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()
            ->route('activities.index')
            ->with('success', 'Aktivitas relaksasi berhasil dihapus.');
    }
}
