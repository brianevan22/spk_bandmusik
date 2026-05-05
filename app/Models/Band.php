<?php
// ============================================================
// FILE: app/Models/Band.php
// ============================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Band extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'genre_id', 'nama_band', 'lokasi',
        'tahun_berdiri', 'pengikut', 'biaya_sewa', 'deskripsi', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function getPengalamanAttribute(): int
    {
        return now()->year - $this->tahun_berdiri;
    }

    public function getInisialAttribute(): string
    {
        $words = explode(' ', $this->nama_band);
        return strtoupper(substr($words[0], 0, 2));
    }
}

// ============================================================
// FILE: app/Models/Genre.php  — BUAT FILE TERPISAH
// ============================================================
// namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
// class Genre extends Model
// {
//     protected $fillable = ['nama_genre', 'status'];
//     public function bands() { return $this->hasMany(Band::class); }
//     public function jumlahBand(): int { return $this->bands()->count(); }
// }

// ============================================================
// FILE: app/Models/SesiTopsis.php  — BUAT FILE TERPISAH
// ============================================================
// namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
// class SesiTopsis extends Model
// {
//     protected $fillable = [
//         'user_id','filter_genre','filter_lokasi','filter_budget',
//         'bobot_pengalaman','bobot_popularitas','bobot_biaya','hasil_ranking'
//     ];
//     protected $casts = ['hasil_ranking' => 'array'];
//     public function user() { return $this->belongsTo(User::class); }
//     public function getRekomendasiTerbaikAttribute(): ?array
//     {
//         return $this->hasil_ranking[0] ?? null;
//     }
// }

// ============================================================
// FILE: app/Models/LogAktivitas.php  — BUAT FILE TERPISAH
// ============================================================
// namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
// class LogAktivitas extends Model
// {
//     protected $fillable = ['user_id','aksi','detail','ip_address'];
//     public function user() { return $this->belongsTo(User::class); }
// }
