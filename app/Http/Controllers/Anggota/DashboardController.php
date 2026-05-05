<?php
// FILE: app/Http/Controllers/Anggota/DashboardController.php
namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\{Band, Genre, SesiTopsis};

class DashboardController extends Controller
{
    public function index()
    {
        $totalBand     = Band::where('status', 'aktif')->count();
        $totalGenre    = Genre::where('status', 'aktif')->count();
        $sesiUser      = SesiTopsis::where('user_id', auth()->id())->count();
        $rekomendasiTerakhir = SesiTopsis::where('user_id', auth()->id())->latest()->first();

        $bandTerpopuler = Band::with('genre')
            ->where('status', 'aktif')
            ->orderByDesc('pengikut')
            ->take(5)
            ->get()
            ->map(function ($b, $i) {
                $b->rank = $i + 1;
                return $b;
            });

        $riwayatTopsis = SesiTopsis::where('user_id', auth()->id())
            ->latest()->take(3)->get();

        return view('anggota.dashboard', compact(
            'totalBand','totalGenre','sesiUser','rekomendasiTerakhir',
            'bandTerpopuler','riwayatTopsis'
        ));
    }
}
