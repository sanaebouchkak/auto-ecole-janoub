<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model {
    use HasFactory;
    protected $fillable = ['nom', 'description', 'prix', 'duree_heures', 'image_path'];

    public function seances() {
        return $this->hasMany(Seance::class);
    }
}
