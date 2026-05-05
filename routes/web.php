<?php
// FILE: routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Anggota;
use App\Http\Controllers\Band;

Route::get('/', fn() => redirect()->route('login'));

// Auth routes (dari Breeze)
require __DIR__.'/auth.php';

// Redirect setelah login berdasarkan role
Route::get('/dashboard', function () {
    return match(auth()->user()->role) {
        'admin'   => redirect()->route('admin.dashboard'),
        'band'    => redirect()->route('band.dashboard'),
        default   => redirect()->route('anggota.dashboard'),
    };
})->middleware(['auth'])->name('dashboard');

// =============================================
// ADMIN ROUTES
// =============================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Band
    Route::resource('band', Admin\BandController::class);

    // Manajemen Anggota
    Route::get('/anggota', [Admin\AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/{user}/edit', [Admin\AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{user}', [Admin\AnggotaController::class, 'update'])->name('anggota.update');
    Route::patch('/anggota/{user}/toggle-status', [Admin\AnggotaController::class, 'toggleStatus'])->name('anggota.toggle');

    // Manajemen Genre
    Route::resource('genre', Admin\GenreController::class);

    // Log Aktivitas
    Route::get('/log', [Admin\LogAktivitasController::class, 'index'])->name('log.index');
});

// =============================================
// ANGGOTA ROUTES
// =============================================
Route::prefix('anggota')->name('anggota.')->middleware(['auth', 'role:anggota'])->group(function () {
    Route::get('/dashboard', [Anggota\DashboardController::class, 'index'])->name('dashboard');

    // Filter & TOPSIS
    Route::get('/filter', [Anggota\FilterBandController::class, 'index'])->name('filter');
    Route::post('/filter', [Anggota\FilterBandController::class, 'filter'])->name('filter.apply');
    Route::post('/topsis', [Anggota\FilterBandController::class, 'jalankanTopsis'])->name('topsis.run');
    Route::get('/filter/reset', [Anggota\FilterBandController::class, 'reset'])->name('filter.reset');

    // Hasil TOPSIS
    Route::get('/hasil/{sesi}', [Anggota\HasilTopsisController::class, 'show'])->name('hasil');

    // Profil Band (read only)
    Route::get('/profil-band/{band}', [Anggota\ProfilBandController::class, 'show'])->name('profil-band');
});

// =============================================
// BAND ROUTES
// =============================================
Route::prefix('band')->name('band.')->middleware(['auth', 'role:band'])->group(function () {
    Route::get('/dashboard', [Band\DashboardController::class, 'index'])->name('dashboard');

    // Profil Band (edit sendiri)
    Route::get('/profil', [Band\ProfilSayaController::class, 'edit'])->name('profil');
    Route::put('/profil', [Band\ProfilSayaController::class, 'update'])->name('profil.update');

    // Statistik & Ranking
    Route::get('/statistik', [Band\StatistikController::class, 'index'])->name('statistik');
});
