<x-app-layout>
    <x-slot name="header">
        {{ isset($seance) ? 'Modifier la séance' : 'Programmer une séance' }}
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ isset($seance) ? route(auth()->user()->role->value . '.seances.update', $seance) : route(auth()->user()->role->value . '.seances.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($seance)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Moniteur -->
                <div>
                    <label for="moniteur_id" class="block text-sm font-medium text-gray-700 mb-2">Moniteur *</label>
                    <select name="moniteur_id" id="moniteur_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 focus:bg-white text-gray-700" required>
                        <option value="">-- Sélectionner un moniteur --</option>
                        @foreach($moniteurs as $moniteur)
                            <option value="{{ $moniteur->id }}" {{ old('moniteur_id', $seance->moniteur_id ?? '') == $moniteur->id ? 'selected' : '' }}>
                                {{ optional($moniteur->user)->name ?? 'Indéfini' }}
                            </option>
                        @endforeach
                    </select>
                    @error('moniteur_id')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

                <!-- Formation -->
                <div>
                    <label for="formation_id" class="block text-sm font-medium text-gray-700 mb-2">Formation concernée *</label>
                    <select name="formation_id" id="formation_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 focus:bg-white text-gray-700" required>
                        <option value="">-- Sélectionner une formation --</option>
                        @foreach($formations as $formation)
                            <option value="{{ $formation->id }}" {{ old('formation_id', $seance->formation_id ?? '') == $formation->id ? 'selected' : '' }}>
                                {{ $formation->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('formation_id')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                    <input type="date" name="date" id="date" value="{{ old('date', $seance->date ?? date('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 focus:bg-white" required>
                    @error('date')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

                <!-- Statut -->
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">Statut *</label>
                    <select name="statut" id="statut" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 focus:bg-white text-gray-700" required>
                        <option value="disponible" {{ old('statut', $seance->statut ?? '') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="reservee" {{ old('statut', $seance->statut ?? '') == 'reservee' ? 'selected' : '' }}>Réservée</option>
                        <option value="terminee" {{ old('statut', $seance->statut ?? '') == 'terminee' ? 'selected' : '' }}>Terminée</option>
                    </select>
                    @error('statut')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

                <!-- Heure Debut -->
                <div>
                    <label for="heure_debut" class="block text-sm font-medium text-gray-700 mb-2">Heure de début *</label>
                    <input type="time" name="heure_debut" id="heure_debut" value="{{ old('heure_debut', $seance->heure_debut ?? '09:00') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 focus:bg-white" required>
                    @error('heure_debut')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

                <!-- Heure Fin -->
                <div>
                    <label for="heure_fin" class="block text-sm font-medium text-gray-700 mb-2">Heure de fin *</label>
                    <input type="time" name="heure_fin" id="heure_fin" value="{{ old('heure_fin', $seance->heure_fin ?? '10:00') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 focus:bg-white" required>
                    @error('heure_fin')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end gap-3 mt-8">
                <a href="{{ route(auth()->user()->role->value . '.seances.index') }}" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition shadow-sm font-medium">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2.5 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition shadow-md font-medium">
                    {{ isset($seance) ? 'Mettre à jour' : 'Programmer la séance' }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
