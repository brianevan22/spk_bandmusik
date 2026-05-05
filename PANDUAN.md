# BandSPK - Sistem Pendukung Keputusan Pemilihan Band Musik
## Laravel 12 + Breeze + MySQL + TOPSIS

---

## STRUKTUR FOLDER LENGKAP

```
bandspk/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    (dari Breeze)
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── BandController.php
│   │   │   │   ├── AnggotaController.php
│   │   │   │   ├── GenreController.php
│   │   │   │   └── LogAktivitasController.php
│   │   │   ├── Anggota/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── FilterBandController.php
│   │   │   │   ├── HasilTopsisController.php
│   │   │   │   └── ProfilBandController.php
│   │   │   ├── Band/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── ProfilSayaController.php
│   │   │   │   └── StatistikController.php
│   │   │   └── Auth/
│   │   │       └── RegisterController.php (override Breeze)
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Band.php
│   │   ├── Genre.php
│   │   ├── SesiTopsis.php
│   │   └── LogAktivitas.php
│   └── Services/
│       └── TopsisService.php
├── database/
│   └── migrations/
│       ├── xxxx_create_users_table.php
│       ├── xxxx_create_genres_table.php
│       ├── xxxx_create_bands_table.php
│       ├── xxxx_create_sesi_topsis_table.php
│       └── xxxx_create_log_aktivitas_table.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php
│       │   ├── admin.blade.php
│       │   ├── anggota.blade.php
│       │   └── band.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── band/
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php
│       │   │   └── edit.blade.php
│       │   ├── anggota/
│       │   │   ├── index.blade.php
│       │   │   └── edit.blade.php
│       │   ├── genre/
│       │   │   ├── index.blade.php
│       │   │   └── create.blade.php
│       │   └── log/
│       │       └── index.blade.php
│       ├── anggota/
│       │   ├── dashboard.blade.php
│       │   ├── filter.blade.php
│       │   ├── hasil.blade.php
│       │   └── profil-band.blade.php
│       └── band/
│           ├── dashboard.blade.php
│           ├── profil.blade.php
│           └── statistik.blade.php
└── routes/
    └── web.php
```
