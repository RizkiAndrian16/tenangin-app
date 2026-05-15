<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
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
        return view('profile.profiledit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'gender'       => ['nullable', 'in:Laki-Laki,Perempuan'],
            'age'          => ['nullable', 'integer', 'min:1', 'max:99'],
            'phone_number' => ['nullable', 'string', 'max:20'],
        ]);

        $user = $request->user();

        $user->fill($validated)->save();

        return response()->json([
            'success' => true,
            'message' => 'Informasi pribadi berhasil diperbarui!',
            'data'    => [
                'name'         => $user->name,
                'gender'       => $user->gender,
                'age'          => $user->age,
                'phone_number' => $user->phone_number,
            ],
        ]);
    }

    public function updateUniversity(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'university'       => ['nullable', 'string', 'max:255'],
            'major'            => ['nullable', 'string', 'max:255'],
            'semester'         => ['nullable', 'integer', 'min:1', 'max:14'],
            'residence_status' => ['nullable', 'in:Kos,Kontrak,Rumah Sendiri,Menumpang,Asrama'],
        ]);

        $user = $request->user();

        $user->fill($validated)->save();

        return response()->json([
            'success' => true,
            'message' => 'Informasi universitas berhasil diperbarui!',
            'data'    => [
                'university'       => $user->university,
                'major'            => $user->major,
                'semester'         => $user->semester,
                'residence_status' => $user->residence_status,
            ],
        ]);
    }

    public function updatePhoto(Request $request): JsonResponse
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
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

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui!',
            'data'    => [
                'profile_photo_url' => asset('storage/' . $path),
            ],
        ]);
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
