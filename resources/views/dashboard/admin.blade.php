<x-app-layout>
    <x-slot name="header">
        Console d'Administration
    </x-slot>

    <!-- KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Candidats</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['total_candidats'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Staff</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['total_staff'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Réservations</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['total_reservations'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Revenus</p>
                <h3 class="text-3xl font-extrabold text-emerald-600 mt-1">{{ number_format($stats['revenus'] ?? 0, 0) }} <span class="text-base">DH</span></h3>
            </div>
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart Revenus -->
        <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                Revenus des 6 derniers mois
            </h3>
            <div class="w-full h-80 relative">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Chart Réservations -->
        <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                Réservations par Formation
            </h3>
            <div class="w-full h-80 relative flex justify-center">
                <canvas id="reservationsChart"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Graphique des Revenus (Ligne) ---
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        // Dégradé pour la zone sous la courbe
        let gradientRevenue = ctxRevenue.createLinearGradient(0, 0, 0, 400);
        gradientRevenue.addColorStop(0, 'rgba(16, 185, 129, 0.4)');
        gradientRevenue.addColorStop(1, 'rgba(16, 185, 129, 0)');

        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: {!! json_encode($labelsRevenus ?? []) !!},
                datasets: [{
                    label: 'Revenus (DH)',
                    data: {!! json_encode($dataRevenus ?? []) !!},
                    backgroundColor: gradientRevenue,
                    borderColor: '#10B981', // emerald-500
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#10B981',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1E293B',
                        padding: 12,
                        titleFont: { size: 14, family: "'Inter', sans-serif" },
                        bodyFont: { size: 14, family: "'Inter', sans-serif" },
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' DH';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [4, 4], color: '#f1f5f9', drawBorder: false },
                        ticks: {
                            font: { family: "'Inter', sans-serif" },
                            callback: function(value) { return value + ' DH'; }
                        }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { font: { family: "'Inter', sans-serif" } }
                    }
                }
            }
        });

        // --- Graphique des Réservations par Formation (Doughnut) ---
        const ctxRes = document.getElementById('reservationsChart').getContext('2d');
        const labelsFormations = {!! json_encode($labelsFormations ?? []) !!};
        const dataFormations = {!! json_encode($dataFormations ?? []) !!};

        // Si aucune donnée, on met un placeholder
        const hasData = dataFormations.length > 0 && dataFormations.reduce((a, b) => a + b, 0) > 0;
        
        new Chart(ctxRes, {
            type: 'doughnut',
            data: {
                labels: hasData ? labelsFormations : ['Aucune réservation'],
                datasets: [{
                    data: hasData ? dataFormations : [1],
                    backgroundColor: hasData ? [
                        '#10B981', // emerald
                        '#3B82F6', // blue
                        '#F59E0B', // amber
                        '#8B5CF6', // violet
                        '#EC4899', // pink
                    ] : ['#E2E8F0'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: { family: "'Inter', sans-serif", size: 13 }
                        }
                    },
                    tooltip: {
                        enabled: hasData,
                        backgroundColor: '#1E293B',
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ' : ' + context.parsed + ' réservation(s)';
                            }
                        }
                    }
                }
            }
        });
    });
    </script>
    @endpush
</x-app-layout>
