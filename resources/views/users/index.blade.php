<x-app-layout>
    <x-slot name="header">
        Gestion des Utilisateurs
    </x-slot>

    <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Candidats & Staff</h2>
        <div class="flex gap-3">
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.users.exportPdf') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Télécharger PDF
            </a>
            @endif
            <a href="{{ route(auth()->user()->role->value . '.users.create') }}?type=candidat" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Ajouter Candidat
            </a>
            <a href="{{ route(auth()->user()->role->value . '.users.create') }}?type=staff" class="inline-flex items-center px-4 py-2 bg-slate-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Ajouter Staff
            </a>
        </div>
    </div>

    <!-- Filtres de recherche -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <form action="{{ route(auth()->user()->role->value . '.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 w-full relative">
                <label for="search" class="sr-only">Rechercher</label>
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Rechercher par nom, email ou téléphone...">
            </div>
            <div class="w-full md:w-48">
                <select name="role" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-xl">
                    <option value="">Tous les rôles</option>
                    <option value="candidat" {{ request('role') == 'candidat' ? 'selected' : '' }}>Candidats</option>
                    <option value="assistante" {{ request('role') == 'assistante' ? 'selected' : '' }}>Assistantes</option>
                    <option value="moniteur" {{ request('role') == 'moniteur' ? 'selected' : '' }}>Moniteurs</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateurs</option>
                </select>
            </div>
            <button type="submit" class="w-full md:w-auto px-6 py-2 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-slate-900 hover:bg-slate-800 transition">Filtrer</button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Utilisateur</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Contact</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rôle</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 relative">
                                    <div class="h-10 w-10 rounded-full bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center text-lg">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    @if($user->is_active)
                                    <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-green-400 ring-2 ring-white"></span>
                                    @else
                                    <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-400 ring-2 ring-white"></span>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">Inscrit le {{ $user->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 flex items-center gap-1">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $user->email }}
                            </div>
                            <div class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $user->phone ?? 'Non renseigné' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->isAdmin())
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Administrateur</span>
                            @elseif($user->isAssistante())
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Assistante</span>
                            @elseif($user->isMoniteur())
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Moniteur</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">Candidat</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->is_active)
                                <span class="px-2 inline-flex items-center text-xs font-semibold text-green-600">Actif</span>
                            @else
                                <span class="px-2 inline-flex items-center text-xs font-semibold text-red-600">Désactivé</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route(auth()->user()->role->value . '.users.edit', $user) }}" class="text-slate-600 hover:text-emerald-600 transition" title="Modifier">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                @if(Auth::id() !== $user->id)
                                <form action="{{ route(auth()->user()->role->value . '.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Attention ! Supprimer cet utilisateur supprimera également toutes ses réservations et paiements. Continuer ?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Supprimer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun utilisateur trouvé</h3>
                            <p class="mt-1 text-sm text-gray-500">Essayez de modifier vos critères de recherche.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(method_exists($users, 'hasPages') && $users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ collect($users)->isEmpty() ? '' : $users->withQueryString()->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
