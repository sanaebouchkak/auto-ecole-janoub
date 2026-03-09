<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultatExamen extends Model {
    use HasFactory;
    protected $table = 'resultat_examens';
    protected $fillable = ['candidat_id', 'type', 'resultat', 'date_examen'];

    public function candidat() {
        return $this->belongsTo(Candidat::class);
    }
}
