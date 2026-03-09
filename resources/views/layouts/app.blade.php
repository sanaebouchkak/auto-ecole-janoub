<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Auto-École Dashboard') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
</head>
<body class="h-full font-sans antialiased text-gray-900 overflow-hidden" x-data="{ sidebarOpen: false }">
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-auto flex flex-col shadow-xl">
            <div class="flex items-center justify-center h-16 bg-slate-950 border-b border-slate-800 px-4">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-emerald-500 uppercase tracking-wider flex items-center gap-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    AutoecoleJANOUB
                </a>
            </div>
            <nav class="flex-1 px-3 py-6 space-y-1.5 overflow-y-auto">
                <!-- ACCUEIL (Dynamique selon rôle) -->
                @php
                    $dashboardRoute = match(Auth::user()->role) {
                        \App\Enums\UserRole::ADMIN => 'admin.dashboard',
                        \App\Enums\UserRole::ASSISTANTE => 'assistante.dashboard',
                        \App\Enums\UserRole::MONITEUR => 'moniteur.dashboard',
                        \App\Enums\UserRole::CANDIDAT => 'candidat.dashboard',
                        default => 'dashboard'
                    };
                @endphp
                <a href="{{ route($dashboardRoute) }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition group {{ request()->routeIs('*.dashboard') || request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Tableau de Bord
                </a>

                <!-- SIDEBAR ADMIN -->
                @if(Auth::user()->isAdmin())
                <div class="pt-4 pb-2"><p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Administration</p></div>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition group {{ request()->routeIs('admin.users.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Utilisateurs & Staff
                </a>
                <a href="{{ route('admin.formations.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition group {{ request()->routeIs('admin.formations.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    Formations
                </a>
                <a href="{{ route('admin.seances.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition group {{ request()->routeIs('admin.seances.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                    Séances
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition group {{ request()->routeIs('admin.reservations.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Toutes les Réservations
                </a>
                <a href="{{ route('admin.paiements.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition group {{ request()->routeIs('admin.paiements.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Paiements
                </a>
                @endif

                <!-- SIDEBAR ASSISTANTE -->
                @if(Auth::user()->isAssistante())
                <div class="pt-4 pb-2"><p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Gestion Bureau</p></div>
                <a href="{{ route('assistante.seances.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition group {{ request()->routeIs('assistante.seances.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                    Planning Séances
                </a>
                <a href="{{ route('assistante.reservations.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition group {{ request()->routeIs('assistante.reservations.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Réservations
                </a>
                <a href="{{ route('assistante.paiements.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition group {{ request()->routeIs('assistante.paiements.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Enregistrer Paiements
                </a>
                @endif

                <!-- SIDEBAR MONITEUR -->
                @if(Auth::user()->isMoniteur())
                <div class="pt-4 pb-2"><p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Espace Moniteur</p></div>
                <a href="{{ route('moniteur.planning') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition group {{ request()->routeIs('moniteur.planning') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                    Mon Planning
                </a>
                @endif

                <!-- SIDEBAR CANDIDAT -->
                @if(Auth::user()->isCandidat())
                <div class="pt-4 pb-2"><p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Mon Parcours</p></div>
                <a href="{{ route('candidat.formations') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition group {{ request()->routeIs('candidat.formations') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    Nos Formations
                </a>
                <a href="{{ route('candidat.reservations.create') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition group {{ request()->routeIs('candidat.reservations.create') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Réserver
                </a>
                <a href="{{ route('candidat.reservations.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition group {{ request()->routeIs('candidat.reservations.index') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                    Mon Planning
                </a>
                <a href="{{ route('candidat.paiements.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition group {{ request()->routeIs('candidat.paiements.index') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300' }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Mes Paiements
                </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden relative">
            <!-- Topbar -->
            <header class="h-16 bg-white shadow-sm border-b border-gray-100 flex items-center justify-between px-4 sm:px-6 z-10 w-full">
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 hover:text-gray-700 bg-gray-100 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="hidden md:flex flex-1 items-center">
                    <h2 class="text-xl font-bold text-gray-800">{{ $header ?? '' }}</h2>
                </div>
                <div class="flex items-center space-x-4 ml-auto">
                    @if(Auth::user())
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="text-sm font-semibold text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600 hidden sm:block">{{ Auth::user()->role->label() }}</span>
                    </div>
                    @endif
                    <div class="h-6 w-px bg-gray-200"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-red-600 font-medium transition flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span class="hidden sm:inline">Déconnexion</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 sm:p-6 lg:p-8">
                <!-- Flash messages -->
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl shadow-sm flex items-center justify-between" role="alert">
                        <span class="block sm:inline font-medium flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                            {{ session('success') }}
                        </span>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
        
        <!-- Mobile overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900 bg-opacity-50 z-40 md:hidden transition-opacity"></div>
    </div>
    @stack('scripts')
</body>
</html>
