<?php
// =============================================================
// FILE: database/migrations/2024_01_01_000001_create_users_table.php
// =============================================================
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['anggota', 'band', 'admin'])->default('anggota');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

// =============================================================
// FILE: database/migrations/2024_01_01_000002_create_genres_table.php
// =============================================================
// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration {
//     public function up(): void
//     {
//         Schema::create('genres', function (Blueprint $table) {
//             $table->id();
//             $table->string('nama_genre');
//             $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
//             $table->timestamps();
//         });
//     }
//     public function down(): void { Schema::dropIfExists('genres'); }
// };

// =============================================================
// FILE: database/migrations/2024_01_01_000003_create_bands_table.php
// =============================================================
// return new class extends Migration {
//     public function up(): void
//     {
//         Schema::create('bands', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('user_id')->constrained()->onDelete('cascade');
//             $table->foreignId('genre_id')->constrained()->onDelete('restrict');
//             $table->string('nama_band');
//             $table->string('lokasi');
//             $table->integer('tahun_berdiri');
//             $table->unsignedBigInteger('pengikut')->default(0);
//             $table->unsignedBigInteger('biaya_sewa');
//             $table->text('deskripsi')->nullable();
//             $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
//             $table->timestamps();
//         });
//     }
//     public function down(): void { Schema::dropIfExists('bands'); }
// };

// =============================================================
// FILE: database/migrations/2024_01_01_000004_create_sesi_topsis_table.php
// =============================================================
// return new class extends Migration {
//     public function up(): void
//     {
//         Schema::create('sesi_topsis', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('user_id')->constrained()->onDelete('cascade');
//             $table->string('filter_genre')->nullable();
//             $table->string('filter_lokasi')->nullable();
//             $table->unsignedBigInteger('filter_budget')->nullable();
//             $table->integer('bobot_pengalaman')->default(5);
//             $table->integer('bobot_popularitas')->default(5);
//             $table->integer('bobot_biaya')->default(5);
//             $table->json('hasil_ranking')->nullable(); // simpan array hasil
//             $table->timestamps();
//         });
//     }
//     public function down(): void { Schema::dropIfExists('sesi_topsis'); }
// };

// =============================================================
// FILE: database/migrations/2024_01_01_000005_create_log_aktivitas_table.php
// =============================================================
// return new class extends Migration {
//     public function up(): void
//     {
//         Schema::create('log_aktivitas', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
//             $table->string('aksi');
//             $table->text('detail')->nullable();
//             $table->string('ip_address')->nullable();
//             $table->timestamps();
//         });
//     }
//     public function down(): void { Schema::dropIfExists('log_aktivitas'); }
// };
