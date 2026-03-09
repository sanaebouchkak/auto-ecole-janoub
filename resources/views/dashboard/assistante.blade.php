<x-app-layout>
    <x-slot name="header">
        Espace Gestion Assistante
    </x-slot>

    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-900">Bienvenue, {{ Auth::user()->name }} 👋</h2>
        <p class="text-slate-500 mt-2">Gérez les inscriptions, les paiements et le planning quotidien de l'auto-école.</p>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <a href="{{ route('assistante.reservations.index') }}" class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition group">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-emerald-600 group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Gérer Réservations</h3>
            <p class="text-sm text-slate-500 mt-1">Confirmer ou annuler les séances des élèves.</p>
        </a>

        <a href="{{ route('assistante.paiements.index') }}" class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition group">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Enregistrer Paiements</h3>
            <p class="text-sm text-slate-500 mt-1">Saisir les versements des nouveaux candidats.</p>
        </a>

        <a href="{{ route('assistante.seances.index') }}" class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition group">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-purple-600 group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Planning Séances</h3>
            <p class="text-sm text-slate-500 mt-1">Organiser les créneaux pour les moniteurs.</p>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Prochaines Séances -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-800">Planning Immédiat</h3>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">5 prochaines</span>
            </div>
            <div class="p-4">
                <div class="space-y-4">
                    @forelse($prochainesSeances as $seance)
                    <div class="flex items-center p-4 rounded-2xl bg-slate-50/50 hover:bg-slate-50 transition border border-transparent hover:border-slate-100">
                        <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-slate-600 font-bold mr-4 shrink-0">
                            {{ \Carbon\Carbon::parse($seance->date)->format('d') }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate">{{ optional($seance->formation)->nom }}</p>
                            <p class="text-xs text-slate-500">Avec {{ optional($seance->moniteur->user)->name }} • {{ \Carbon\Carbon::parse($seance->heure_debut)->format('H:i') }}</p>
                        </div>
                        <div class="ml-4">
                            <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-lg bg-emerald-100 text-emerald-700">Confirmé</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-center py-8 text-slate-400">Aucune séance programmée.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Dernières Réservations -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-800">Dernières Demandes</h3>
                <a href="{{ route('assistante.reservations.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 uppercase tracking-widest">Tout voir</a>
            </div>
            <div class="p-4">
                <div class="space-y-4">
                    @forelse($dernieresReservations as $res)
                    <div class="flex items-center p-4 rounded-2xl bg-slate-50/50 hover:bg-slate-50 transition border border-transparent hover:border-slate-100">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center font-bold mr-4 shrink-0 uppercase">
                            {{ substr(optional($res->candidat->user)->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate">{{ optional($res->candidat->user)->name }}</p>
                            <p class="text-xs text-slate-500">{{ optional($res->seance->formation)->nom }} • {{ \Carbon\Carbon::parse($res->created_at)->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center py-8 text-slate-400">Aucune réservation récente.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
