<?php
// FILE: app/Http/Controllers/Anggota/ProfilBandController.php
namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Band;

class ProfilBandController extends Controller
{
    public function show(Band $band)
    {
        // Simpan band terakhir yang dilihat ke session
        session(['last_band_id' => $band->id]);

        $band->load('genre');
        return view('anggota.profil-band', compact('band'));
    }
}