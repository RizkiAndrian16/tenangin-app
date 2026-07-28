<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.profileedit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'gender'       => ['nullable', 'in:Laki-Laki,Perempuan'],
            'age'          => ['nullable', 'integer', 'min:1', 'max:99'],
            'phone_number' => ['nullable', 'string', 'max:20'],
        ]);

        $user = $request->user();

        $user->fill($validated)->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Informasi pribadi berhasil diperbarui.');
    }

    public function updateUniversity(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'university'       => ['nullable', 'string', 'max:255'],
            'major'            => ['nullable', 'string', 'max:255'],
            'semester'         => ['nullable', 'integer', 'min:1', 'max:14'],
            'residence_status' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->residence_status === 'Lainnya' && $request->filled('residence_status_other')) {
            $validated['residence_status'] = $request->residence_status_other;
        }

        $user = $request->user();

        $user->fill($validated)->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Informasi universitas berhasil diperbarui.');
    }

    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        $user = $request->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request
            ->file('profile_photo')
            ->store('profile-photos', 'public');

        $user->profile_photo = $path;
        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
