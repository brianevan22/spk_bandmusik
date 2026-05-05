{{-- FILE: resources/views/band/dashboard.blade.php --}}
@extends('layouts.app')
@section('title', 'Dashboard Band')
@section('sidebar-subtitle', 'Portal Band Musik')
@section('sidebar-nav')
<div class="text-xs text-gray-600 mb-2 font-semibold tracking-wider">MENU BAND</div>
<a href="{{ route('band.dashboard') }}" class="nav-link {{ request()->routeIs('band.dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
<a href="{{ route('band.profil') }}" class="nav-link {{ request()->routeIs('band.profil*') ? 'active' : '' }}">👤 Profil Saya</a>
<a href="{{ route('band.statistik') }}" class="nav-link {{ request()->routeIs('band.statistik*') ? 'active' : '' }}">📊 Statistik & Ranking</a>
@endsection

@section('content')
<h1 class="text-2xl font-bold text-white mb-1">Selamat Datang, {{ auth()->user()->name }} 🎸</h1>
<p class="text-gray-400 text-sm mb-6">Kelola profil dan pantau performa band Anda dalam sistem rekomendasi TOPSIS.</p>

{{-- Stat Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#2a1a00,#1a1200);border-radius:12px">
        <div class="text-2xl mb-1">🏆</div>
        <div class="text-3xl font-bold" style="color:#F5A623">#{{ $rankTerakhir ?? '—' }}</div>
        <div class="text-gray-400 text-sm mt-1">Peringkat Terakhir</div>
    </div>
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#0d1f3c,#081529);border-radius:12px">
        <div class="text-2xl mb-1">👥</div>
        <div class="text-3xl font-bold" style="color:#60a5fa">{{ $band ? number_format($band->pengikut/1000, 0).'K' : '—' }}</div>
        <div class="text-gray-400 text-sm mt-1">Total Pengikut</div>
    </div>
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#0d2d1f,#081a12);border-radius:12px">
        <div class="text-2xl mb-1">📈</div>
        <div class="text-3xl font-bold" style="color:#4ade80">{{ $nilaiCiTerakhir ?? '—' }}</div>
        <div class="text-gray-400 text-sm mt-1">Nilai Ci Terakhir</div>
    </div>
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#1a0d2a,#110820);border-radius:12px">
        <div class="text-2xl mb-1">🔍</div>
        <div class="text-3xl font-bold" style="color:#a78bfa">{{ $totalDitemukan }}</div>
        <div class="text-gray-400 text-sm mt-1">Ditemukan di Pencarian</div>
    </div>
</div>

@if(!$band)
<div class="p-4 rounded-xl text-sm mb-6" style="background:#0d1f3c;color:#93c5fd;border:1px solid #1e3a5f">
    ℹ️ Profil band Anda belum lengkap.
    <a href="{{ route('band.profil') }}" style="color:#F5A623;font-weight:700">Lengkapi sekarang →</a>
</div>
@else

<div class="p-3 rounded-lg text-sm mb-6 flex items-center gap-2" style="background:#0d1f3c;color:#93c5fd;border:1px solid #1e3a5f">
    ℹ️ Pastikan profil band Anda selalu diperbarui agar tampil optimal dalam hasil rekomendasi TOPSIS.
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Status Profil --}}
    <div class="card p-5">
        <h2 class="font-bold text-white mb-4">Status Profil Band</h2>
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-white"
                style="background:linear-gradient(135deg,#7C3AED,#5b21b6)">
                {{ $band->inisial }}
            </div>
            <div>
                <div class="font-bold text-white">{{ $band->nama_band }}</div>
                <div class="text-xs text-gray-400">{{ $band->genre->nama_genre ?? '-' }} • {{ $band->lokasi }}</div>
                <span class="badge text-xs mt-1" style="background:#052e16;color:#4ade80">✓ Aktif</span>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-3 text-sm mb-4">
            <div>
                <div class="text-gray-500 text-xs">TAHUN BERDIRI</div>
                <div class="text-white font-semibold">{{ $band->tahun_berdiri }} ({{ $band->pengalaman }} Tahun)</div>
            </div>
            <div>
                <div class="text-gray-500 text-xs">BIAYA SEWA</div>
                <div class="font-bold" style="color:#F5A623">Rp {{ number_format($band->biaya_sewa) }}</div>
            </div>
        </div>
        <a href="{{ route('band.profil') }}"
           class="block text-center py-2 rounded-lg text-sm font-bold text-black"
           style="background:#F5A623;text-decoration:none">
            ✏️ Edit Profil
        </a>
    </div>

    {{-- Skor TOPSIS Terakhir --}}
    <div class="card p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-white">Skor TOPSIS Terakhir</h2>
            @if($sesiTerakhir)
            <span class="badge text-xs" style="background:#1a2a1a;color:#4ade80">Sesi #{{ $sesiTerakhir->id }}</span>
            @endif
        </div>
        @if($sesiTerakhir)
        @php
            $mySkor = null;
            foreach ($sesiTerakhir->hasil_ranking as $r) {
                if ($r['id'] == $band->id) { $mySkor = $r; break; }
            }
        @endphp
        @if($mySkor)
        <div class="grid grid-cols-3 gap-2 mb-4">
            <div class="p-3 rounded-lg text-center" style="background:#222">
                <div class="font-bold text-white text-lg">{{ $mySkor['d_plus'] }}</div>
                <div class="text-xs text-gray-500 mt-1">D+ ke A+</div>
            </div>
            <div class="p-3 rounded-lg text-center" style="background:#222">
                <div class="font-bold text-lg" style="color:#4ade80">{{ $mySkor['d_minus'] }}</div>
                <div class="text-xs text-gray-500 mt-1">D− ke A−</div>
            </div>
            <div class="p-3 rounded-lg text-center" style="background:#2a1a00">
                <div class="font-bold text-lg" style="color:#F5A623">{{ $mySkor['ci'] }}</div>
                <div class="text-xs text-gray-500 mt-1">Nilai Ci</div>
            </div>
        </div>
        <div class="text-xs text-gray-400 mb-3">
            Dihitung untuk filter: {{ $sesiTerakhir->filter_genre ?? 'Semua' }} •
            {{ $sesiTerakhir->filter_lokasi ?? 'Semua' }} •
            {{ $sesiTerakhir->filter_budget ? '≤ Rp '.number_format($sesiTerakhir->filter_budget/1000000).' Jt' : 'Semua' }}
        </div>
        <div class="flex justify-between items-center text-sm">
            <span class="text-gray-400">Peringkat dalam sesi ini</span>
            <span class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-black text-xs"
                style="background:#F5A623">{{ $mySkor['rank'] }}</span>
        </div>
        @endif
        <a href="{{ route('band.statistik') }}"
           class="block text-center text-sm py-2 rounded-lg mt-3"
           style="background:#222;color:#E5E7EB;text-decoration:none">
            Lihat Riwayat Lengkap →
        </a>
        @else
        <div class="text-gray-500 text-sm text-center py-4">Belum ada sesi TOPSIS yang mencakup band Anda</div>
        @endif
    </div>

    {{-- Tips --}}
    <div class="card p-5">
        <h2 class="font-bold text-white mb-4">Tips Tingkatkan Ranking</h2>
        @forelse($tips as $tip)
        <div class="p-3 rounded-lg mb-3 text-sm"
            style="background:{{ match($tip['type']) {'success'=>'#052e16','warning'=>'#2a1a00',default=>'#2d0d0d'} }};border:1px solid {{ match($tip['type']) {'success'=>'#166534','warning'=>'#92400e',default=>'#991b1b'} }}">
            <div class="font-bold mb-1" style="color:{{ match($tip['type']) {'success'=>'#4ade80','warning'=>'#fbbf24',default=>'#f87171'} }}">
                {{ match($tip['type']) {'success'=>'✓ ','warning'=>'⬆ ',default=>'⚠ '} }}{{ $tip['label'] }}
            </div>
            <div class="text-gray-300 text-xs">{{ $tip['pesan'] }}</div>
        </div>
        @empty
        <div class="text-gray-500 text-sm">Lengkapi profil untuk mendapat tips.</div>
        @endforelse
    </div>
</div>
@endif
@endsection
