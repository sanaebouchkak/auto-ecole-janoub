<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Formation;
use Barryvdh\DomPDF\Facade\Pdf;

class FormationController extends Controller {
    public function index() {
        return view('formations.index', ['formations' => Formation::all()]);
    }
    public function create() {
        return view('formations.form');
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'duree_heures' => 'nullable|integer',
            'image_path' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('formations', 'public');
        }
        Formation::create($validated);
        return redirect()->route('admin.formations.index')->with('success', 'Formation ajoutée avec succès.');
    }
    public function edit(Formation $formation) {
        return view('formations.form', compact('formation'));
    }
    public function update(Request $request, Formation $formation) {
        $validated = $request->validate([
            'nom' => 'required',
            'description' => 'nullable',
            'prix' => 'required|numeric',
            'duree_heures' => 'nullable|integer',
            'image_path' => 'nullable|image',
        ]);
        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('images', 'public');
        }
        $formation->update($validated);
        return redirect()->route('admin.formations.index')->with('success', 'Formation modifiée');
    }
    public function destroy(Formation $formation) {
        $formation->delete();
        return redirect()->route('admin.formations.index')->with('success', 'Formation supprimée');
    }

    /**
     * Exporter toutes les formations en PDF.
     */
    public function exportPdf()
    {
        $formations = Formation::all();
        $pdf = Pdf::loadView('formations.pdf', compact('formations'));
        return $pdf->download('formations_' . now()->format('Y-m-d') . '.pdf');
    }
}
