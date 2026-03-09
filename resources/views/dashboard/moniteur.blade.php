<x-app-layout>
    <x-slot name="header">
        Espace Moniteur
    </x-slot>

    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-900">Bienvenue, {{ Auth::user()->name }} 🚗</h2>
        <p class="text-slate-500 mt-2">Voici votre planning de conduite pour les jours à venir.</p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Séances terminées</p>
            <h3 class="text-3xl font-black text-emerald-600 mt-1">{{ $totalHeures ?? 0 }}</h3>
            <p class="text-sm text-slate-500 mt-1">Total des cours assurés</p>
        </div>
        
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">À venir</p>
            <h3 class="text-3xl font-black text-blue-600 mt-1">{{ $seances->count() }}</h3>
            <p class="text-sm text-slate-500 mt-1">Séances programmées</p>
        </div>
    </div>

    <!-- Planning Moniteur -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50">
            <h3 class="text-xl font-bold text-slate-800">Votre Planning</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Date & Heure</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Formation</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Élève(s)</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Statut</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-50">
                    @forelse($seances as $seance)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($seance->date)->format('d/m/Y') }}</div>
                            <div class="text-sm text-slate-500 font-medium">{{ \Carbon\Carbon::parse($seance->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($seance->heure_fin)->format('H:i') }}</div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <span class="text-sm font-bold text-slate-700">{{ optional($seance->formation)->nom }}</span>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            @forelse($seance->reservations as $res)
                                <div class="flex items-center mb-1 last:mb-0">
                                    <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-600 mr-2">
                                        {{ substr(optional($res->candidat->user)->name ?? '?', 0, 1) }}
                                    </div>
                                    <span class="text-sm text-slate-600">{{ optional($res->candidat->user)->name ?? 'Anonyme' }}</span>
                                </div>
                            @empty
                                <span class="text-xs text-slate-400 italic">Aucun élève inscrit</span>
                            @endforelse
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            @if($seance->statut === 'disponible')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-emerald-100 text-emerald-700">Disponible</span>
                            @elseif($seance->statut === 'reservee')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-700">Confirmée</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-slate-100 text-slate-700">Terminée</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center text-slate-400">
                            Aucune séance programmée pour vous.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
