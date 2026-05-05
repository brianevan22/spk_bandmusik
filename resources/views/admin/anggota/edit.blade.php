{{-- FILE: resources/views/admin/anggota/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Edit Anggota')
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
<div class="mb-2 text-sm text-gray-500">
    <a href="{{ route('admin.anggota.index') }}" style="color:#F5A623">Manajemen Anggota</a> › Edit Anggota
</div>
<h1 class="text-2xl font-bold text-white mb-5">Edit Akun: {{ $user->name }}</h1>

<div class="card p-6" style="max-width:480px">
    @if($errors->any())
    <div class="mb-4 p-3 rounded-lg text-sm" style="background:#450a0a;color:#f87171;border:1px solid #991b1b">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('admin.anggota.update', $user) }}">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="text-xs font-bold tracking-wider text-gray-500">NAMA LENGKAP *</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="input-field mt-1" required>
        </div>
        <div class="mb-4">
            <label class="text-xs font-bold tracking-wider text-gray-500">EMAIL *</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="input-field mt-1" required>
        </div>
        <div class="mb-4">
            <label class="text-xs font-bold tracking-wider text-gray-500">KATEGORI</label>
            <input type="text" value="{{ ucfirst($user->role) }}" class="input-field mt-1" disabled
                style="opacity:0.5;cursor:not-allowed">
        </div>
        <div class="mb-6">
            <label class="text-xs font-bold tracking-wider text-gray-500">STATUS</label>
            <select name="status" class="input-field mt-1">
                <option value="aktif" {{ old('status', $user->status)=='aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status', $user->status)=='nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.anggota.index') }}"
               class="btn-outline px-6 py-2 text-sm" style="text-decoration:none">Batal</a>
            <button type="submit" class="btn-primary px-6 py-2 text-sm">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
