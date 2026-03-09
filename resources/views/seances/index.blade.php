<x-app-layout>
    <x-slot name="header">
        Planning des Séances
    </x-slot>

    <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
        <h2 class="text-2xl font-bold text-slate-800">Toutes les séances</h2>
        <div class="flex gap-3">
        @if(Auth::user()->isAdmin() || Auth::user()->isAssistante())
        <a href="{{ route(auth()->user()->role->value . '.seances.exportPdf') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Exporter PDF
        </a>
        <a href="{{ route(auth()->user()->role->value . '.seances.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Nouvelle séance
        </a>
        @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date & Heure</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Formation</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Moniteur</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($seances as $seance)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($seance->date)->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($seance->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($seance->heure_fin)->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                            {{ optional($seance->formation)->nom }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600 mr-2">
                                    {{ substr(optional(optional($seance->moniteur)->user)->name ?? '?', 0, 1) }}
                                </div>
                                <span class="text-sm text-slate-600 font-medium">{{ optional(optional($seance->moniteur)->user)->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($seance->statut === 'disponible')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">Disponible</span>
                            @elseif($seance->statut === 'reservee')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Réservée</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Terminée</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if(Auth::user()->isAdmin() || Auth::user()->isAssistante())
                            <div class="flex justify-end gap-3">
                                <a href="{{ route(auth()->user()->role->value . '.seances.edit', $seance) }}" class="p-1.5 text-slate-400 hover:text-emerald-600 transition bg-slate-50 hover:bg-emerald-50 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route(auth()->user()->role->value . '.seances.destroy', $seance) }}" method="POST" onsubmit="return confirm('Supprimer cette séance ?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-500 transition bg-slate-50 hover:bg-red-50 rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                            @else
                            <span class="text-xs text-slate-400 italic">Lecture seule</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            Aucune séance programmée.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $seances->links() }}
        </div>
    </div>
</x-app-layout>
