<?php
// ============================================================
// FILE: app/Http/Controllers/Auth/RegisteredUserController.php
// GANTI file yang dibuat Breeze dengan ini (tambahkan field 'role')
// ============================================================
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\{User, Band, Genre};
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role'     => ['required', 'in:anggota,band'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Jika role band, buat data band kosong
        if ($request->role === 'band') {
            $defaultGenre = Genre::first();
            Band::create([
                'user_id'      => $user->id,
                'genre_id'     => $defaultGenre?->id ?? 1,
                'nama_band'    => $request->name,
                'lokasi'       => '-',
                'tahun_berdiri'=> now()->year,
                'pengikut'     => 0,
                'biaya_sewa'   => 0,
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
