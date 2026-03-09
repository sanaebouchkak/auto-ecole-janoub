<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Formation;

class FormationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formations = [
            [
                'nom' => 'Permis B (Auto)',
                'description' => 'Apprenez à conduire en toute sécurité sur nos véhicules dernière génération.',
                'prix' => 3800,
                'image_path' => 'c:\Users\HP\Pictures\s2.png',
                'duree_heures' => 20
            ],
            [
                'nom' => 'Permis C (Poids Lourds)',
                'description' => 'Devenez un professionnel de la route avec notre formation poids lourds complète.',
                'prix' => 5500,
                'image_path' => 'https://images.unsplash.com/photo-1586191582056-96fcfdd9f47a?auto=format&fit=crop&q=80&w=800',
                'duree_heures' => 30
            ],
            [
                'nom' => 'Permis A (Moto)',
                'description' => 'Maîtrisez la conduite deux-roues avec nos experts certifiés.',
                'prix' => 2900,
                'image_path' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?auto=format&fit=crop&q=80&w=800',
                'duree_heures' => 15
            ]
        ];

        foreach ($formations as $formation) {
            Formation::updateOrCreate(
                ['nom' => $formation['nom']],
                $formation
            );
        }
    }
}
