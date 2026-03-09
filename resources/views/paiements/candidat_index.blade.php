<x-app-layout>
    <x-slot name="header">
        Mes Paiements
    </x-slot>

    <!-- Résumé financier -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total formation(s)</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($totalAPayer ?? 0, 0) }} <span class="text-lg">DH</span></p>
            </div>
            <div class="p-4 bg-emerald-50 rounded-xl text-emerald-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Déjà payé</p>
                <p class="text-3xl font-bold text-emerald-600">{{ number_format($totalPaye ?? 0, 0) }} <span class="text-lg">DH</span></p>
            </div>
            <div class="p-4 bg-emerald-50 rounded-xl text-emerald-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border {{ ($resteAPayer ?? 0) > 0 ? 'border-orange-200' : 'border-emerald-100' }} flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Reste à payer</p>
                <p class="text-3xl font-bold {{ ($resteAPayer ?? 0) > 0 ? 'text-orange-500' : 'text-emerald-500' }}">{{ number_format($resteAPayer ?? 0, 0) }} <span class="text-lg">DH</span></p>
            </div>
            <div class="p-4 {{ ($resteAPayer ?? 0) > 0 ? 'bg-orange-50 text-orange-500' : 'bg-emerald-50 text-emerald-600' }} rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Historique -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800">Historique des transactions</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Formation</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Montant</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Méthode</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($paiements as $paiement)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                            {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ optional($paiement->formation)->nom ?? 'Non spécifiée' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                            {{ number_format($paiement->montant, 2) }} DH
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 uppercase">
                            {{ $paiement->methode_paiement }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($paiement->statut === 'paye')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">Payé</span>
                            @elseif($paiement->statut === 'partiel')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Partiel</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Non payé</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Aucune transaction enregistrée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
