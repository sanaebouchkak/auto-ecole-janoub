<x-app-layout>
    <div class="py-12 bg-emerald-50 min-h-screen flex items-center">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-white rounded-3xl shadow-2xl p-10 transform transition-all">
                <div class="h-24 w-24 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                
                <h2 class="text-3xl font-extrabold text-slate-900 mb-4 font-display">Paiement Réussi !</h2>
                <p class="text-slate-500 text-lg mb-10">
                    Merci pour votre confiance. Votre réservation pour la formation <strong class="text-slate-900">"{{ $paiement->formation->nom }}"</strong> est maintenant confirmée.
                </p>

                <div class="space-y-4">
                    <a href="{{ route('candidat.paiements.invoice', $paiement) }}" class="w-full inline-flex justify-center items-center px-6 py-4 bg-slate-900 border border-transparent rounded-2xl font-bold text-white uppercase tracking-widest hover:bg-indigo-600 transition shadow-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Télécharger ma facture PDF
                    </a>
                    
                    <a href="{{ route('candidat.dashboard') }}" class="w-full inline-flex justify-center items-center px-6 py-4 bg-white border-2 border-slate-200 rounded-2xl font-bold text-slate-600 uppercase tracking-widest hover:bg-slate-50 transition">
                        Retour au tableau de bord
                    </a>
                </div>

                <div class="mt-10 pt-10 border-t border-slate-100">
                    <p class="text-sm text-slate-400 italic">
                        Un email de confirmation vous a été envoyé à {{ auth()->user()->email }}.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
