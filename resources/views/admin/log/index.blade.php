{{-- FILE: resources/views/admin/log/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Log Aktivitas')
@section('sidebar-subtitle', 'Panel Administrator')
@section('sidebar-nav')
<div class="text-xs text-gray-600 mb-2 font-semibold tracking-wider">ADMIN MENU</div>
<a href="{{ route('admin.dashboard') }}" class="nav-link">📊 Dashboard Admin</a>
<a href="{{ route('admin.band.index') }}" class="nav-link">🎵 Manajemen Band</a>
<a href="{{ route('admin.anggota.index') }}" class="nav-link">👥 Manajemen Anggota</a>
<a href="{{ route('admin.genre.index') }}" class="nav-link">🎼 Manajemen Genre</a>
<a href="{{ route('admin.log.index') }}" class="nav-link active">📋 Log Aktivitas</a>
@endsection
@section('content')
<h1 class="text-2xl font-bold text-white mb-1">Log Aktivitas Sistem</h1>
<p class="text-gray-400 text-sm mb-5">Audit trail seluruh aktivitas pengguna dalam sistem. Log tidak dapat dihapus.</p>

<div class="card p-5">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-gray-500 text-xs" style="border-bottom:1px solid #333">
                    <th class="text-left py-2 pr-4">TIMESTAMP</th>
                    <th class="text-left py-2 pr-4">PENGGUNA</th>
                    <th class="text-left py-2 pr-4">PERAN</th>
                    <th class="text-left py-2 pr-4">AKSI</th>
                    <th class="text-left py-2 pr-4">DETAIL</th>
                    <th class="text-left py-2">IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="table-row" style="border-bottom:1px solid #1a1a1a">
                    <td class="py-3 pr-4 text-gray-400 text-xs whitespace-nowrap">
                        {{ $log->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="py-3 pr-4 text-gray-300 text-xs">{{ $log->user?->email ?? '-' }}</td>
                    <td class="py-3 pr-4">
                        @if($log->user)
                        <span class="badge text-xs"
                            style="background:{{ match($log->user->role) {'admin'=>'#1a0d2a','band'=>'#0d1f3c',default=>'#2a1a00'} }};color:{{ match($log->user->role) {'admin'=>'#a78bfa','band'=>'#60a5fa',default=>'#F5A623'} }}">
                            {{ ucfirst($log->user->role) }}
                        </span>
                        @endif
                    </td>
                    <td class="py-3 pr-4">
                        <span class="flex items-center gap-2 text-sm font-semibold text-white">
                            <span class="w-2 h-2 rounded-full"
                                style="background:{{ match($log->aksi) {
                                    'Login'         => '#4ade80',
                                    'Logout'        => '#f87171',
                                    'Hitung TOPSIS' => '#F5A623',
                                    'Tambah Band'   => '#60a5fa',
                                    default         => '#a78bfa'
                                } }}"></span>
                            {{ $log->aksi }}
                        </span>
                    </td>
                    <td class="py-3 pr-4 text-gray-400 text-xs">{{ $log->detail }}</td>
                    <td class="py-3 text-gray-500 text-xs">{{ $log->ip_address }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="py-8 text-center text-gray-500">Belum ada log aktivitas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $logs->links() }}</div>
</div>
@endsection
