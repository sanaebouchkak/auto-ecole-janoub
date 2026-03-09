<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moniteur extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'specialite'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function seances() {
        return $this->hasMany(Seance::class);
    }
}
