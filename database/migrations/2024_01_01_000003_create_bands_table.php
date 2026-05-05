<?php
// BUAT FILE INI DI: database/migrations/2024_01_01_000003_create_bands_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('genre_id')->constrained()->onDelete('restrict');
            $table->string('nama_band');
            $table->string('lokasi');
            $table->integer('tahun_berdiri');
            $table->unsignedBigInteger('pengikut')->default(0);
            $table->unsignedBigInteger('biaya_sewa');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('bands'); }
};
