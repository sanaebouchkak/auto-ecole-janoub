<x-app-layout>
    <x-slot name="header">
        Réserver une séance
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Nouvelle Réservation</h3>
        <form action="{{ route('candidat.reservations.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Choisissez une séance disponible</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($seances as $seance)
                    <label class="relative flex items-start p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 focus-within:ring-2 focus-within:ring-emerald-500">
                        <div class="flex items-center h-5">
                            <input name="seance_id" value="{{ $seance->id }}" type="radio" class="w-5 h-5 text-emerald-600 border-gray-300 focus:ring-emerald-500" required>
                        </div>
                        <div class="ml-3 flex flex-col">
                            <span class="block text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($seance->date)->format('d/m/Y') }}</span>
                            <span class="block text-sm text-gray-500">{{ \Carbon\Carbon::parse($seance->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($seance->heure_fin)->format('H:i') }}</span>
                            <span class="block text-xs text-emerald-600 font-semibold mt-1">{{ optional($seance->formation)->nom }}</span>
                        </div>
                    </label>
                    @empty
                    <div class="col-span-2 text-center text-gray-500 py-4 bg-gray-50 rounded-lg">Aucune séance disponible pour le moment.</div>
                    @endforelse
                </div>
                @error('seance_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mt-8">
                <button type="submit" class="px-8 py-3 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition w-full shadow-md" {{ $seances->isEmpty() ? 'disabled' : '' }}>
                    Confirmer la réservation
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
