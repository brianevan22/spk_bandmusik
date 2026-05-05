<?php
// FILE: app/Http/Controllers/Auth/AuthenticatedSessionController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LogAktivitas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        $selectedRole = $request->input('role');

        // Validasi: role yang dipilih harus cocok dengan role di database
        if ($user->role !== $selectedRole) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withInput($request->only('email', 'role'))
                ->withErrors([
                    'email' => 'Akun ini tidak terdaftar sebagai ' . ucfirst($selectedRole) . '. Silakan pilih role yang sesuai.',
                ]);
        }

        // FR-14: Catat log aktivitas login
        LogAktivitas::create([
            'user_id'    => $user->id,
            'aksi'       => 'Login',
            'detail'     => 'Login sebagai ' . ucfirst($user->role) . ' — ' . $user->name,
            'ip_address' => $request->ip(),
        ]);

        // Redirect berdasarkan role
        return match($user->role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'band'    => redirect()->route('band.dashboard'),
            'anggota' => redirect()->route('anggota.dashboard'),
            default   => redirect('/'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // FR-14: Catat log aktivitas logout
        if ($user) {
            LogAktivitas::create([
                'user_id'    => $user->id,
                'aksi'       => 'Logout',
                'detail'     => 'Logout — ' . $user->name,
                'ip_address' => $request->ip(),
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}