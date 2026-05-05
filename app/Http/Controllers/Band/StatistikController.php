<?php
namespace App\Http\Controllers\Band;

use App\Http\Controllers\Controller;
use App\Models\SesiTopsis;

class StatistikController extends Controller
{
    public function index()
    {
        $band = auth()->user()->band;

        if (!$band) {
            return redirect()->route('band.profil')->with('info', 'Lengkapi profil band Anda terlebih dahulu.');
        }

        $sesiList = SesiTopsis::whereJsonContains('hasil_ranking', [['id' => $band->id]])
            ->latest()
            ->paginate(10);

        $totalDitemukan = SesiTopsis::whereJsonContains('hasil_ranking', [['id' => $band->id]])->count();

        $kaliRank1   = 0;
        $totalCi     = 0;
        $totalRank   = 0;
        $countRank   = 0;

        $allSesi = SesiTopsis::whereJsonContains('hasil_ranking', [['id' => $band->id]])->get();
        foreach ($allSesi as $sesi) {
            foreach ($sesi->hasil_ranking as $r) {
                if ($r['id'] == $band->id) {
                    if ($r['rank'] == 1) $kaliRank1++;
                    $totalCi   += $r['ci'];
                    $totalRank += $r['rank'];
                    $countRank++;
                    break;
                }
            }
        }

        $rataRataCi   = $countRank > 0 ? round($totalCi / $countRank, 3) : '—';
        $rataRataRank = $countRank > 0 ? round($totalRank / $countRank, 1) : '—';

        return view('band.statistik', compact(
            'band','sesiList','totalDitemukan','kaliRank1','rataRataCi','rataRataRank'
        ));
    }
}
