<x-app-layout>
    <x-slot name="header">
        {{ isset($formation) ? 'Modifier la formation' : 'Créer une formation' }}
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ isset($formation) ? route('admin.formations.update', $formation) : route('admin.formations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if(isset($formation)) @method('PUT') @endif

            <div class="grid grid-cols-1 gap-6">
                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom de la formation *</label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom', $formation->nom ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 focus:bg-white" required>
                    @error('nom')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 focus:bg-white">{{ old('description', $formation->description ?? '') }}</textarea>
                    @error('description')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Prix -->
                    <div>
                        <label for="prix" class="block text-sm font-medium text-gray-700 mb-2">Prix (DH) *</label>
                        <input type="number" step="0.01" name="prix" id="prix" value="{{ old('prix', $formation->prix ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 focus:bg-white" required>
                        @error('prix')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                    </div>

                    <!-- Durée -->
                    <div>
                        <label for="duree_heures" class="block text-sm font-medium text-gray-700 mb-2">Durée (Heures)</label>
                        <input type="number" name="duree_heures" id="duree_heures" value="{{ old('duree_heures', $formation->duree_heures ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 focus:bg-white">
                        @error('duree_heures')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                    </div>
                </div>

                <!-- Image -->
                <div>
                    <label for="image_path" class="block text-sm font-medium text-gray-700 mb-2">Image de la formation</label>
                    @if(isset($formation) && $formation->image_path)
                        <div class="mb-4">
                            <img src="{{ Storage::url($formation->image_path) }}" alt="" class="h-32 w-auto rounded-xl border">
                        </div>
                    @endif
                    <input type="file" name="image_path" id="image_path" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 focus:bg-white">
                    <p class="mt-1 text-xs text-gray-500">Formats acceptés : JPG, PNG. Taille max : 2MB.</p>
                    @error('image_path')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end gap-3 mt-8">
                <a href="{{ route('admin.formations.index') }}" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition shadow-sm font-medium">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2.5 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition shadow-md font-medium">
                    {{ isset($formation) ? 'Mettre à jour' : 'Enregistrer' }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
