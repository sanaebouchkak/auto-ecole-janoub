<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model {
    use HasFactory;
    protected $fillable = [
        'candidat_id',
        'formation_id',
        'montant',
        'methode_paiement',
        'date_paiement',
        'statut',
    ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}
