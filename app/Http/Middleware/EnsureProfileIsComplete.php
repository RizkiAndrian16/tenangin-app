<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsComplete
{
    /**
     * Memastikan mahasiswa telah melengkapi profil
     * sebelum mengakses fitur yang membutuhkan profil lengkap.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Jika tidak ada user yang login, biarkan middleware auth
        // yang menangani autentikasi.
        if (!$user) {
            return $next($request);
        }

        // Pemeriksaan kelengkapan profil hanya berlaku untuk mahasiswa.
        // Admin tidak terpengaruh oleh middleware ini.
        if (!$user->isMahasiswa()) {
            return $next($request);
        }

        // Jika profil mahasiswa belum lengkap, arahkan ke halaman profil.
        if (!$user->hasCompleteProfile()) {
            return redirect()
                ->route('profile.edit')
                ->with(
                    'warning',
                    'Biar fitur-fitur Tenangin bisa berjalan maksimal dan sesuai sama kondisimu, yuk isi sedikit info profilmu dulu.'
                );
        }

        return $next($request);
    }
}
