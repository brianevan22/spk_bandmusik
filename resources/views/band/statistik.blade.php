{{-- FILE: resources/views/band/statistik.blade.php --}}
@extends('layouts.app')
@section('title', 'Statistik & Ranking')
@section('sidebar-subtitle', 'Portal Band Musik')
@section('sidebar-nav')
<div class="text-xs text-gray-600 mb-2 font-semibold tracking-wider">MENU BAND</div>
<a href="{{ route('band.dashboard') }}" class="nav-link">🏠 Dashboard</a>
<a href="{{ route('band.profil') }}" class="nav-link">👤 Profil Saya</a>
<a href="{{ route('band.statistik') }}" class="nav-link active">📊 Statistik & Ranking</a>
@endsection
@section('content')
<div class="mb-2 text-sm text-gray-500">
    <a href="{{ route('band.dashboard') }}" style="color:#F5A623">Dashboard</a> › Statistik & Ranking
</div>
<h1 class="text-2xl font-bold text-white mb-1">Statistik & Riwayat Ranking TOPSIS</h1>
<p class="text-gray-400 text-sm mb-5">Pantau performa band Anda dari waktu ke waktu dalam seluruh sesi perhitungan TOPSIS.</p>

{{-- Stat Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#2a1a00,#1a1200);border-radius:12px">
        <div class="text-2xl mb-1">🏆</div>
        <div class="text-3xl font-bold text-white">{{ $totalDitemukan }}</div>
        <div class="text-gray-400 text-sm mt-1">Total Ditemukan</div>
    </div>
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#1a2a00,#0d1a00);border-radius:12px">
        <div class="text-2xl mb-1">🥇</div>
        <div class="text-3xl font-bold" style="color:#F5A623">{{ $kaliRank1 }}</div>
        <div class="text-gray-400 text-sm mt-1">Kali Rank #1</div>
    </div>
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#1a0d2a,#110820);border-radius:12px">
        <div class="text-2xl mb-1">📝</div>
        <div class="text-3xl font-bold" style="color:#a78bfa">{{ $rataRataCi }}</div>
        <div class="text-gray-400 text-sm mt-1">Rata-rata Ci</div>
    </div>
    <div class="card-stat p-5" style="background:linear-gradient(135deg,#1f1500,#150e00);border-radius:12px">
        <div class="text-2xl mb-1">⭐</div>
        <div class="text-3xl font-bold text-white">{{ $rataRataRank }}</div>
        <div class="text-gray-400 text-sm mt-1">Rata-rata Rank</div>
    </div>
</div>

{{-- Tabel Riwayat --}}
<div class="card p-5">
    <div class="flex items-center gap-3 mb-4">
        <h2 class="font-bold text-white">Riwayat Sesi TOPSIS</h2>
        <span class="badge text-xs" style="background:#1a2a1a;color:#4ade80">{{ $totalDitemukan }} sesi</span>
    </div>
    @if($sesiList->count() == 0)
    <div class="text-center py-10 text-gray-500">
        <div class="text-4xl mb-3">📊</div>
        <p>Band Anda belum pernah muncul dalam hasil perhitungan TOPSIS.</p>
        <p class="text-sm mt-1">Pastikan profil sudah lengkap dan diperbarui.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-gray-500 text-xs" style="border-bottom:1px solid #333">
                    <th class="text-left py-2 pr-4">SESI</th>
                    <th class="text-left py-2 pr-4">TANGGAL</th>
                    <th class="text-left py-2 pr-4">FILTER YANG DIGUNAKAN</th>
                    <th class="text-left py-2 pr-4">D+</th>
                    <th class="text-left py-2 pr-4">D−</th>
                    <th class="text-left py-2 pr-4">NILAI CI</th>
                    <th class="text-left py-2">PERINGKAT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sesiList as $sesi)
                @php
                    $mySkor = null;
                    foreach ($sesi->hasil_ranking as $r) {
                        if ($r['id'] == $band->id) { $mySkor = $r; break; }
                    }
                @endphp
                @if($mySkor)
                <tr class="table-row" style="border-bottom:1px solid #1a1a1a">
                    <td class="py-3 pr-4 text-gray-400">#{{ $sesi->id }}</td>
                    <td class="py-3 pr-4 text-gray-300">{{ $sesi->created_at->format('d/m/Y') }}</td>
                    <td class="py-3 pr-4 text-gray-400 text-xs">
                        {{ $sesi->filter_genre ?? 'Semua' }} •
                        {{ $sesi->filter_lokasi ?? 'Semua' }} •
                        {{ $sesi->filter_budget ? '≤ Rp '.number_format($sesi->filter_budget/1000000).' Jt' : 'Semua' }}
                    </td>
                    <td class="py-3 pr-4 text-gray-300">{{ $mySkor['d_plus'] }}</td>
                    <td class="py-3 pr-4" style="color:#4ade80">{{ $mySkor['d_minus'] }}</td>
                    <td class="py-3 pr-4 font-bold" style="color:#F5A623">{{ $mySkor['ci'] }}</td>
                    <td class="py-3">
                        <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold"
                            style="background:{{ $mySkor['rank']==1?'#F5A623':'#333' }};color:{{ $mySkor['rank']==1?'#000':'#fff' }}">
                            {{ $mySkor['rank'] }}
                        </span>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $sesiList->links() }}</div>
    @endif
</div>
@endsection
