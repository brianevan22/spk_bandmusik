<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::withCount('bands')->get();
        return view('admin.genre.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genre.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_genre' => 'required|string|max:100|unique:genres,nama_genre',
        ]);

        Genre::create([
            'nama_genre' => $request->nama_genre,
            'status'     => 'aktif',
        ]);

        LogAktivitas::create([
            'user_id'    => auth()->id(),
            'aksi'       => 'Tambah Genre',
            'detail'     => 'Genre baru: '.$request->nama_genre,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.genre.index')->with('success', 'Genre berhasil ditambahkan!');
    }

    public function edit(Genre $genre)
    {
        return view('admin.genre.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'nama_genre' => 'required|string|max:100|unique:genres,nama_genre,'.$genre->id,
            'status'     => 'required|in:aktif,nonaktif',
        ]);

        $genre->update($request->only(['nama_genre', 'status']));

        LogAktivitas::create([
            'user_id'    => auth()->id(),
            'aksi'       => 'Update Genre',
            'detail'     => 'Update genre: '.$genre->nama_genre,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.genre.index')->with('success', 'Genre berhasil diperbarui!');
    }

    public function destroy(Genre $genre)
    {
        if ($genre->bands()->count() > 0) {
            return back()->with('error', 'Genre masih digunakan oleh '.$genre->bands()->count().' band, tidak bisa dihapus!');
        }

        $nama = $genre->nama_genre;
        $genre->delete();

        LogAktivitas::create([
            'user_id'    => auth()->id(),
            'aksi'       => 'Hapus Genre',
            'detail'     => 'Hapus genre: '.$nama,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('admin.genre.index')->with('success', 'Genre berhasil dihapus!');
    }
}
