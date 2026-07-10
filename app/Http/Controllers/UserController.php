<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $query = User::query();

        if (request('role')) {
            $query->where('role', request('role'));
        }

        if (request('search')) {
            $search = strtolower((string) request('search'));

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('university', 'like', "%{$search}%")
                    ->orWhere('major', 'like', "%{$search}%");
            });
        }

        if (request('gender')) {
            $query->where('gender', request('gender'));
        }

        $perPage = request('per_page', 10);

        $users = $query
            ->orderBy('role', 'asc')
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.users.user', compact('users'));
    }

    public function create()
    {
        return view('pages.users.usercreate');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)
            ],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,mahasiswa'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('pages.users.usershow', compact('user'));
    }

    public function edit(User $user)
    {
        return view('pages.users.useredit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,mahasiswa'],
        ]);

        // 2. PERUBAHAN PADA LOGIKA PASSWORD DI SINI
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);

            // Hapus semua sesi milik user ini agar dia otomatis ter-logout (Force Logout)
            DB::table('sessions')->where('user_id', $user->id)->delete();
        } else {
            unset($validated['password']);
        }

        // Khusus Admin (jika dia mengubah role-nya sendiri tanpa ganti password, cegah jangan sampai ke-logout)
        // Tapi jika yang diubah role mahasiswa/admin lain, boleh.
        $user->update($validated);

        return redirect()
            ->route('users.index', [
                'page' => $request->page
            ])
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:users,id'
        ]);

        $idsToDelete = array_filter($request->ids, function ($id) {
            return $id != Auth::id();
        });

        User::whereIn('id', $idsToDelete)->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna yang dipilih berhasil dinonaktifkan.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            abort(403, 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil dinonaktifkan.');
    }
}
