<?php
// ============================================================
// FILE: app/Models/User.php
// ============================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'status'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function band()
    {
        return $this->hasOne(Band::class);
    }

    public function sesiTopsis()
    {
        return $this->hasMany(SesiTopsis::class);
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isBand(): bool  { return $this->role === 'band'; }
    public function isAnggota(): bool { return $this->role === 'anggota'; }
}
