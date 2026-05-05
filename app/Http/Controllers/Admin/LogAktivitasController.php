<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user');

        if ($request->filled('aksi')) {
            $query->where('aksi', $request->aksi);
        }
        if ($request->filled('search')) {
            $query->whereHas('user', fn($q) => $q->where('email', 'like', '%'.$request->search.'%'));
        }

        $logs        = $query->latest()->paginate(20);
        $aksiList    = LogAktivitas::distinct()->pluck('aksi');
        $totalLog    = LogAktivitas::count();
        $logHariIni  = LogAktivitas::whereDate('created_at', today())->count();

        return view('admin.log.index', compact('logs','aksiList','totalLog','logHariIni'));
    }
}
