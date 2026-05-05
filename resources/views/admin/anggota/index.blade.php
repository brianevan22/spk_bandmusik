{{-- FILE: resources/views/admin/anggota/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Manajemen Anggota')
@section('sidebar-subtitle', 'Panel Administrator')

@section('sidebar-nav')
<div class="text-xs text-gray-600 mb-2 font-semibold tracking-wider">ADMIN MENU</div>
<a href="{{ route('admin.dashboard') }}" class="nav-link">📊 Dashboard Admin</a>
<a href="{{ route('admin.band.index') }}" class="nav-link">🎵 Manajemen Band</a>
<a href="{{ route('admin.anggota.index') }}" class="nav-link active">👥 Manajemen Anggota</a>
<a href="{{ route('admin.genre.index') }}" class="nav-link">🎼 Manajemen Genre</a>
<a href="{{ route('admin.log.index') }}" class="nav-link">📋 Log Aktivitas</a>
@endsection

@section('content')
<h1 class="text-2xl font-bold text-white mb-1">Manajemen Anggota</h1>
<p class="text-gray-400 text-sm mb-5">Kelola data akun anggota dan band yang terdaftar dalam sistem.</p>

{{-- Stat Cards --}}
<div class="grid grid-cols-3 gap-4 mb-5">
    <div class="card-stat p-4" style="background:linear-gradient(135deg,#2a1a00,#1a1200);border-radius:12px">
        <div class="text-2xl font-bold text-white">{{ $totalAnggota }}</div>
        <div class="text-gray-400 text-xs mt-1">Total Anggota</div>
    </div>
    <div class="card-stat p-4" style="background:linear-gradient(135deg,#0d2d1f,#081a12);border-radius:12px">
        <div class="text-2xl font-bold" style="color:#4ade80">{{ $totalAktif }}</div>
        <div class="text-gray-400 text-xs mt-1">Akun Aktif</div>
    </div>
    <div class="card-stat p-4" style="background:linear-gradient(135deg,#2d0d0d,#1a0808);border-radius:12px">
        <div class="text-2xl font-bold" style="color:#f87171">{{ $totalNonaktif }}</div>
        <div class="text-gray-400 text-xs mt-1">Akun Dinonaktifkan</div>
    </div>
</div>

{{-- Search --}}
<form method="GET" class="flex flex-wrap gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="input-field" style="max-width:250px">
    <select name="role" class="input-field" style="max-width:150px">
        <option value="">Semua Kategori</option>
        <option value="anggota" {{ request('role')=='anggota'?'selected':'' }}>Anggota</option>
        <option value="band" {{ request('role')=='band'?'selected':'' }}>Band</option>
    </select>
    <select name="status" class="input-field" style="max-width:150px">
        <option value="">Semua Status</option>
        <option value="aktif" {{ request('status')=='aktif'?'selected':'' }}>Aktif</option>
        <option value="nonaktif" {{ request('status')=='nonaktif'?'selected':'' }}>Nonaktif</option>
    </select>
    <button type="submit" class="btn-primary px-4 py-2 text-sm">Filter</button>
</form>

<div class="card p-5">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-gray-500 text-xs" style="border-bottom:1px solid #333">
                    <th class="text-left py-2 pr-4">#ID</th>
                    <th class="text-left py-2 pr-4">NAMA</th>
                    <th class="text-left py-2 pr-4">EMAIL</th>
                    <th class="text-left py-2 pr-4">KATEGORI</th>
                    <th class="text-left py-2 pr-4">BERGABUNG</th>
                    <th class="text-left py-2 pr-4">SESI TOPSIS</th>
                    <th class="text-left py-2 pr-4">STATUS</th>
                    <th class="text-left py-2">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="table-row" style="border-bottom:1px solid #1a1a1a">
                    <td class="py-3 pr-4 text-gray-500 text-xs">#{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="py-3 pr-4 font-semibold text-white">{{ $user->name }}</td>
                    <td class="py-3 pr-4 text-gray-300 text-xs">{{ $user->email }}</td>
                    <td class="py-3 pr-4">
                        <span class="badge" style="background:{{ $user->role=='band'?'#1a2a4a':'#2a1a00' }};color:{{ $user->role=='band'?'#60a5fa':'#F5A623' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="py-3 pr-4 text-gray-400 text-xs">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="py-3 pr-4 text-gray-300">{{ $user->sesi_topsis_count ?? '—' }}</td>
                    <td class="py-3 pr-4">
                        <span class="badge" style="background:{{ $user->status=='aktif'?'#052e16':'#450a0a' }};color:{{ $user->status=='aktif'?'#4ade80':'#f87171' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="py-3 flex gap-2">
                        <a href="{{ route('admin.anggota.edit', $user) }}"
                           class="w-8 h-8 rounded flex items-center justify-center text-sm"
                           style="background:#222;border:1px solid #333;text-decoration:none">✏️</a>
                        <form method="POST" action="{{ route('admin.anggota.toggle', $user) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="w-8 h-8 rounded text-sm"
                                style="background:#1a2a1a;border:1px solid #166534">
                                {{ $user->status == 'aktif' ? '🔒' : '🔓' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="py-8 text-center text-gray-500">Tidak ada data pengguna</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
