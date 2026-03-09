<?php
namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Candidat;
use App\Models\Formation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        \Illuminate\Support\Facades\Gate::authorize('manage-paiements');
        
        $paiements = Paiement::with(['candidat.user', 'formation'])->latest()->paginate(10);
        $candidats = Candidat::with('user')->get();
        $formations = Formation::all();
        
        return view('paiements.index', compact('paiements', 'candidats', 'formations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('create', Paiement::class);
        
        $validated = $request->validate([
            'candidat_id' => 'required|exists:candidats,id',
            'formation_id' => 'required|exists:formations,id',
            'montant' => 'required|numeric|min:0',
            'methode_paiement' => 'required|string',
            'date_paiement' => 'required|date',
            'statut' => 'required|in:paye,partiel,non_paye'
        ]);

        Paiement::create($validated);

        return redirect()->route(auth()->user()->role->value . '.paiements.index')->with('success', 'Paiement ajouté avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paiement $paiement)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $paiement);
        
        $candidats = Candidat::with('user')->get();
        $formations = Formation::all();
        
        return view('paiements.form', compact('paiement', 'candidats', 'formations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paiement $paiement)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $paiement);
        
        $validated = $request->validate([
            'candidat_id' => 'required|exists:candidats,id',
            'formation_id' => 'required|exists:formations,id',
            'montant' => 'required|numeric|min:0',
            'methode_paiement' => 'required|string',
            'date_paiement' => 'required|date',
            'statut' => 'required|in:paye,partiel,non_paye'
        ]);

        $paiement->update($validated);

        return redirect()->route(auth()->user()->role->value . '.paiements.index')->with('success', 'Paiement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paiement $paiement)
    {
        \Illuminate\Support\Facades\Gate::authorize('delete', $paiement);
        
        $paiement->delete();
        return back()->with('success', 'Paiement supprimé.');
    }

    /**
     * Affichage pour le candidat (Mes paiements)
     */
    public function indexCandidat(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('viewAny', Paiement::class);
        
        $candidat = $request->user()->candidat;
        if (!$candidat) abort(403);

        $paiements = Paiement::with('formation')
            ->where('candidat_id', $candidat->id)
            ->latest()
            ->get();
            
        $totalPaye = $paiements->where('statut', '!=', 'non_paye')->sum('montant');
        $formationsIds = $paiements->pluck('formation_id')->filter()->unique();
        $formations = Formation::whereIn('id', $formationsIds)->get();
        
        $totalAPayer = $formations->sum('prix');
        $resteAPayer = max(0, $totalAPayer - $totalPaye);

        return view('paiements.candidat_index', compact('paiements', 'totalPaye', 'totalAPayer', 'resteAPayer'));
    }
    /**
     * Exporter tous les paiements en PDF.
     */
    public function exportPdf()
    {
        \Illuminate\Support\Facades\Gate::authorize('manage-paiements');

        $paiements = Paiement::with(['candidat.user', 'formation'])
                              ->orderBy('date_paiement', 'desc')
                              ->get();

        $pdf = Pdf::loadView('paiements.pdf', compact('paiements'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('paiements_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Initier le paiement Stripe pour un record donné.
     */
    public function pay(Paiement $paiement)
    {
        // On pourrait ici créer une session Stripe.
        // Pour l'instant, on simule une page de redirection vers Stripe.
        return view('paiements.pay', compact('paiement'));
    }

    /**
     * Confirmation du paiement (Callback).
     */
    public function success(Request $request, Paiement $paiement)
    {
        $paiement->update([
            'statut' => 'paye',
            'date_paiement' => now(),
            'methode_paiement' => 'carte',
        ]);

        return view('paiements.success', compact('paiement'));
    }

    /**
     * Télécharger la facture PDF.
     */
    public function downloadInvoice(Paiement $paiement)
    {
        // Vérifier que le paiement appartient au candidat connecté ou que c'est un admin
        if (!auth()->user()->isAdmin() && $paiement->candidat_id !== auth()->user()->candidat->id) {
            abort(403);
        }

        if ($paiement->statut !== 'paye') {
            return back()->with('error', 'La facture n\'est disponible que pour les paiements complétés.');
        }

        $pdf = Pdf::loadView('paiements.facture', compact('paiement'));
        
        return $pdf->download('facture_' . str_pad($paiement->id, 6, '0', STR_PAD_LEFT) . '.pdf');
    }
}
