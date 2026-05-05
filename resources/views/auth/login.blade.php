{{-- FILE: resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BandSPK - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #0F0F0F; color: #E5E7EB; font-family: 'Segoe UI', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: #1A1A1A; border-radius: 16px; padding: 40px; width: 100%; max-width: 420px; }
        .input-field { background: #222; border: 1px solid #333; color: #E5E7EB; border-radius: 8px; padding: 12px 14px; width: 100%; outline: none; font-size: 14px; }
        .input-field:focus { border-color: #F5A623; }
        .btn-primary { background: #F5A623; color: #000; font-weight: 700; border-radius: 8px; padding: 12px; width: 100%; cursor: pointer; border: none; font-size: 15px; transition: opacity 0.2s; }
        .btn-primary:hover { opacity: 0.85; }
        .role-btn { background: #222; border: 1px solid #333; color: #9CA3AF; border-radius: 8px; padding: 8px 16px; cursor: pointer; font-size: 13px; transition: all 0.2s; }
        .role-btn.active { background: #F5A623; color: #000; font-weight: 700; border-color: #F5A623; }
        label { font-size: 11px; font-weight: 700; letter-spacing: 1px; color: #6B7280; }
        .password-wrapper { position: relative; }
        .password-wrapper .input-field { padding-right: 44px; }
        .toggle-pw { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6B7280; font-size: 16px; padding: 0; line-height: 1; transition: color 0.2s; }
        .toggle-pw:hover { color: #F5A623; }
    </style>
</head>
<body>
<div style="padding:20px;width:100%;max-width:480px">
    <div class="card">
        {{-- Logo --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl" style="background:linear-gradient(135deg,#F5A623,#E07B00)">🎸</div>
            <div>
                <div class="font-bold text-white">BandSPK</div>
                <div class="text-xs" style="color:#6B7280">Sistem Pendukung Keputusan</div>
            </div>
        </div>

        <h1 class="text-2xl font-bold text-white mb-1">Selamat Datang 👋</h1>
        <p class="text-sm mb-6" style="color:#6B7280">Masuk ke akun Anda untuk melanjutkan</p>

        {{-- Role Selector --}}
        <div class="flex gap-2 mb-6">
            <button type="button" class="role-btn active" onclick="setRole('anggota', this)">👤 Anggota</button>
            <button type="button" class="role-btn" onclick="setRole('band', this)">🎵 Band</button>
            <button type="button" class="role-btn" onclick="setRole('admin', this)">⚙️ Admin</button>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg text-sm" style="background:#450a0a;color:#f87171;border:1px solid #991b1b">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            {{-- Hidden input role — dikirim ke server --}}
            <input type="hidden" name="role" id="role-input" value="{{ old('role', 'anggota') }}">

            <div class="mb-4">
                <label>EMAIL</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com"
                    class="input-field mt-1" required>
            </div>

            <div class="mb-6">
                <label>PASSWORD</label>
                <div class="password-wrapper mt-1">
                    <input type="password" name="password" id="password" placeholder="••••••••" class="input-field" required>
                    <button type="button" class="toggle-pw" onclick="togglePassword('password', 'eye-icon')" title="Tampilkan/Sembunyikan Password">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-primary">Masuk ke Sistem</button>
        </form>

        <p class="text-center text-sm mt-5" style="color:#6B7280">
            Belum punya akun?
            <a href="{{ route('register') }}" style="color:#F5A623;text-decoration:none;font-weight:600">Daftar di sini</a>
        </p>
    </div>
</div>
<script>
function setRole(role, btn) {
    document.querySelectorAll('.role-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('role-input').value = role;
}

document.addEventListener('DOMContentLoaded', function () {
    const oldRole = document.getElementById('role-input').value;
    document.querySelectorAll('.role-btn').forEach(btn => {
        if (btn.getAttribute('onclick').includes(oldRole)) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
});

function togglePassword(fieldId, iconId) {
    const input = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
    const isHidden = input.type === 'password';

    input.type = isHidden ? 'text' : 'password';

    // Ganti icon: mata terbuka ↔ mata dicoret
    icon.innerHTML = isHidden
        ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`
        : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
}
</script>
</body>
</html>