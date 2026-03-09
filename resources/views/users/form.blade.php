<x-app-layout>
    <x-slot name="header">
        {{ isset($user) ? 'Modifier l\'utilisateur : ' . $user->name : 'Ajouter un Utilisateur' }}
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-800">Informations de l'utilisateur</h3>
            <p class="text-gray-500 text-sm mt-1">Veuillez remplir les informations requises pour ce compte.</p>
        </div>

        <form action="{{ isset($user) ? route(auth()->user()->role->value . '.users.update', $user) : route(auth()->user()->role->value . '.users.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($user)) @method('PUT') @endif
            
            <input type="hidden" name="user_type" value="{{ request('type') ?? 'candidat' }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nom Complet -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50 focus:bg-white" required>
                    @error('name')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <!-- Téléphone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50 focus:bg-white" required>
                    @error('phone')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <!-- Email Address -->
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50 focus:bg-white" required>
                    @error('email')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe {{ isset($user) ? '(Laisser vide pour ne pas modifier)' : '*' }}</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50 focus:bg-white" {{ !isset($user) ? 'required' : '' }}>
                    @error('password')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                </div>

                <!-- Rôle / Formation (Conditionnel) -->
                <div>
                    @if(request('type') === 'staff' || (isset($user) && !$user->isCandidat()))
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rôle Staff *</label>
                        <select name="role" id="role" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50 focus:bg-white" required>
                            @foreach(\App\Enums\UserRole::cases() as $role)
                                @if($role !== \App\Enums\UserRole::CANDIDAT)
                                    <option value="{{ $role->value }}" {{ old('role', $user->role->value ?? '') == $role->value ? 'selected' : '' }}>
                                        {{ $role->label() }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('role')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                    @else
                        <!-- Optionnel: Sélection d'une formation si c'est un candidat -->
                        <label for="formation_id" class="block text-sm font-medium text-gray-700 mb-2">Formation en cours</label>
                        <select name="formation_id" id="formation_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50 focus:bg-white">
                            <option value="">-- Aucune formation sélectionnée --</option>
                            @foreach(\App\Models\Formation::all() as $formation)
                                <option value="{{ $formation->id }}" {{ (isset($user->candidat) && $user->candidat->formations->contains($formation->id)) ? 'selected' : '' }}>
                                    {{ $formation->nom }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <!-- Statut de l'utilisateur -->
                <div class="md:col-span-2">
                    <label class="flex items-center space-x-3 cursor-pointer mt-4">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="form-checkbox h-5 w-5 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
                        <span class="text-gray-900 font-medium">Compte Actif (Autoriser la connexion)</span>
                    </label>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end gap-3 mt-8">
                <a href="{{ route(auth()->user()->role->value . '.users.index') }}" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition shadow-sm font-medium">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2.5 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition shadow-md font-medium">
                    {{ isset($user) ? 'Enregistrer les modifications' : 'Créer l\'utilisateur' }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
