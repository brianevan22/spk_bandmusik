<?php
// FILE: app/Http/Controllers/Anggota/FilterBandController.php
namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\{Band, Genre, SesiTopsis, LogAktivitas};
use App\Services\TopsisService;
use Illuminate\Http\Request;

class FilterBandController extends Controller
{
    public function index()
    {
        $genres      = Genre::where('status', 'aktif')->get();
        $lokasi      = Band::distinct()->pluck('lokasi');
        $savedFilter = session('band_filters', []);
        $savedBobot  = session('band_bobot', [
            'pengalaman'  => 5,
            'popularitas' => 4,
            'biaya'       => 3,
        ]);

        // Jika ada filter tersimpan, langsung tampilkan hasilnya
        $bands = null;
        if (!empty($savedFilter)) {
            $bands = $this->applyFilter($savedFilter);
        }

        return view('anggota.filter', compact('genres', 'lokasi', 'bands', 'savedFilter', 'savedBobot'));
    }

    public function filter(Request $request)
    {
        $request->validate([
            'genre'  => 'nullable|exists:genres,id',
            'lokasi' => 'nullable|string',
            'budget' => 'nullable|integer|min:0',
        ]);

        $filterData = $request->only(['genre', 'lokasi', 'budget']);

        // Simpan filter ke session
        session(['band_filters' => $filterData]);

        $bands       = $this->applyFilter($filterData);
        $genres      = Genre::where('status', 'aktif')->get();
        $lokasi      = Band::distinct()->pluck('lokasi');
        $savedFilter = $filterData;
        $savedBobot  = session('band_bobot', [
            'pengalaman'  => 5,
            'popularitas' => 4,
            'biaya'       => 3,
        ]);

        return view('anggota.filter', compact('bands', 'genres', 'lokasi', 'savedFilter', 'savedBobot'));
    }

    public function reset()
    {
        session()->forget(['band_filters', 'band_bobot']);
        return redirect()->route('anggota.filter');
    }

    public function jalankanTopsis(Request $request)
    {
        $request->validate([
            'band_ids'           => 'required|array|min:2',
            'band_ids.*'         => 'exists:bands,id',
            'bobot_pengalaman'   => 'required|integer|min:1|max:10',
            'bobot_popularitas'  => 'required|integer|min:1|max:10',
            'bobot_biaya'        => 'required|integer|min:1|max:10',
            'filter_genre'       => 'nullable|string',
            'filter_lokasi'      => 'nullable|string',
            'filter_budget'      => 'nullable|integer',
        ]);

        // Simpan bobot ke session agar tetap tampil saat kembali ke filter
        session(['band_bobot' => [
            'pengalaman'  => $request->bobot_pengalaman,
            'popularitas' => $request->bobot_popularitas,
            'biaya'       => $request->bobot_biaya,
        ]]);

        $bands = Band::with('genre')->whereIn('id', $request->band_ids)->get();

        $bandsData = $bands->map(fn($b) => [
            'id'         => $b->id,
            'nama_band'  => $b->nama_band,
            'genre'      => $b->genre->nama_genre ?? '-',
            'lokasi'     => $b->lokasi,
            'pengalaman' => now()->year - $b->tahun_berdiri,
            'pengikut'   => $b->pengikut,
            'biaya_sewa' => $b->biaya_sewa,
        ])->toArray();

        $bobot = [
            'pengalaman'  => $request->bobot_pengalaman,
            'popularitas' => $request->bobot_popularitas,
            'biaya'       => $request->bobot_biaya,
        ];

        $service = new TopsisService();
        $hasil   = $service->hitung($bandsData, $bobot);

        // Simpan sesi
        $sesi = SesiTopsis::create([
            'user_id'           => auth()->id(),
            'filter_genre'      => $request->filter_genre,
            'filter_lokasi'     => $request->filter_lokasi,
            'filter_budget'     => $request->filter_budget,
            'bobot_pengalaman'  => $request->bobot_pengalaman,
            'bobot_popularitas' => $request->bobot_popularitas,
            'bobot_biaya'       => $request->bobot_biaya,
            'hasil_ranking'     => $hasil['ranking'],
        ]);

        LogAktivitas::create([
            'user_id'    => auth()->id(),
            'aksi'       => 'Hitung TOPSIS',
            'detail'     => 'Genre:'.($request->filter_genre ?? 'Semua').', Kota:'.($request->filter_lokasi ?? 'Semua').', Budget:'.($request->filter_budget ? 'Rp '.number_format($request->filter_budget) : 'Semua'),
            'ip_address' => $request->ip(),
        ]);

        // Simpan sesi_id terakhir ke session Laravel
        session(['last_sesi_id' => $sesi->id]);

        return redirect()->route('anggota.hasil', $sesi->id);
    }

    // ─── Helper: terapkan filter ke query Band ───────────────────────────────
    private function applyFilter(array $filters)
    {
        $query = Band::with('genre')->where('status', 'aktif');

        if (!empty($filters['genre'])) {
            $query->where('genre_id', $filters['genre']);
        }
        if (!empty($filters['lokasi'])) {
            $query->where('lokasi', $filters['lokasi']);
        }
        if (!empty($filters['budget']) && is_numeric($filters['budget'])) {
            $query->where('biaya_sewa', '<=', $filters['budget']);
        }

        return $query->get();
    }
}