<?php
// FILE: app/Models/SesiTopsis.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiTopsis extends Model
{
    protected $table = 'sesi_topsis';
    protected $fillable = [
        'user_id','filter_genre','filter_lokasi','filter_budget',
        'bobot_pengalaman','bobot_popularitas','bobot_biaya','hasil_ranking'
    ];
    protected $casts = ['hasil_ranking' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRekomendasiTerbaikAttribute(): ?array
    {
        return $this->hasil_ranking[0] ?? null;
    }
}
