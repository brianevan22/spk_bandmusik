<?php
// ============================================================
// FILE: app/Http/Controllers/Admin/DashboardController.php
// ============================================================
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Band, User, SesiTopsis, Genre, LogAktivitas};

class DashboardController extends Controller
{
    public function index()
    {
        $totalBand    = Band::count();
        $totalAnggota = User::where('role', '!=', 'admin')->count();
        $sesiTopsis   = SesiTopsis::count();
        $genreAktif   = Genre::where('status', 'aktif')->count();
        $bandTerbaru  = Band::with('genre')->latest()->take(5)->get();
        $logTerbaru   = LogAktivitas::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalBand','totalAnggota','sesiTopsis','genreAktif','bandTerbaru','logTerbaru'
        ));
    }
}
