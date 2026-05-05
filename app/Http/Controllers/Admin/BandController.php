<?php
// FILE: app/Http/Controllers/Admin/BandController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Band, Genre, User, LogAktivitas};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BandController extends Controller
{
    public function index(Request $request)
    {
        $query = Band::with(['genre', 'user']);

        if ($request->filled('search')) {
            $query->where('nama_band', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('genre')) {
            $query->where('genre_id', $request->genre);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bands  = $query->latest()->paginate(15);
        $genres = Genre::where('status', 'aktif')->get();

        return view('admin.band.index', compact('bands', 'genres'));
    }

    public function create()
    {
        $genres = Genre::where('status', 'aktif')->get();
        return view('admin.band.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_band'    => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:8',
            'genre_id'     => 'required|exists:genres,id',
            'lokasi'       => 'required|string|max:100',
            'tahun_berdiri'=> 'required|integer|min:1900|max:'.now()->year,
            'pengikut'     => 'required|integer|min:0',
            'biaya_sewa'   => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
        ]);

        $user = User::create([
            'name'     => $request->nama_band,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'band',
        ]);

        Band::create([
            'user_id'      => $user->id,
            'genre_id'     => $request->genre_id,
            'nama_band'    => $request->nama_band,
            'lokasi'       => $request->lokasi,
            'tahun_berdiri'=> $request->tahun_berdiri,
            'pengikut'     => $request->pengikut,
            'biaya_sewa'   => $request->biaya_sewa,
            'deskripsi'    => $request->deskripsi,
        ]);

        LogAktivitas::create([
            'user_id'    => auth()->id(),
            'aksi'       => 'Tambah Band',
            'detail'     => 'Band baru: '.$request->nama_band,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.band.index')->with('success', 'Band berhasil ditambahkan!');
    }

    public function edit(Band $band)
    {
        $genres = Genre::where('status', 'aktif')->get();
        return view('admin.band.edit', compact('band', 'genres'));
    }

    public function update(Request $request, Band $band)
    {
        $request->validate([
            'nama_band'    => 'required|string|max:100',
            'genre_id'     => 'required|exists:genres,id',
            'lokasi'       => 'required|string|max:100',
            'tahun_berdiri'=> 'required|integer|min:1900|max:'.now()->year,
            'pengikut'     => 'required|integer|min:0',
            'biaya_sewa'   => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'status'       => 'required|in:aktif,nonaktif',
        ]);

        $band->update($request->only([
            'nama_band','genre_id','lokasi','tahun_berdiri','pengikut','biaya_sewa','deskripsi','status'
        ]));

        LogAktivitas::create([
            'user_id'    => auth()->id(),
            'aksi'       => 'Update Band',
            'detail'     => 'Update band: '.$band->nama_band,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.band.index')->with('success', 'Band berhasil diperbarui!');
    }

    public function destroy(Band $band)
    {
        $nama = $band->nama_band;
        $band->user()->delete(); // cascade
        $band->delete();

        LogAktivitas::create([
            'user_id'    => auth()->id(),
            'aksi'       => 'Hapus Band',
            'detail'     => 'Hapus band: '.$nama,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('admin.band.index')->with('success', 'Band berhasil dihapus!');
    }
}
