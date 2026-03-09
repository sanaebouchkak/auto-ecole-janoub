<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Paiement;
use App\Models\Formation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // ESPACE ADMIN
        if ($user->isAdmin()) {
            $stats = [
                'total_candidats' => User::where('role', \App\Enums\UserRole::CANDIDAT)->count(),
                'total_staff' => User::whereIn('role', [\App\Enums\UserRole::ADMIN, \App\Enums\UserRole::ASSISTANTE, \App\Enums\UserRole::MONITEUR])->count(),
                'total_reservations' => Reservation::count(),
                'revenus' => Paiement::whereIn('statut', ['paye', 'partiel'])->sum('montant'),
            ];

            // Données pour Chart.js - Revenus mensuels
            $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();
            $revenusMensuels = Paiement::whereIn('statut', ['paye', 'partiel'])
                ->where('date_paiement', '>=', $sixMonthsAgo)
                ->select(DB::raw('SUM(montant) as total'), DB::raw('DATE_FORMAT(date_paiement, "%Y-%m") as mois'))
                ->groupBy('mois')
                ->orderBy('mois')
                ->get();

            $labelsRevenus = [];
            $dataRevenus = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $monthKey = $month->format('Y-m');
                $labelsRevenus[] = $month->translatedFormat('F Y');
                $match = $revenusMensuels->firstWhere('mois', $monthKey);
                $dataRevenus[] = $match ? $match->total : 0;
            }

            // Données pour Chart.js - Réservations par formation
            $resByForm = DB::table('reservations')
                ->join('seances', 'reservations.seance_id', '=', 'seances.id')
                ->join('formations', 'seances.formation_id', '=', 'formations.id')
                ->select('formations.nom', DB::raw('count(*) as total'))
                ->groupBy('formations.nom')
                ->get();

            $labelsFormations = $resByForm->pluck('nom')->toArray();
            $dataFormations = $resByForm->pluck('total')->toArray();

            return view('dashboard.admin', compact('stats', 'labelsRevenus', 'dataRevenus', 'labelsFormations', 'dataFormations'));
        }

        // ESPACE ASSISTANTE
        if ($user->isAssistante()) {
            $prochainesSeances = \App\Models\Seance::with(['formation', 'moniteur.user'])
                ->where('date', '>=', now()->toDateString())
                ->orderBy('date')
                ->limit(5)
                ->get();

            $dernieresReservations = Reservation::with(['candidat.user', 'seance.formation'])
                ->latest()
                ->limit(5)
                ->get();

            return view('dashboard.assistante', compact('prochainesSeances', 'dernieresReservations'));
        }

        // ESPACE MONITEUR
        if ($user->isMoniteur()) {
            $moniteur = $user->moniteur;
            if (!$moniteur) abort(403);

            $seances = \App\Models\Seance::with(['formation', 'reservations.candidat.user'])
                ->where('moniteur_id', $moniteur->id)
                ->where('date', '>=', now()->toDateString())
                ->orderBy('date')
                ->get();

            $totalHeures = \App\Models\Seance::where('moniteur_id', $moniteur->id)
                ->where('statut', 'terminee')
                ->count();

            return view('dashboard.moniteur', compact('seances', 'totalHeures'));
        }

        // ESPACE CANDIDAT
        $candidat = $user->candidat;
        if (!$candidat) abort(403);

        $prochaineSeance = Reservation::with('seance.formation')
            ->where('candidat_id', $candidat->id)
            ->where('statut', 'confirmee')
            ->whereHas('seance', fn($q) => $q->where('date', '>=', now()->toDateString()))
            ->first();

        $heuresFaites = Reservation::where('candidat_id', $candidat->id)
            ->where('statut', 'confirmee')
            ->whereHas('seance', fn($q) => $q->where('statut', 'terminee'))
            ->count();

        $totalPaye = Paiement::where('candidat_id', $candidat->id)
            ->whereIn('statut', ['paye', 'partiel'])
            ->sum('montant');
        
        $formationsIds = Reservation::where('candidat_id', $candidat->id)
            ->join('seances', 'reservations.seance_id', '=', 'seances.id')
            ->pluck('seances.formation_id')
            ->unique();
            
        $totalDevis = Formation::whereIn('id', $formationsIds)->sum('prix');
        $resteAPayer = max(0, $totalDevis - $totalPaye);

        return view('dashboard.candidat', compact('prochaineSeance', 'heuresFaites', 'totalPaye', 'resteAPayer'));
    }
}
