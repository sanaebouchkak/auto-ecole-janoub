<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Formation;
use App\Models\Seance;
use App\Models\Reservation;
use App\Models\Paiement;

class ReservationController extends Controller {
    public function create() {
        \Illuminate\Support\Facades\Gate::authorize('create', Reservation::class);
        $formations = Formation::all();
        $seances = Seance::where('statut', 'disponible')->where('date', '>=', now()->toDateString())->get();
        return view('reservations.create', compact('formations', 'seances'));
    }

    public function store(Request $request) {
        \Illuminate\Support\Facades\Gate::authorize('create', Reservation::class);
        $request->validate(['seance_id' => 'required|exists:seances,id']);
        
        $candidat = $request->user()->candidat;
        if (!$candidat) abort(403, 'Profil candidat requis.');

        $reservation = Reservation::create([
            'seance_id' => $request->seance_id,
            'candidat_id' => $candidat->id,
            'statut' => 'en_attente'
        ]);

        // Créer automatiquement un paiement "en attente"
        $seance = Seance::with('formation')->find($request->seance_id);
        $paiement = Paiement::create([
            'candidat_id' => $candidat->id,
            'formation_id' => $seance->formation_id,
            'montant' => $seance->formation->prix ?? 0,
            'statut' => 'non_paye',
            'methode_paiement' => 'carte', // Par défaut pour Stripe
            'date_paiement' => now(),
        ]);

        // Rediriger vers la page de paiement (Stripe)
        return redirect()->route('candidat.paiements.pay', $paiement)->with('success', 'Réservation enregistrée. Veuillez procéder au paiement.');
    }

    public function index(Request $request) {
        \Illuminate\Support\Facades\Gate::authorize('viewAny', Reservation::class);
        $candidat = $request->user()->candidat;
        if (!$candidat) abort(403);
        
        $reservations = Reservation::with('seance.formation')
            ->where('candidat_id', $candidat->id)
            ->latest()
            ->get();
        return view('reservations.index', compact('reservations'));
    }

    public function indexAdmin() {
        \Illuminate\Support\Facades\Gate::authorize('manage-reservations');
        $reservations = Reservation::with(['candidat.user', 'seance.formation'])->latest()->paginate(10);
        return view('reservations.admin_index', compact('reservations'));
    }

    public function updateStatus(Request $request, Reservation $reservation) {
        \Illuminate\Support\Facades\Gate::authorize('update', $reservation);
        $request->validate(['statut' => 'required|in:confirmee,annulee,en_attente']);
        $reservation->update(['statut' => $request->statut]);
        
        return back()->with('success', 'Statut de la réservation mis à jour.');
    }

    public function destroy(Reservation $reservation) {
        \Illuminate\Support\Facades\Gate::authorize('delete', $reservation);
        
        if ($reservation->statut !== 'en_attente' && !auth()->user()->isAdmin()) {
            return back()->with('error', 'Vous ne pouvez plus annuler cette réservation car elle est déjà traitée.');
        }

        $reservation->delete();
        return back()->with('success', 'Réservation annulée avec succès.');
    }
}
