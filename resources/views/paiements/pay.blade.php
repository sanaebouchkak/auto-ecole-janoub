<x-app-layout>
    <x-slot name="header">
        Paiement Sécurisé
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Détails de la commande -->
                <div class="order-2 md:order-1">
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                        <h3 class="text-xl font-bold text-slate-800 mb-6 font-display">Résumé de votre réservation</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <div class="h-12 w-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mr-4 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.246 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Formation</p>
                                    <p class="text-slate-900 font-bold">{{ $paiement->formation->nom }}</p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <div class="h-12 w-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mr-4 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Date</p>
                                    <p class="text-slate-900 font-bold">{{ now()->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-slate-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-slate-500">Sous-total</span>
                                <span class="font-bold text-slate-800">{{ number_format($paiement->montant, 2) }} DH</span>
                            </div>
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-slate-500">Frais de service</span>
                                <span class="text-emerald-500 font-bold italic">Gratuit</span>
                            </div>
                            <div class="flex justify-between items-center bg-slate-900 text-white p-6 rounded-2xl shadow-lg">
                                <span class="text-slate-400 font-medium">Total à payer</span>
                                <span class="text-3xl font-extrabold">{{ number_format($paiement->montant, 2) }} DH</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulaire de paiement -->
                <div class="order-1 md:order-2">
                    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8 overflow-hidden relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -mr-16 -mt-16 opacity-50"></div>
                        
                        <div class="relative">
                            <div class="flex items-center justify-between mb-8">
                                <h3 class="text-xl font-bold text-slate-800 font-display">Paiement par carte</h3>
                                <div class="flex space-x-2">
                                    <img src="https://img.icons8.com/color/48/visa.png" class="h-8 shadow-sm rounded border border-slate-100" alt="Visa">
                                    <img src="https://img.icons8.com/color/48/mastercard.png" class="h-8 shadow-sm rounded border border-slate-100" alt="Mastercard">
                                </div>
                            </div>

                            <form action="{{ route('candidat.paiements.success', $paiement) }}" method="POST" class="space-y-6">
                                @csrf
                                
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2" for="card_name">Nom sur la carte</label>
                                    <input type="text" id="card_name" placeholder="M. MOHAMED AMINE" class="w-full px-5 py-4 bg-slate-50 border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 font-medium transition" required>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2" for="card_number">Numéro de carte</label>
                                    <div class="relative">
                                        <input type="text" id="card_number" placeholder="4532 **** **** ****" class="w-full px-5 py-4 bg-slate-50 border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 font-medium transition" required maxlength="19">
                                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                            <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2" for="card_exp">Expiration</label>
                                        <input type="text" id="card_exp" placeholder="MM / YY" class="w-full px-5 py-4 bg-slate-50 border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 font-medium transition" required maxlength="5">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2" for="card_cvv">CVV</label>
                                        <input type="text" id="card_cvv" placeholder="***" class="w-full px-5 py-4 bg-slate-50 border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 font-medium transition" required maxlength="3">
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="w-full group relative flex justify-center py-5 px-4 border border-transparent rounded-2xl text-white bg-indigo-600 hover:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform font-bold text-lg shadow-lg hover:shadow-2xl">
                                        <span class="mr-2">Payer {{ number_format($paiement->montant, 2) }} DH</span>
                                        <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </button>
                                </div>
                            </form>
                            
                            <p class="mt-8 text-center text-xs text-slate-400">
                                <span class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                    Cryptage SSL 256 bits – Paiement 100% Sécurisé
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
