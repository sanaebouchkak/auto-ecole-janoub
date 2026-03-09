<x-app-layout>
    <x-slot name="header">
        Mon Planning & Suivi
    </x-slot>

    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900">Calendrier des cours</h2>
            <p class="text-slate-500 mt-1">Retrouvez ici toutes vos séances réservées et leur avancement.</p>
        </div>
        <a href="{{ route('candidat.reservations.create') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 border border-transparent rounded-2xl font-bold text-sm text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-emerald-300 transition-all duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Réserver un nouveau cours
        </a>
    </div>

    <!-- Reservations Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Date & Heure</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Formation</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Moniteur</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Statut</th>
                        <th class="px-8 py-5 text-right text-xs font-bold text-slate-400 uppercase tracking-widest">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-50">
                    @forelse($reservations ?? [] as $reservation)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-slate-100 rounded-2xl flex flex-col items-center justify-center text-slate-600 mr-4 group-hover:bg-white group-hover:shadow-sm transition-all">
                                    <span class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse(optional($reservation->seance)->date)->translatedFormat('M') }}</span>
                                    <span class="text-lg font-black leading-none">{{ \Carbon\Carbon::parse(optional($reservation->seance)->date)->format('d') }}</span>
                                </div>
                                <div class="text-sm">
                                    <div class="font-bold text-slate-800">{{ \Carbon\Carbon::parse(optional($reservation->seance)->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse(optional($reservation->seance)->heure_fin)->format('H:i') }}</div>
                                    <div class="text-slate-400">{{ \Carbon\Carbon::parse(optional($reservation->seance)->date)->translatedFormat('l') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                {{ optional(optional($reservation->seance)->formation)->nom ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-black mr-2">
                                    {{ substr(optional(optional(optional($reservation->seance)->moniteur)->user)->name ?? '?', 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-slate-600">{{ optional(optional(optional($reservation->seance)->moniteur)->user)->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            @if($reservation->statut === 'en_attente')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                                    <svg class="w-3 h-3 mr-1 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                    En attente
                                </span>
                            @elseif($reservation->statut === 'confirmee')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    <svg class="w-3 h-3 mr-1 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Confirmée
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-700 border border-red-200">
                                    <svg class="w-3 h-3 mr-1 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                    Annulée
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right">
                            @if($reservation->statut === 'en_attente')
                            <form action="{{ route('candidat.reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('Souhaitez-vous vraiment annuler cette réservation ?');" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors bg-slate-50 hover:bg-red-50 rounded-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                            @else
                                <span class="text-xs font-medium text-slate-400 italic">Historique</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800">Aucune réservation</h3>
                                <p class="text-slate-500 mt-1 max-w-xs mx-auto">Vous n'avez pas encore de séances prévues. Commencez par en réserver une !</p>
                                <a href="{{ route('candidat.reservations.create') }}" class="mt-6 px-6 py-2 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-slate-800 transition">Réserver maintenant</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
