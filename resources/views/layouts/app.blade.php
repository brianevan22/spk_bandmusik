{{-- FILE: resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BandSPK - @yield('title', 'Sistem Pendukung Keputusan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#F5A623',
                        dark: { DEFAULT: '#0F0F0F', 800: '#1A1A1A', 700: '#222222', 600: '#2A2A2A', 500: '#333333' },
                        accent: { green: '#1DB954', purple: '#7C3AED', red: '#EF4444', blue: '#3B82F6' }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #0F0F0F; color: #E5E7EB; font-family: 'Segoe UI', sans-serif; }
        .sidebar { width: 200px; min-height: 100vh; background: #1A1A1A; }
        .main-content { flex: 1; background: #0F0F0F; }
        .card { background: #1A1A1A; border-radius: 12px; }
        .card-stat { border-radius: 12px; }
        .badge { border-radius: 9999px; padding: 2px 10px; font-size: 12px; font-weight: 600; }
        .btn-primary { background: #F5A623; color: #000; font-weight: 700; border-radius: 8px; padding: 10px 20px; cursor: pointer; border: none; transition: opacity 0.2s; }
        .btn-primary:hover { opacity: 0.85; }
        .btn-outline { background: transparent; color: #E5E7EB; border: 1px solid #333; border-radius: 8px; padding: 10px 20px; cursor: pointer; transition: background 0.2s; }
        .btn-outline:hover { background: #222; }
        .input-field { background: #222; border: 1px solid #333; color: #E5E7EB; border-radius: 8px; padding: 10px 14px; width: 100%; outline: none; }
        .input-field:focus { border-color: #F5A623; }
        .nav-link { display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-radius: 8px; color: #9CA3AF; text-decoration: none; transition: all 0.2s; font-size: 14px; }
        .nav-link:hover, .nav-link.active { background: #F5A623; color: #000; font-weight: 600; }
        .table-row:hover { background: #222; }
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .sidebar.open { display: flex; flex-direction: column; position: fixed; z-index: 50; height: 100vh; }
            .mobile-header { display: flex; }
        }
        @media (min-width: 769px) { .mobile-header { display: none; } }
        .slider-input { -webkit-appearance: none; width: 100%; height: 4px; border-radius: 2px; background: #333; outline: none; }
        .slider-input::-webkit-slider-thumb { -webkit-appearance: none; width: 18px; height: 18px; border-radius: 50%; background: #F5A623; cursor: pointer; }
        .progress-bar { height: 6px; border-radius: 3px; background: #F5A623; }
    </style>
    @stack('styles')
</head>
<body>

{{-- Mobile Header --}}
<div class="mobile-header fixed top-0 left-0 right-0 z-40 bg-dark-800 p-4 flex items-center justify-between border-b border-dark-600 md:hidden">
    <div class="flex items-center gap-2">
        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">🎸</div>
        <span class="font-bold text-white">BandSPK</span>
    </div>
    <button onclick="document.getElementById('sidebar').classList.toggle('open')" class="text-white p-1">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</div>

<div class="flex" style="min-height:100vh">
    {{-- Sidebar --}}
    {{-- EDIT: tambah overflow-y:auto dan height:100vh agar tombol Keluar selalu terlihat --}}
    <div id="sidebar" class="sidebar flex flex-col p-4 pt-6 md:pt-4 mt-0 md:mt-0" style="position:fixed;z-index:10;overflow-y:auto;height:100vh;">
        {{-- Logo --}}
        <div class="flex items-center gap-3 mb-6 mt-1">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center text-lg" style="background:linear-gradient(135deg,#F5A623,#E07B00)">🎸</div>
            <div>
                <div class="font-bold text-white text-sm">BandSPK</div>
                <div class="text-xs text-gray-500">@yield('sidebar-subtitle', 'Sistem SPK')</div>
            </div>
        </div>

        {{-- Nav --}}
        @yield('sidebar-nav')

        {{-- EDIT: tambah flex-shrink:0 dan padding-top agar bagian AKUN tidak terpotong --}}
        <div style="margin-top:auto;flex-shrink:0;padding-top:16px;">
            <div class="text-xs text-gray-600 mb-2 font-semibold tracking-wider">AKUN</div>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="nav-link">
                <span>🚪</span> Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </div>

    {{-- Main --}}
    {{-- EDIT: tambah margin-left:200px karena sidebar sekarang position:fixed --}}
    <div class="main-content p-6 md:p-8 mt-14 md:mt-0 flex-1" style="overflow-x:auto;margin-left:200px;">
        {{-- Top Bar --}}
        <div class="flex items-center justify-between mb-6">
            <div></div>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm text-black" style="background:#F5A623">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <span class="text-sm text-gray-400 hidden md:block">{{ auth()->user()->name }}</span>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-4 p-3 rounded-lg text-sm" style="background:#052e16;color:#4ade80;border:1px solid #166534">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 rounded-lg text-sm" style="background:#450a0a;color:#f87171;border:1px solid #991b1b">
                ❌ {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>