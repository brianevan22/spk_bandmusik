<?php
// FILE: app/Services/TopsisService.php
namespace App\Services;

class TopsisService
{
    /**
     * Hitung TOPSIS
     * @param array $bands    - array of band data [id, nama, pengalaman, pengikut, biaya_sewa, ...]
     * @param array $bobot    - [pengalaman, popularitas, biaya]
     * @return array          - sorted by ci desc
     */
    public function hitung(array $bands, array $bobot): array
    {
        if (empty($bands)) return [];

        // Kriteria: pengalaman (benefit+), pengikut (benefit+), biaya_sewa (cost-)
        $kriteria = ['pengalaman', 'pengikut', 'biaya_sewa'];
        $tipe     = ['benefit', 'benefit', 'cost'];
        $w        = [
            $bobot['pengalaman']  / array_sum($bobot),
            $bobot['popularitas'] / array_sum($bobot),
            $bobot['biaya']       / array_sum($bobot),
        ];

        // Step 1: Normalisasi
        $denominators = [];
        foreach ($kriteria as $i => $k) {
            $sum = 0;
            foreach ($bands as $b) {
                $sum += pow($b[$k], 2);
            }
            $denominators[$i] = sqrt($sum) ?: 1;
        }

        $normalized = [];
        foreach ($bands as $b) {
            $row = [];
            foreach ($kriteria as $i => $k) {
                $row[$k] = $b[$k] / $denominators[$i];
            }
            $normalized[] = $row;
        }

        // Step 2: Bobot ternormalisasi
        $weighted = [];
        foreach ($normalized as $row) {
            $wRow = [];
            foreach ($kriteria as $i => $k) {
                $wRow[$k] = $row[$k] * $w[$i];
            }
            $weighted[] = $wRow;
        }

        // Step 3: Solusi Ideal Positif (A+) dan Negatif (A-)
        $aPlus  = [];
        $aMinus = [];
        foreach ($kriteria as $i => $k) {
            $vals = array_column($weighted, $k);
            if ($tipe[$i] === 'benefit') {
                $aPlus[$k]  = max($vals);
                $aMinus[$k] = min($vals);
            } else {
                $aPlus[$k]  = min($vals);
                $aMinus[$k] = max($vals);
            }
        }

        // Step 4: Jarak ke A+ dan A-
        $result = [];
        foreach ($bands as $idx => $b) {
            $dPlus  = 0;
            $dMinus = 0;
            foreach ($kriteria as $i => $k) {
                $dPlus  += pow($weighted[$idx][$k] - $aPlus[$k], 2);
                $dMinus += pow($weighted[$idx][$k] - $aMinus[$k], 2);
            }
            $dPlus  = sqrt($dPlus);
            $dMinus = sqrt($dMinus);
            $ci     = ($dPlus + $dMinus) > 0 ? $dMinus / ($dPlus + $dMinus) : 0;

            $result[] = array_merge($b, [
                'd_plus'  => round($dPlus, 3),
                'd_minus' => round($dMinus, 3),
                'ci'      => round($ci, 3),
            ]);
        }

        // Sort by CI desc
        usort($result, fn($a, $b) => $b['ci'] <=> $a['ci']);

        // Tambah rank
        foreach ($result as $i => &$r) {
            $r['rank'] = $i + 1;
        }

        return [
            'ranking'  => $result,
            'a_plus'   => $aPlus,
            'a_minus'  => $aMinus,
        ];
    }
}
