<x-app-layout>
    <x-slot name="header">
        {{ isset($paiement) ? 'Modifier le paiement' : 'Enregistrer un nouveau paiement' }}
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-800">Détails de la transaction</h3>
            <p class="text-gray-500 text-sm mt-1">Saisissez les informations relatives au paiement du candidat.</p>
        </div>

        <form action="{{ isset($paiement) ? route(auth()->user()->role->value . '.paiements.update', $paiement) : route(auth()->user()->role->value . '.paiements.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($paiement)) @method('PUT') @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Choix Candidat -->
                <div class="md:col-span-2">
                    <label for="candidat_id" class="block text-sm font-medium text-gray-700 mb-2">Candidat *</label>
                    <select name="candidat_id" id="candidat_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50 focus:bg-white text-gray-700" required>
                        <option value="">-- Sélectionner un candidat --</option>
                        @foreach($candidats as $candidat)
                            <option value="{{ $candidat->id }}" {{ old('candidat_id', $paiement->candidat_id ?? '') == $candidat->id ? 'selected' : '' }}>
                                {{ optional($candidat->user)->name ?? 'Utilisateur supprimé' }} ({{ optional($candidat->user)->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('candidat_id')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <!-- Choix Formation -->
                <div class="md:col-span-2">
                    <label for="formation_id" class="block text-sm font-medium text-gray-700 mb-2">Formation payée *</label>
                    <select name="formation_id" id="formation_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50 focus:bg-white text-gray-700" required>
                        <option value="">-- Sélectionner une formation --</option>
                        @foreach($formations as $formation)
                            <option value="{{ $formation->id }}" {{ old('formation_id', $paiement->formation_id ?? '') == $formation->id ? 'selected' : '' }}>
                                {{ $formation->nom }} - Prix total: {{ number_format($formation->prix, 0) }} DH
                            </option>
                        @endforeach
                    </select>
                    @error('formation_id')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <!-- Montant -->
                <div>
                    <label for="montant" class="block text-sm font-medium text-gray-700 mb-2">Montant (DH) *</label>
                    <div class="relative">
                        <input type="number" step="0.01" name="montant" id="montant" value="{{ old('montant', $paiement->montant ?? '') }}" class="w-full pl-4 pr-12 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50 focus:bg-white" required placeholder="Ex: 1500">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-medium">DH</span>
                        </div>
                    </div>
                    @error('montant')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <!-- Date -->
                <div>
                    <label for="date_paiement" class="block text-sm font-medium text-gray-700 mb-2">Date du paiement *</label>
                    <input type="date" name="date_paiement" id="date_paiement" value="{{ old('date_paiement', isset($paiement) ? \Carbon\Carbon::parse($paiement->date_paiement)->format('Y-m-d') : date('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50 focus:bg-white" required>
                    @error('date_paiement')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <!-- Méthode -->
                <div>
                    <label for="methode_paiement" class="block text-sm font-medium text-gray-700 mb-2">Méthode de paiement *</label>
                    <select name="methode_paiement" id="methode_paiement" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50 focus:bg-white text-gray-700" required>
                        <option value="especes" {{ old('methode_paiement', $paiement->methode_paiement ?? '') == 'especes' ? 'selected' : '' }}>Espèces</option>
                        <option value="carte_bancaire" {{ old('methode_paiement', $paiement->methode_paiement ?? '') == 'carte_bancaire' ? 'selected' : '' }}>Carte bancaire</option>
                        <option value="virement" {{ old('methode_paiement', $paiement->methode_paiement ?? '') == 'virement' ? 'selected' : '' }}>Virement</option>
                        <option value="cheque" {{ old('methode_paiement', $paiement->methode_paiement ?? '') == 'cheque' ? 'selected' : '' }}>Chèque</option>
                    </select>
                    @error('methode_paiement')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <!-- Statut de l'acompte / paiement -->
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">Statut de la transaction *</label>
                    <select name="statut" id="statut" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50 focus:bg-white text-gray-700" required>
                        <option value="paye" {{ old('statut', $paiement->statut ?? '') == 'paye' ? 'selected' : '' }}>Entièrement payé</option>
                        <option value="partiel" {{ old('statut', $paiement->statut ?? '') == 'partiel' ? 'selected' : '' }}>Acompte partiel</option>
                        <option value="non_paye" {{ old('statut', $paiement->statut ?? '') == 'non_paye' ? 'selected' : '' }}>Échec / Non payé</option>
                    </select>
                    @error('statut')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end gap-3 mt-8">
                <a href="{{ route(auth()->user()->role->value . '.paiements.index') }}" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition shadow-sm font-medium">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2.5 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition shadow-md font-medium">
                    {{ isset($paiement) ? 'Mettre à jour le paiement' : 'Enregistrer le paiement' }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
