<?php
// FILE: app/Http/Controllers/Anggota/HasilTopsisController.php
namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\SesiTopsis;

class HasilTopsisController extends Controller
{
    public function show(SesiTopsis $sesi)
    {
        // Pastikan hanya pemilik sesi yang bisa lihat
        if ($sesi->user_id !== auth()->id()) {
            abort(403);
        }
        return view('anggota.hasil', compact('sesi'));
    }
}
