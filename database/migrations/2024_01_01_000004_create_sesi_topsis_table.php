<?php
// BUAT FILE INI DI: database/migrations/2024_01_01_000004_create_sesi_topsis_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sesi_topsis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('filter_genre')->nullable();
            $table->string('filter_lokasi')->nullable();
            $table->unsignedBigInteger('filter_budget')->nullable();
            $table->integer('bobot_pengalaman')->default(5);
            $table->integer('bobot_popularitas')->default(5);
            $table->integer('bobot_biaya')->default(5);
            $table->json('hasil_ranking')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('sesi_topsis'); }
};
