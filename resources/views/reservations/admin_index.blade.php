<x-app-layout>
    <x-slot name="header">
        Gestion des Réservations
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Toutes les réservations</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Candidat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Formation</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date & Heure</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reservations as $reservation)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ optional($reservation->candidat->user)->name ?? 'Utilisateur supprimé' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600">{{ optional($reservation->seance->formation)->nom ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse(optional($reservation->seance)->date)->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse(optional($reservation->seance)->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse(optional($reservation->seance)->heure_fin)->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($reservation->statut === 'en_attente')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                            @elseif($reservation->statut === 'confirmee')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">Confirmée</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Annulée</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2">
                            @if($reservation->statut === 'en_attente')
                            <form action="{{ route(auth()->user()->role->value . '.reservations.updateStatus', $reservation) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="statut" value="confirmee">
                                <button type="submit" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 px-3 py-1 rounded transition">Valider</button>
                            </form>
                            <form action="{{ route(auth()->user()->role->value . '.reservations.updateStatus', $reservation) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="statut" value="annulee">
                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded transition">Refuser</button>
                            </form>
                            @else
                            <span class="text-gray-400 text-xs italic">Aucune action</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Aucune réservation trouvée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $reservations->links() }}
        </div>
    </div>
</x-app-layout>
