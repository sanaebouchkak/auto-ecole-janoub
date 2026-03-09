<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seance;
use App\Models\Formation;
use App\Models\Moniteur;
use Carbon\Carbon;

class SeanceSeeder extends Seeder
{
    public function run(): void
    {
        $moniteur = Moniteur::first();
        if (!$moniteur) {
            $this->command->warn('Aucun moniteur trouvé. Créez d\'abord un moniteur.');
            return;
        }

        $formations = Formation::all();
        if ($formations->isEmpty()) {
            $this->command->warn('Aucune formation trouvée. Lancez d\'abord FormationSeeder.');
            return;
        }

        // Générer des séances sur les 4 prochaines semaines
        $seances = [];
        $today = Carbon::now();

        $creneaux = [
            ['debut' => '08:00', 'fin' => '10:00'],
            ['debut' => '10:00', 'fin' => '12:00'],
            ['debut' => '14:00', 'fin' => '16:00'],
            ['debut' => '16:00', 'fin' => '18:00'],
        ];

        // Créer 3 séances par formation sur les 2 prochaines semaines
        foreach ($formations as $formation) {
            for ($week = 0; $week < 2; $week++) {
                // Lundi, Mercredi, Samedi
                $joursSemaine = [1, 3, 6]; // 1=Lundi, 3=Mercredi, 6=Samedi
                foreach ($joursSemaine as $jour) {
                    $date = $today->copy()->addWeeks($week)->startOfWeek()->addDays($jour - 1);
                    
                    // S'assurer que la date est dans le futur
                    if ($date->isPast()) {
                        $date = $date->addWeek();
                    }

                    $creneau = $creneaux[array_rand($creneaux)];

                    Seance::updateOrCreate(
                        [
                            'moniteur_id'  => $moniteur->id,
                            'formation_id' => $formation->id,
                            'date'         => $date->toDateString(),
                            'heure_debut'  => $creneau['debut'],
                        ],
                        [
                            'heure_fin' => $creneau['fin'],
                            'statut'    => 'disponible',
                        ]
                    );
                }
            }
        }

        $this->command->info('✅ Séances créées avec succès !');
    }
}
