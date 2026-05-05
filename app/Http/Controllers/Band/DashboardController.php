<?php
// FILE: app/Http/Controllers/Band/DashboardController.php
namespace App\Http\Controllers\Band;

use App\Http\Controllers\Controller;
use App\Models\SesiTopsis;

class DashboardController extends Controller
{
    public function index()
    {
        $band = auth()->user()->band;
        if (!$band) {
            return redirect()->route('band.profil')->with('info', 'Lengkapi profil band Anda terlebih dahulu.');
        }

        $sesiTerakhir  = SesiTopsis::whereJsonContains('hasil_ranking', [['id' => $band->id]])
            ->latest()->first();

        $totalDitemukan = SesiTopsis::whereJsonContains('hasil_ranking', [['id' => $band->id]])->count();
        $rankTerakhir   = null;
        $nilaiCiTerakhir = null;

        if ($sesiTerakhir) {
            foreach ($sesiTerakhir->hasil_ranking as $r) {
                if ($r['id'] == $band->id) {
                    $rankTerakhir    = $r['rank'];
                    $nilaiCiTerakhir = $r['ci'];
                    break;
                }
            }
        }

        $tips = $this->generateTips($band);

        return view('band.dashboard', compact(
            'band','sesiTerakhir','totalDitemukan','rankTerakhir','nilaiCiTerakhir','tips'
        ));
    }

    private function generateTips($band): array
    {
        $tips = [];
        $pengalaman = now()->year - $band->tahun_berdiri;

        if ($pengalaman >= 5) {
            $tips[] = ['type' => 'success', 'label' => 'Sudah Baik', 'pesan' => 'Pengalaman '.$pengalaman.' tahun (nilai tinggi)'];
        }
        if ($band->pengikut < 50000) {
            $tips[] = ['type' => 'warning', 'label' => 'Tingkatkan', 'pesan' => 'Tambah pengikut sosial media untuk popularitas lebih tinggi'];
        }
        if ($band->biaya_sewa > 7000000) {
            $tips[] = ['type' => 'danger', 'label' => 'Pertimbangkan', 'pesan' => 'Biaya sewa tinggi mengurangi skor kriteria Cost'];
        }

        return $tips;
    }
}
