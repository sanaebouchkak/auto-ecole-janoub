<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'date_naissance', 'adresse', 'date_inscription'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    public function paiements() {
        return $this->hasMany(Paiement::class);
    }

    public function resultats() {
        return $this->hasMany(ResultatExamen::class);
    }
}
