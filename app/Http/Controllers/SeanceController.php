<?php
namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Moniteur;
use App\Models\Formation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SeanceController extends Controller
{
    public function index()
    {
        $seances = Seance::with(['moniteur.user', 'formation'])->latest()->paginate(10);
        return view('seances.index', compact('seances'));
    }

    public function create()
    {
        $moniteurs = Moniteur::with('user')->get();
        $formations = Formation::all();
        return view('seances.form', compact('moniteurs', 'formations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'moniteur_id' => 'required|exists:moniteurs,id',
            'formation_id' => 'required|exists:formations,id',
            'date' => 'required|date|after_or_equal:today',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'statut' => 'required|in:disponible,reservee,terminee'
        ]);

        Seance::create($validated);

        return redirect()->route(auth()->user()->role->value . '.seances.index')->with('success', 'Séance créée avec succès.');
    }

    public function edit(Seance $seance)
    {
        $moniteurs = Moniteur::with('user')->get();
        $formations = Formation::all();
        return view('seances.form', compact('seance', 'moniteurs', 'formations'));
    }

    public function update(Request $request, Seance $seance)
    {
        $validated = $request->validate([
            'moniteur_id' => 'required|exists:moniteurs,id',
            'formation_id' => 'required|exists:formations,id',
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'statut' => 'required|in:disponible,reservee,terminee'
        ]);

        $seance->update($validated);

        return redirect()->route(auth()->user()->role->value . '.seances.index')->with('success', 'Séance mise à jour.');
    }

    public function destroy(Seance $seance)
    {
        if ($seance->reservations()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette séance car elle contient des réservations.');
        }

        $seance->delete();
        return redirect()->route(auth()->user()->role->value . '.seances.index')->with('success', 'Séance supprimée.');
    }

    /**
     * Exporter toutes les séances en PDF.
     */
    public function exportPdf()
    {
        $seances = Seance::with(['moniteur.user', 'formation'])->orderBy('date')->get();
        $pdf = Pdf::loadView('seances.pdf', compact('seances'))->setPaper('a4', 'landscape');
        return $pdf->download('seances_' . now()->format('Y-m-d') . '.pdf');
    }
}
