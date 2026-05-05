<?php
// ============================================================
// FILE: app/Http/Controllers/Admin/AnggotaController.php
// ============================================================
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, LogAktivitas};
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users        = $query->withCount('sesiTopsis')->latest()->paginate(15);
        $totalAnggota = User::where('role', 'anggota')->count();
        $totalAktif   = User::where('role', '!=', 'admin')->where('status', 'aktif')->count();
        $totalNonaktif= User::where('role', '!=', 'admin')->where('status', 'nonaktif')->count();

        return view('admin.anggota.index', compact('users','totalAnggota','totalAktif','totalNonaktif'));
    }

    public function edit(User $user)
    {
        return view('admin.anggota.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'email'  => 'required|email|unique:users,email,'.$user->id,
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $user->update($request->only(['name','email','status']));

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil diperbarui!');
    }

    public function toggleStatus(User $user)
    {
        $user->status = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
        $user->save();

        LogAktivitas::create([
            'user_id'    => auth()->id(),
            'aksi'       => 'Toggle Status',
            'detail'     => 'User '.$user->name.' diubah ke '.$user->status,
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', 'Status berhasil diubah!');
    }
}

// ============================================================
// FILE: app/Http/Controllers/Admin/GenreController.php
// ============================================================
// namespace App\Http\Controllers\Admin;
// use App\Http\Controllers\Controller;
// use App\Models\Genre;
// use Illuminate\Http\Request;

// class GenreController extends Controller
// {
//     public function index() {
//         $genres = Genre::withCount('bands')->get();
//         return view('admin.genre.index', compact('genres'));
//     }
//     public function create() { return view('admin.genre.create'); }
//     public function store(Request $request) {
//         $request->validate(['nama_genre' => 'required|string|unique:genres']);
//         Genre::create($request->only('nama_genre'));
//         return redirect()->route('admin.genre.index')->with('success', 'Genre ditambahkan!');
//     }
//     public function edit(Genre $genre) { return view('admin.genre.edit', compact('genre')); }
//     public function update(Request $request, Genre $genre) {
//         $request->validate(['nama_genre'=>'required|string','status'=>'required|in:aktif,tidak_aktif']);
//         $genre->update($request->only(['nama_genre','status']));
//         return redirect()->route('admin.genre.index')->with('success', 'Genre diperbarui!');
//     }
//     public function destroy(Genre $genre) {
//         if ($genre->bands()->count() > 0) {
//             return back()->with('error', 'Genre masih digunakan band, tidak bisa dihapus!');
//         }
//         $genre->delete();
//         return redirect()->route('admin.genre.index')->with('success', 'Genre dihapus!');
//     }
// }
