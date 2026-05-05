{{-- FILE: resources/views/anggota/dashboard.blade.php --}}
@extends('layouts.app')
@section('title', 'Dashboard Anggota')
@section('sidebar-subtitle', 'Sistem Pendukung Keputusan')

@section('sidebar-nav')
<div class="text-xs text-gray-600 mb-2 font-semibold tracking-wider">MENU UTAMA</div>
<a href="{{ route('anggota.dashboard') }}" class="nav-link {{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}">
    <span>🏠</span> Dashboard
</a>
<a href="{{ route('anggota.filter') }}" class="nav-link {{ request()->routeIs('anggota.filter*') ? 'active' : '' }}">
    <span>🔍</span> Cari & Filter Band
</a>
<a href="{{ route('anggota.filter') }}" class="nav-link {{ request()->routeIs('anggota.hasil*') ? 'active' : '' }}">
    <span>📊</span> Hasil TOPSIS
</a>
<a href="{{ route('anggota.filter') }}" class="nav-link {{ request()->routeIs('anggota.profil-band*') ? 'active' : '' }}">
    <span>🎵</span> Profil Band
</a>
@endsection

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-white">Dashboard Anggota</h1>
    <p class="text-gray-400 text-sm mt-1">Selamat datang! Temukan band terbaik untuk acara Anda.</p>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#2a1a00,#1a1200);border-radius:12px">
        <div class="text-2xl mb-1">🎸</div>
        <div class="text-3xl font-bold text-white">{{ $totalBand }}</div>
        <div class="text-gray-400 text-sm mt-1">Total Band Terdaftar</div>
    </div>
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#0d1f3c,#081529);border-radius:12px">
        <div class="text-2xl mb-1">🎼</div>
        <div class="text-3xl font-bold" style="color:#60a5fa">{{ $totalGenre }}</div>
        <div class="text-gray-400 text-sm mt-1">Genre Tersedia</div>
    </div>
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#0d2d1f,#081a12);border-radius:12px">
        <div class="text-2xl mb-1">📈</div>
        <div class="text-3xl font-bold" style="color:#4ade80">{{ $sesiUser }}</div>
        <div class="text-gray-400 text-sm mt-1">Sesi TOPSIS Anda</div>
    </div>
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#1f1500,#150e00);border-radius:12px">
        <div class="text-2xl mb-1">🏆</div>
        <div class="text-3xl font-bold text-white">
            {{ $rekomendasiTerakhir ? '1' : '-' }}
        </div>
        <div class="text-gray-400 text-sm mt-1">Rekomendasi Terakhir</div>
    </div>
</div>

{{-- Info Banner --}}
<div class="mb-6 p-3 rounded-lg text-sm flex items-center gap-2" style="background:#0d1f3c;color:#93c5fd;border:1px solid #1e3a5f">
    ℹ️ Gunakan menu
    <a href="{{ route('anggota.filter') }}" style="color:#F5A623;font-weight:700">Cari & Filter Band</a>
    untuk memulai proses seleksi dengan algoritma TOPSIS.
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Band Terpopuler --}}
    <div class="lg:col-span-2 card p-5">
        <div class="flex items-center gap-3 mb-4">
            <h2 class="font-bold text-white">Band Terpopuler</h2>
            <span class="badge text-xs" style="background:#1a2a1a;color:#4ade80">Top 5</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-gray-500" style="border-bottom:1px solid #333">
                        <th class="text-left py-2 pr-4">#</th>
                        <th class="text-left py-2 pr-4">NAMA BAND</th>
                        <th class="text-left py-2 pr-4">GENRE</th>
                        <th class="text-left py-2 pr-4">PENGIKUT</th>
                        <th class="text-left py-2">BIAYA</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bandTerpopuler as $band)
                    <tr class="table-row" style="border-bottom:1px solid #1a1a1a">
                        <td class="py-3 pr-4">
                            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold"
                                style="background:{{ $band->rank == 1 ? '#F5A623' : '#333' }};color:{{ $band->rank == 1 ? '#000' : '#fff' }}">
                                {{ $band->rank }}
                            </span>
                        </td>
                        <td class="py-3 pr-4 font-semibold text-white">{{ $band->nama_band }}</td>
                        <td class="py-3 pr-4">
                            <span class="badge" style="background:#1a2a4a;color:#60a5fa">{{ $band->genre->nama_genre ?? '-' }}</span>
                        </td>
                        <td class="py-3 pr-4 text-gray-300">{{ number_format($band->pengikut/1000, 0) }}K</td>
                        <td class="py-3 text-gray-300">Rp {{ number_format($band->biaya_sewa/1000000, 0) }} Jt</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-6 text-center text-gray-500">Belum ada data band</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Riwayat TOPSIS --}}
    <div class="card p-5">
        <h2 class="font-bold text-white mb-4">Riwayat TOPSIS</h2>
        @forelse($riwayatTopsis as $sesi)
        @php $top = $sesi->hasil_ranking[0] ?? null; @endphp
        <div class="mb-4 pb-4" style="border-bottom:1px solid #222">
            <div class="text-xs text-gray-500 mb-1">
                {{ $sesi->filter_genre ?? 'Semua' }} • {{ $sesi->filter_lokasi ?? 'Semua' }}
                • Rp {{ $sesi->filter_budget ? number_format($sesi->filter_budget/1000000, 0).' Jt' : 'Semua' }}
            </div>
            @if($top)
            <div class="text-sm font-semibold" style="color:#F5A623">
                ⬥ {{ $top['nama_band'] }} (Ci: {{ $top['ci'] }})
            </div>
            @endif
        </div>
        @empty
        <div class="text-gray-500 text-sm text-center py-4">Belum ada sesi TOPSIS</div>
        @endforelse

        <a href="{{ route('anggota.filter') }}"
           class="block text-center text-sm py-2 rounded-lg mt-2"
           style="background:#222;color:#E5E7EB;text-decoration:none">
            + Hitung TOPSIS Baru
        </a>
    </div>
</div>
@endsection
