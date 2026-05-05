<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BandSPK — Sistem Pendukung Keputusan Pemilihan Band</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0F0F0F; color: #E5E7EB; font-family: 'Segoe UI', sans-serif; }
        .btn-primary { background: #F5A623; color: #000; font-weight: 700; border-radius: 8px; padding: 12px 28px; cursor: pointer; border: none; transition: opacity 0.2s; text-decoration: none; display: inline-block; }
        .btn-primary:hover { opacity: 0.85; }
        .btn-outline { background: transparent; color: #E5E7EB; border: 1px solid #444; border-radius: 8px; padding: 12px 28px; cursor: pointer; transition: background 0.2s; text-decoration: none; display: inline-block; }
        .btn-outline:hover { background: #222; }
        .card { background: #1A1A1A; border-radius: 16px; border: 1px solid #2a2a2a; }
        .badge { border-radius: 9999px; padding: 4px 12px; font-size: 12px; font-weight: 600; display: inline-block; }
        .glow { box-shadow: 0 0 60px rgba(245, 166, 35, 0.15); }
        .hero-gradient { background: radial-gradient(ellipse at top, #1a1000 0%, #0F0F0F 60%); }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        .float { animation: float 3s ease-in-out infinite; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav style="position:fixed;top:0;left:0;right:0;z-index:50;background:rgba(15,15,15,0.9);backdrop-filter:blur(12px);border-bottom:1px solid #1a1a1a">
    <div style="max-width:1100px;margin:0 auto;padding:16px 24px;display:flex;align-items:center;justify-content:space-between">
        <div style="display:flex;align-items:center;gap:12px">
            <div style="width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,#F5A623,#E07B00);display:flex;align-items:center;justify-content:center;font-size:18px">🎸</div>
            <div>
                <div style="font-weight:700;color:#fff">BandSPK</div>
                <div style="font-size:11px;color:#666">Sistem Pendukung Keputusan</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:12px">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary" style="padding:8px 20px;font-size:14px">Dashboard →</a>
            @else
                <a href="{{ route('login') }}" class="btn-outline" style="padding:8px 20px;font-size:14px">Masuk</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-primary" style="padding:8px 20px;font-size:14px">Daftar Gratis</a>
                @endif
            @endauth
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero-gradient" style="min-height:100vh;display:flex;align-items:center;padding:100px 0 60px">
    <div style="max-width:1100px;margin:0 auto;padding:0 24px;width:100%">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center">
            <div>
                <span class="badge" style="background:#2a1a00;color:#F5A623;border:1px solid #3a2800;margin-bottom:20px">
                    🎵 Algoritma TOPSIS
                </span>
                <h1 style="font-size:48px;font-weight:800;color:#fff;line-height:1.15;margin:16px 0 20px">
                    Temukan Band<br>
                    <span style="color:#F5A623">Terbaik</span> untuk<br>
                    Acara Anda
                </h1>
                <p style="color:#9CA3AF;font-size:18px;line-height:1.7;margin-bottom:32px">
                    Sistem Pendukung Keputusan berbasis metode TOPSIS untuk membantu Anda memilih band musik yang paling sesuai dengan kebutuhan, budget, dan preferensi acara.
                </p>
                <div style="display:flex;gap:16px;flex-wrap:wrap">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">Mulai Sekarang →</a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary">Mulai Gratis →</a>
                        <a href="{{ route('login') }}" class="btn-outline">Sudah Punya Akun</a>
                    @endauth
                </div>
                <div style="display:flex;gap:0;margin-top:40px">
                    <div>
                        <div style="font-size:24px;font-weight:800;color:#F5A623">12+</div>
                        <div style="font-size:13px;color:#6B7280">Band Terdaftar</div>
                    </div>
                    <div style="border-left:1px solid #333;padding-left:24px;margin-left:24px">
                        <div style="font-size:24px;font-weight:800;color:#fff">8+</div>
                        <div style="font-size:13px;color:#6B7280">Genre Musik</div>
                    </div>
                    <div style="border-left:1px solid #333;padding-left:24px;margin-left:24px">
                        <div style="font-size:24px;font-weight:800;color:#fff">3</div>
                        <div style="font-size:13px;color:#6B7280">Kriteria TOPSIS</div>
                    </div>
                </div>
            </div>

            <!-- Illustration Card -->
            <div style="display:flex;justify-content:center">
                <div class="float" style="position:relative">
                    <div class="card glow" style="width:320px;padding:24px">
                        <div style="font-size:11px;font-weight:700;letter-spacing:0.1em;color:#F5A623;margin-bottom:16px">HASIL RANKING TOPSIS</div>
                        <!-- Rank 1 -->
                        <div style="display:flex;align-items:center;gap:12px;background:#2a1a00;border-radius:12px;padding:12px;margin-bottom:10px">
                            <span style="width:28px;height:28px;border-radius:50%;background:#F5A623;color:#000;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0">1</span>
                            <div style="flex:1">
                                <div style="font-weight:600;color:#fff;font-size:14px">Gemuruh</div>
                                <div style="font-size:12px;color:#666">Rock</div>
                            </div>
                            <div style="text-align:right">
                                <div style="font-weight:700;font-size:14px;color:#F5A623">0.847</div>
                                <div style="font-size:11px;color:#666">Ci</div>
                            </div>
                        </div>
                        <!-- Rank 2 -->
                        <div style="display:flex;align-items:center;gap:12px;background:#222;border-radius:12px;padding:12px;margin-bottom:10px">
                            <span style="width:28px;height:28px;border-radius:50%;background:#333;color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0">2</span>
                            <div style="flex:1">
                                <div style="font-weight:600;color:#fff;font-size:14px">Sinaraya</div>
                                <div style="font-size:12px;color:#666">Pop</div>
                            </div>
                            <div style="text-align:right">
                                <div style="font-weight:700;font-size:14px;color:#F5A623">0.712</div>
                                <div style="font-size:11px;color:#666">Ci</div>
                            </div>
                        </div>
                        <!-- Rank 3 -->
                        <div style="display:flex;align-items:center;gap:12px;background:#222;border-radius:12px;padding:12px;margin-bottom:16px">
                            <span style="width:28px;height:28px;border-radius:50%;background:#333;color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0">3</span>
                            <div style="flex:1">
                                <div style="font-weight:600;color:#fff;font-size:14px">Kelabu</div>
                                <div style="font-size:12px;color:#666">Jazz</div>
                            </div>
                            <div style="text-align:right">
                                <div style="font-weight:700;font-size:14px;color:#F5A623">0.631</div>
                                <div style="font-size:11px;color:#666">Ci</div>
                            </div>
                        </div>
                        <!-- Progress bars -->
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
                            <div style="flex:1;height:5px;border-radius:3px;background:#333"><div style="width:84.7%;height:5px;border-radius:3px;background:#F5A623"></div></div>
                            <span style="font-size:11px;color:#666;width:32px">84.7%</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
                            <div style="flex:1;height:5px;border-radius:3px;background:#333"><div style="width:71.2%;height:5px;border-radius:3px;background:#F5A623"></div></div>
                            <span style="font-size:11px;color:#666;width:32px">71.2%</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px">
                            <div style="flex:1;height:5px;border-radius:3px;background:#333"><div style="width:63.1%;height:5px;border-radius:3px;background:#F5A623"></div></div>
                            <span style="font-size:11px;color:#666;width:32px">63.1%</span>
                        </div>
                    </div>
                    <div class="card" style="position:absolute;top:-16px;right:-16px;padding:8px 16px;font-size:12px;font-weight:700;color:#4ade80;border-color:#166534">
                        ✓ TOPSIS Selesai
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section style="padding:80px 0;background:#111">
    <div style="max-width:1100px;margin:0 auto;padding:0 24px">
        <div style="text-align:center;margin-bottom:56px">
            <span class="badge" style="background:#0d1f3c;color:#60a5fa">Cara Kerja</span>
            <h2 style="font-size:32px;font-weight:700;color:#fff;margin:12px 0 8px">Proses 3 Langkah Mudah</h2>
            <p style="color:#6B7280">Dari filter hingga rekomendasi, semuanya otomatis berbasis algoritma TOPSIS</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px">
            <div class="card" style="padding:28px">
                <div style="width:48px;height:48px;border-radius:12px;background:#2a1a00;display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:16px">🔍</div>
                <div style="font-size:11px;font-weight:700;letter-spacing:0.1em;color:#F5A623;margin-bottom:4px">LANGKAH 1</div>
                <h3 style="font-weight:700;color:#fff;font-size:18px;margin-bottom:8px">Filter Band</h3>
                <p style="color:#6B7280;font-size:14px;line-height:1.6">Tentukan kriteria pencarian: genre musik, lokasi kota, dan budget maksimum yang Anda miliki.</p>
            </div>
            <div class="card" style="padding:28px">
                <div style="width:48px;height:48px;border-radius:12px;background:#0d2d1f;display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:16px">⚖️</div>
                <div style="font-size:11px;font-weight:700;letter-spacing:0.1em;color:#4ade80;margin-bottom:4px">LANGKAH 2</div>
                <h3 style="font-weight:700;color:#fff;font-size:18px;margin-bottom:8px">Bobot Prioritas</h3>
                <p style="color:#6B7280;font-size:14px;line-height:1.6">Atur bobot kepentingan untuk pengalaman band, popularitas, dan biaya sewa sesuai kebutuhan.</p>
            </div>
            <div class="card" style="padding:28px">
                <div style="width:48px;height:48px;border-radius:12px;background:#1a0d2a;display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:16px">🏆</div>
                <div style="font-size:11px;font-weight:700;letter-spacing:0.1em;color:#a78bfa;margin-bottom:4px">LANGKAH 3</div>
                <h3 style="font-weight:700;color:#fff;font-size:18px;margin-bottom:8px">Dapatkan Ranking</h3>
                <p style="color:#6B7280;font-size:14px;line-height:1.6">Algoritma TOPSIS meranking band secara ilmiah dan menampilkan rekomendasi terbaik.</p>
            </div>
        </div>
    </div>
</section>

<!-- Criteria -->
<section style="padding:80px 0;background:#0F0F0F">
    <div style="max-width:1100px;margin:0 auto;padding:0 24px">
        <div style="text-align:center;margin-bottom:56px">
            <span class="badge" style="background:#052e16;color:#4ade80">Kriteria Penilaian</span>
            <h2 style="font-size:32px;font-weight:700;color:#fff;margin:12px 0 8px">3 Kriteria Objektif TOPSIS</h2>
            <p style="color:#6B7280">Penilaian berbasis data nyata, bukan subjektivitas semata</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px">
            <div class="card" style="padding:28px;border-color:#166534">
                <div style="font-size:32px;margin-bottom:16px">📅</div>
                <span class="badge" style="background:#052e16;color:#4ade80;margin-bottom:12px">Benefit +</span>
                <h3 style="font-weight:700;color:#fff;font-size:18px;margin:8px 0">Pengalaman</h3>
                <p style="color:#6B7280;font-size:14px;line-height:1.6">Dihitung dari tahun berdiri hingga sekarang. Semakin lama, semakin tinggi nilainya.</p>
            </div>
            <div class="card" style="padding:28px;border-color:#1e3a5f">
                <div style="font-size:32px;margin-bottom:16px">👥</div>
                <span class="badge" style="background:#0d1f3c;color:#60a5fa;margin-bottom:12px">Benefit +</span>
                <h3 style="font-weight:700;color:#fff;font-size:18px;margin:8px 0">Popularitas</h3>
                <p style="color:#6B7280;font-size:14px;line-height:1.6">Jumlah pengikut di media sosial sebagai indikator popularitas dan jangkauan band.</p>
            </div>
            <div class="card" style="padding:28px;border-color:#991b1b">
                <div style="font-size:32px;margin-bottom:16px">💰</div>
                <span class="badge" style="background:#450a0a;color:#f87171;margin-bottom:12px">Cost ↓</span>
                <h3 style="font-weight:700;color:#fff;font-size:18px;margin:8px 0">Biaya Sewa</h3>
                <p style="color:#6B7280;font-size:14px;line-height:1.6">Harga sewa band per penampilan. Semakin kompetitif, semakin unggul dalam perhitungan.</p>
            </div>
        </div>
    </div>
</section>

<!-- Roles -->
<section style="padding:80px 0;background:#111">
    <div style="max-width:1100px;margin:0 auto;padding:0 24px">
        <div style="text-align:center;margin-bottom:56px">
            <span class="badge" style="background:#1a0d2a;color:#a78bfa">Peran Pengguna</span>
            <h2 style="font-size:32px;font-weight:700;color:#fff;margin:12px 0 8px">Untuk Siapa BandSPK?</h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px">
            <div class="card" style="padding:28px">
                <div style="width:48px;height:48px;border-radius:12px;background:#2a1a00;display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:16px">👤</div>
                <h3 style="font-weight:700;color:#fff;margin-bottom:16px">Anggota / Pencari Band</h3>
                <ul style="list-style:none;padding:0;space-y:8px">
                    <li style="color:#9CA3AF;font-size:14px;padding:4px 0">✓ &nbsp;Filter band sesuai genre & lokasi</li>
                    <li style="color:#9CA3AF;font-size:14px;padding:4px 0">✓ &nbsp;Atur bobot prioritas sendiri</li>
                    <li style="color:#9CA3AF;font-size:14px;padding:4px 0">✓ &nbsp;Lihat ranking TOPSIS real-time</li>
                    <li style="color:#9CA3AF;font-size:14px;padding:4px 0">✓ &nbsp;Akses profil lengkap band</li>
                </ul>
            </div>
            <div class="card" style="padding:28px">
                <div style="width:48px;height:48px;border-radius:12px;background:#052e16;display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:16px">🎸</div>
                <h3 style="font-weight:700;color:#fff;margin-bottom:16px">Band / Musisi</h3>
                <ul style="list-style:none;padding:0">
                    <li style="color:#9CA3AF;font-size:14px;padding:4px 0">✓ &nbsp;Kelola profil band sendiri</li>
                    <li style="color:#9CA3AF;font-size:14px;padding:4px 0">✓ &nbsp;Pantau skor TOPSIS Anda</li>
                    <li style="color:#9CA3AF;font-size:14px;padding:4px 0">✓ &nbsp;Lihat riwayat ranking</li>
                    <li style="color:#9CA3AF;font-size:14px;padding:4px 0">✓ &nbsp;Dapatkan tips peningkatan</li>
                </ul>
            </div>
            <div class="card" style="padding:28px">
                <div style="width:48px;height:48px;border-radius:12px;background:#0d1f3c;display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:16px">⚙️</div>
                <h3 style="font-weight:700;color:#fff;margin-bottom:16px">Administrator</h3>
                <ul style="list-style:none;padding:0">
                    <li style="color:#9CA3AF;font-size:14px;padding:4px 0">✓ &nbsp;Kelola seluruh data band</li>
                    <li style="color:#9CA3AF;font-size:14px;padding:4px 0">✓ &nbsp;Manajemen genre & anggota</li>
                    <li style="color:#9CA3AF;font-size:14px;padding:4px 0">✓ &nbsp;Pantau log aktivitas sistem</li>
                    <li style="color:#9CA3AF;font-size:14px;padding:4px 0">✓ &nbsp;Kontrol penuh data TOPSIS</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section style="padding:80px 0;background:linear-gradient(135deg,#1a1000,#0F0F0F)">
    <div style="max-width:600px;margin:0 auto;padding:0 24px;text-align:center">
        <div style="font-size:48px;margin-bottom:16px">🎸</div>
        <h2 style="font-size:32px;font-weight:700;color:#fff;margin-bottom:16px">Siap Menemukan Band Impian?</h2>
        <p style="color:#6B7280;margin-bottom:32px">Daftar sekarang dan mulai gunakan algoritma TOPSIS untuk membuat keputusan yang lebih cerdas dalam memilih band.</p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary">Ke Dashboard →</a>
            @else
                <a href="{{ route('register') }}" class="btn-primary">Daftar Gratis Sekarang →</a>
                <a href="{{ route('login') }}" class="btn-outline">Masuk</a>
            @endauth
        </div>
    </div>
</section>

<!-- Footer -->
<footer style="background:#0a0a0a;border-top:1px solid #1a1a1a">
    <div style="max-width:1100px;margin:0 auto;padding:28px 24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px">
        <div style="display:flex;align-items:center;gap:12px">
            <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#F5A623,#E07B00);display:flex;align-items:center;justify-content:center">🎸</div>
            <span style="font-weight:700;color:#fff">BandSPK</span>
            <span style="color:#4B5563;font-size:13px">— Sistem Pendukung Keputusan Pemilihan Band</span>
        </div>
        <div style="color:#4B5563;font-size:13px">Metode TOPSIS &nbsp;|&nbsp; Laravel Framework &nbsp;|&nbsp; 2024</div>
    </div>
</footer>

</body>
</html>
