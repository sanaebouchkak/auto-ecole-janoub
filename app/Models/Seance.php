<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model {
    use HasFactory;
    protected $fillable = ['moniteur_id', 'formation_id', 'date', 'heure_debut', 'heure_fin', 'statut'];

    public function moniteur() {
        return $this->belongsTo(Moniteur::class);
    }

    public function formation() {
        return $this->belongsTo(Formation::class);
    }

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }
}
