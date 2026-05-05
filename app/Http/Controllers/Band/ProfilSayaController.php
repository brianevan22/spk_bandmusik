<?php
namespace App\Http\Controllers\Band;

use App\Http\Controllers\Controller;
use App\Models\{Band, Genre, LogAktivitas};
use Illuminate\Http\Request;

class ProfilSayaController extends Controller
{
    public function edit()
    {
        $band   = auth()->user()->band;
        $genres = Genre::where('status', 'aktif')->get();
        return view('band.profil', compact('band', 'genres'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_band'    => 'required|string|max:100',
            'genre_id'     => 'required|exists:genres,id',
            'lokasi'       => 'required|string|max:100',
            'tahun_berdiri'=> 'required|integer|min:1900|max:'.now()->year,
            'pengikut'     => 'required|integer|min:0',
            'biaya_sewa'   => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
        ]);

        $user = auth()->user();

        if ($user->band) {
            $user->band->update($request->only([
                'nama_band','genre_id','lokasi','tahun_berdiri','pengikut','biaya_sewa','deskripsi'
            ]));
        } else {
            Band::create(array_merge(
                $request->only(['nama_band','genre_id','lokasi','tahun_berdiri','pengikut','biaya_sewa','deskripsi']),
                ['user_id' => $user->id]
            ));
        }

        $user->update(['name' => $request->nama_band]);

        LogAktivitas::create([
            'user_id'    => $user->id,
            'aksi'       => 'Update Profil',
            'detail'     => 'Profil band diperbarui: '.$request->nama_band,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('band.profil')->with('success', 'Profil berhasil disimpan!');
    }
}
