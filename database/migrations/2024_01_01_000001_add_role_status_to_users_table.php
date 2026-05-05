<?php
// FILE: database/migrations/2024_01_01_000001_add_role_status_to_users_table.php
// SIMPAN file ini di folder: database/migrations/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['anggota', 'band', 'admin'])->default('anggota')->after('email');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status']);
        });
    }
};
