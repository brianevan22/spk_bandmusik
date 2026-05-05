# ============================================================
# PANDUAN INSTALASI LENGKAP - BandSPK
# Laravel 12 + Breeze + MySQL + TOPSIS
# ============================================================

## LANGKAH 1 — BUAT PROJECT LARAVEL

```bash
composer create-project laravel/laravel bandspk
cd bandspk
```

## LANGKAH 2 — INSTALL LARAVEL BREEZE

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
```

## LANGKAH 3 — KONFIGURASI DATABASE (.env)

Buka file `.env` dan ubah bagian database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bandspk
DB_USERNAME=root
DB_PASSWORD=
```

Buat database di MySQL:
```sql
CREATE DATABASE bandspk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## LANGKAH 4 — SALIN SEMUA FILE YANG SUDAH DIBUAT

Salin file-file berikut ke project Laravel Anda sesuai path-nya:

### bootstrap/
- `bootstrap/app.php` ← GANTI seluruh isinya

### app/Http/Middleware/
- `app/Http/Middleware/RoleMiddleware.php` ← FILE BARU

### app/Models/
- `app/Models/User.php` ← GANTI seluruh isinya
- `app/Models/Band.php` ← FILE BARU
- `app/Models/Genre.php` ← FILE BARU
- `app/Models/SesiTopsis.php` ← FILE BARU
- `app/Models/LogAktivitas.php` ← FILE BARU

### app/Services/
```bash
mkdir -p app/Services
```
- `app/Services/TopsisService.php` ← FILE BARU

### app/Http/Controllers/
```bash
mkdir -p app/Http/Controllers/Admin
mkdir -p app/Http/Controllers/Anggota
mkdir -p app/Http/Controllers/Band
```

#### Admin Controllers:
- `app/Http/Controllers/Admin/DashboardController.php`
- `app/Http/Controllers/Admin/BandController.php`
- `app/Http/Controllers/Admin/AnggotaController.php`
- `app/Http/Controllers/Admin/GenreController.php`
- `app/Http/Controllers/Admin/LogAktivitasController.php`

#### Anggota Controllers:
- `app/Http/Controllers/Anggota/DashboardController.php`
- `app/Http/Controllers/Anggota/FilterBandController.php`
- `app/Http/Controllers/Anggota/HasilTopsisController.php`
- `app/Http/Controllers/Anggota/ProfilBandController.php`

#### Band Controllers:
- `app/Http/Controllers/Band/DashboardController.php`
- `app/Http/Controllers/Band/ProfilSayaController.php`
- `app/Http/Controllers/Band/StatistikController.php`

#### Auth (Override Breeze):
- `app/Http/Controllers/Auth/RegisteredUserController.php` ← GANTI

### routes/
- `routes/web.php` ← GANTI seluruh isinya

### database/migrations/
Buat 5 file migration baru:
- `2024_01_01_000002_create_genres_table.php`
- `2024_01_01_000003_create_bands_table.php`
- `2024_01_01_000004_create_sesi_topsis_table.php`
- `2024_01_01_000005_create_log_aktivitas_table.php`

### database/seeders/
- `database/seeders/DatabaseSeeder.php` ← GANTI

### resources/views/
```bash
mkdir -p resources/views/layouts
mkdir -p resources/views/auth
mkdir -p resources/views/admin/band
mkdir -p resources/views/admin/anggota
mkdir -p resources/views/admin/genre
mkdir -p resources/views/admin/log
mkdir -p resources/views/anggota
mkdir -p resources/views/band
```

#### Layouts:
- `resources/views/layouts/app.blade.php`

#### Auth:
- `resources/views/auth/login.blade.php` ← GANTI (Breeze punya)
- `resources/views/auth/register.blade.php` ← GANTI (Breeze punya)

#### Admin Views:
- `resources/views/admin/dashboard.blade.php`
- `resources/views/admin/band/index.blade.php`
- `resources/views/admin/band/create.blade.php`
- `resources/views/admin/band/edit.blade.php`
- `resources/views/admin/anggota/index.blade.php`
- `resources/views/admin/anggota/edit.blade.php`
- `resources/views/admin/genre/index.blade.php`
- `resources/views/admin/genre/create.blade.php`
- `resources/views/admin/genre/edit.blade.php`
- `resources/views/admin/log/index.blade.php`

#### Anggota Views:
- `resources/views/anggota/dashboard.blade.php`
- `resources/views/anggota/filter.blade.php`
- `resources/views/anggota/hasil.blade.php`
- `resources/views/anggota/profil-band.blade.php`

#### Band Views:
- `resources/views/band/dashboard.blade.php`
- `resources/views/band/profil.blade.php`
- `resources/views/band/statistik.blade.php`

## LANGKAH 5 — JALANKAN MIGRATION & SEEDER

```bash
php artisan migrate:fresh --seed
```

## LANGKAH 6 — JALANKAN APLIKASI

```bash
php artisan serve
```

Buka browser: http://localhost:8000

## AKUN LOGIN DEFAULT (dari seeder)

| Role    | Email                  | Password |
|---------|------------------------|----------|
| Admin   | admin@bandspk.com      | password |
| Anggota | anggota@bandspk.com    | password |
| Band    | sinaraya@band.com      | password |
| Band    | pantaiselatan@band.com | password |

## ALUR PENGGUNAAN

### Sebagai Anggota:
1. Login → Dashboard Anggota
2. Klik "Cari & Filter Band"
3. Isi filter: Genre, Lokasi, Budget → klik "Terapkan Filter"
4. Atur bobot TOPSIS dengan slider
5. Centang band yang ingin dibandingkan (min 2)
6. Klik "Jalankan Algoritma TOPSIS"
7. Lihat hasil ranking dengan nilai Ci

### Sebagai Band:
1. Login → Dashboard Band
2. Klik "Profil Saya" → lengkapi data
3. Pantau ranking di "Statistik & Ranking"

### Sebagai Admin:
1. Login → Dashboard Admin
2. Kelola Band, Anggota, Genre via menu sidebar
3. Pantau Log Aktivitas

## TROUBLESHOOTING

### Error: Target class [role] does not exist
Pastikan `bootstrap/app.php` sudah diperbarui dengan alias middleware.

### Error: View not found
Pastikan semua folder views sudah dibuat dengan `mkdir -p`.

### Error: Column not found
Jalankan ulang: `php artisan migrate:fresh --seed`

### Tampilan tidak muncul (CSS Tailwind)
File ini menggunakan Tailwind CDN, tidak perlu compile.
Pastikan koneksi internet tersedia saat development.
