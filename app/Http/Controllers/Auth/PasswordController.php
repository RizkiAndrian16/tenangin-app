<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $rules = [
            'password' => ['required', Password::defaults(), 'confirmed'],
        ];

        if ($request->user()->password !== null) {
            $rules['current_password'] = ['required', 'current_password'];
        }

        $validated = $request->validateWithBag(
            'updatePassword',
            $rules
        );

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        return back()->with('status', 'password-updated');
    }
}
