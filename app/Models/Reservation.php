<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model {
    use HasFactory;
    protected $fillable = ['seance_id', 'candidat_id', 'statut'];

    public function seance() {
        return $this->belongsTo(Seance::class);
    }

    public function candidat() {
        return $this->belongsTo(Candidat::class);
    }
}
