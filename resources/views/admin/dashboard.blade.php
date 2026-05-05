{{-- FILE: resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('sidebar-subtitle', 'Panel Administrator')

@section('sidebar-nav')
<div class="text-xs text-gray-600 mb-2 font-semibold tracking-wider">ADMIN MENU</div>
<a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard Admin</a>
<a href="{{ route('admin.band.index') }}" class="nav-link {{ request()->routeIs('admin.band*') ? 'active' : '' }}">🎵 Manajemen Band</a>
<a href="{{ route('admin.anggota.index') }}" class="nav-link {{ request()->routeIs('admin.anggota*') ? 'active' : '' }}">👥 Manajemen Anggota</a>
<a href="{{ route('admin.genre.index') }}" class="nav-link {{ request()->routeIs('admin.genre*') ? 'active' : '' }}">🎼 Manajemen Genre</a>
<a href="{{ route('admin.log.index') }}" class="nav-link {{ request()->routeIs('admin.log*') ? 'active' : '' }}">📋 Log Aktivitas</a>
@endsection

@section('content')
<h1 class="text-2xl font-bold text-white mb-1">Dashboard Administrator</h1>
<p class="text-gray-400 text-sm mb-6">Pantau dan kelola seluruh data sistem SPK Band Musik.</p>

{{-- Stat Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#2a1a00,#1a1200);border-radius:12px">
        <div class="text-2xl mb-1">🎸</div>
        <div class="text-3xl font-bold text-white">{{ $totalBand }}</div>
        <div class="text-gray-400 text-sm mt-1">Total Band</div>
    </div>
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#0d1f3c,#081529);border-radius:12px">
        <div class="text-2xl mb-1">👥</div>
        <div class="text-3xl font-bold" style="color:#60a5fa">{{ $totalAnggota }}</div>
        <div class="text-gray-400 text-sm mt-1">Total Anggota</div>
    </div>
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#0d2d1f,#081a12);border-radius:12px">
        <div class="text-2xl mb-1">📈</div>
        <div class="text-3xl font-bold" style="color:#4ade80">{{ $sesiTopsis }}</div>
        <div class="text-gray-400 text-sm mt-1">Sesi TOPSIS</div>
    </div>
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#1a0d2a,#110820);border-radius:12px">
        <div class="text-2xl mb-1">🎼</div>
        <div class="text-3xl font-bold" style="color:#a78bfa">{{ $genreAktif }}</div>
        <div class="text-gray-400 text-sm mt-1">Genre Aktif</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Band Terbaru --}}
    <div class="lg:col-span-2 card p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-white">Band Terbaru</h2>
            <a href="{{ route('admin.band.create') }}"
               class="px-4 py-2 rounded-lg text-xs font-bold text-black"
               style="background:#F5A623;text-decoration:none">
                + Tambah Band
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-gray-500 text-xs" style="border-bottom:1px solid #333">
                        <th class="text-left py-2 pr-4">NAMA BAND</th>
                        <th class="text-left py-2 pr-4">GENRE</th>
                        <th class="text-left py-2 pr-4">STATUS</th>
                        <th class="text-left py-2 pr-4">TERDAFTAR</th>
                        <th class="text-left py-2">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bandTerbaru as $band)
                    <tr class="table-row" style="border-bottom:1px solid #1a1a1a">
                        <td class="py-3 pr-4 font-semibold text-white">{{ $band->nama_band }}</td>
                        <td class="py-3 pr-4">
                            <span class="badge" style="background:#1a2a4a;color:#60a5fa">{{ $band->genre->nama_genre ?? '-' }}</span>
                        </td>
                        <td class="py-3 pr-4">
                            <span class="badge" style="background:{{ $band->status == 'aktif' ? '#052e16' : '#450a0a' }};color:{{ $band->status == 'aktif' ? '#4ade80' : '#f87171' }}">
                                {{ ucfirst($band->status) }}
                            </span>
                        </td>
                        <td class="py-3 pr-4 text-gray-400 text-xs">{{ $band->created_at->diffForHumans() }}</td>
                        <td class="py-3">
                            <a href="{{ route('admin.band.edit', $band) }}"
                               class="px-3 py-1 rounded text-xs font-semibold"
                               style="background:#222;color:#E5E7EB;text-decoration:none;border:1px solid #333">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-6 text-center text-gray-500">Belum ada band</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Log Terbaru --}}
    <div class="card p-5">
        <h2 class="font-bold text-white mb-4">Log Terbaru</h2>
        @forelse($logTerbaru as $log)
        <div class="flex items-start gap-3 mb-4 pb-4" style="border-bottom:1px solid #1a1a1a">
            <span class="w-2 h-2 rounded-full mt-2 flex-shrink-0"
                style="background:{{ match($log->aksi) {
                    'Login'        => '#4ade80',
                    'Hitung TOPSIS'=> '#F5A623',
                    'Tambah Band'  => '#60a5fa',
                    'Logout'       => '#f87171',
                    default        => '#a78bfa'
                } }}"></span>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-semibold text-white">{{ $log->aksi }}</div>
                <div class="text-xs text-gray-500 truncate">{{ $log->user?->email ?? '-' }} — {{ $log->created_at->diffForHumans() }}</div>
            </div>
        </div>
        @empty
        <div class="text-gray-500 text-sm text-center py-4">Belum ada log</div>
        @endforelse

        <a href="{{ route('admin.log.index') }}"
           class="block text-center text-sm py-2 rounded-lg mt-2"
           style="background:#222;color:#E5E7EB;text-decoration:none">
            Lihat Semua Log →
        </a>
    </div>
</div>
@endsection
