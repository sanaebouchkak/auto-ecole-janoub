<x-app-layout>
    <x-slot name="header">
        Espace Personnel
    </x-slot>

    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-900">Bonjour, {{ Auth::user()->name }} 👋</h2>
        <p class="text-slate-500 mt-2 text-lg">Heureux de vous revoir ! Voici un aperçu de votre progression.</p>
    </div>

    <!-- KPI Cards Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Heures de conduite -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-600 transition-colors group-hover:bg-emerald-600 group-hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Progression</span>
            </div>
            <h3 class="text-4xl font-black text-slate-800">{{ $heuresFaites ?? 0 }} <span class="text-base text-slate-400 font-medium">/ 20h</span></h3>
            <p class="text-slate-500 mt-1 font-medium">Heures de conduite effectuées</p>
            <!-- Progress Bar -->
            <div class="mt-4 h-2 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-500 transition-all duration-1000" style="width: {{ min(100, (($heuresFaites ?? 0) / 20) * 100) }}%"></div>
            </div>
        </div>

        <!-- Statut financier -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 group hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 rounded-2xl text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Paiements</span>
            </div>
            <h3 class="text-4xl font-black {{ ($resteAPayer ?? 0) > 0 ? 'text-orange-500' : 'text-blue-600' }}">
                {{ number_format($resteAPayer ?? 0, 0) }} <span class="text-base font-medium">DH</span>
            </h3>
            <p class="text-slate-500 mt-1 font-medium">Reste à régler</p>
            <div class="mt-4 flex items-center text-xs text-slate-400">
                <svg class="w-4 h-4 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Déjà payé : {{ number_format($totalPaye ?? 0, 0) }} DH
            </div>
        </div>

        <!-- Prochaine séance -->
        <div class="bg-slate-900 p-6 rounded-3xl shadow-lg border border-slate-800 text-white group hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-slate-800 rounded-2xl text-emerald-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Rappel</span>
            </div>
            @if($prochaineSeance)
                <h3 class="text-2xl font-black truncate">{{ \Carbon\Carbon::parse($prochaineSeance->seance->date)->translatedFormat('l d F') }}</h3>
                <p class="text-emerald-400 font-bold mt-1">{{ \Carbon\Carbon::parse($prochaineSeance->seance->heure_debut)->format('H:i') }} • {{ optional($prochaineSeance->seance->formation)->nom }}</p>
            @else
                <h3 class="text-2xl font-black">Aucune séance</h3>
                <p class="text-slate-400 mt-1 font-medium text-sm">Prévoyez votre prochain cours dès maintenant.</p>
            @endif
            <div class="mt-6">
                <a href="{{ route('candidat.reservations.create') }}" class="inline-flex items-center text-sm font-bold text-white hover:text-emerald-400 transition">
                    Réserver une séance 
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Planning -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-bold text-slate-800">Accès Rapide</h3>
            </div>
            <div class="space-y-4">
                <a href="{{ route('candidat.reservations.index') }}" class="flex items-center p-4 rounded-2xl bg-emerald-50 border border-emerald-100 group hover:bg-emerald-600 transition-all duration-300">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-emerald-600 mr-4 shadow-sm group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-slate-800 group-hover:text-white">Consulter mon planning</h4>
                        <p class="text-sm text-slate-500 group-hover:text-emerald-100">Suivi détaillé de vos rendez-vous</p>
                    </div>
                </a>

                <a href="{{ route('candidat.paiements.index') }}" class="flex items-center p-4 rounded-2xl bg-blue-50 border border-blue-100 group hover:bg-blue-600 transition-all duration-300">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-blue-600 mr-4 shadow-sm group-hover:bg-blue-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-slate-800 group-hover:text-white">Suivi des paiements</h4>
                        <p class="text-sm text-slate-500 group-hover:text-blue-100">Historique complet de vos règlements</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Illustration/Stats -->
        <div class="bg-gradient-to-br from-emerald-600 to-slate-900 rounded-3xl shadow-xl p-8 text-white relative overflow-hidden flex items-center">
            <div class="relative z-10">
                <h3 class="text-3xl font-black mb-4">Prêt pour l'examen ?</h3>
                <p class="text-emerald-100 text-lg leading-relaxed mb-8">N'oubliez pas que la régularité est la clé de la réussite. <br> Planifiez au moins 2 séances par semaine.</p>
                <div class="flex gap-4">
                    <span class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-full text-xs font-bold border border-white/20">Accompagnement Premium</span>
                    <span class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-full text-xs font-bold border border-white/20">Suivi 24h/24</span>
                </div>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-emerald-400/20 rounded-full blur-3xl"></div>
        </div>
    </div>
</x-app-layout>
