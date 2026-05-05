<?php
// FILE: app/Models/Genre.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['nama_genre', 'status'];

    public function bands()
    {
        return $this->hasMany(Band::class);
    }
}
