<?php
// FILE: app/Models/LogAktivitas.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    protected $fillable = ['user_id','aksi','detail','ip_address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
