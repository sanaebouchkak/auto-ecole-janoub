<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate : Accès exclusif Admin
        \Illuminate\Support\Facades\Gate::define('access-admin', function (\App\Models\User $user) {
            return $user->role === \App\Enums\UserRole::ADMIN;
        });

        // Gate : Accès exclusif Assistante
        \Illuminate\Support\Facades\Gate::define('access-assistante', function (\App\Models\User $user) {
            return $user->role === \App\Enums\UserRole::ASSISTANTE;
        });

        // Gate : Gestion des utilisateurs (Admin + Assistante pour les candidats)
        \Illuminate\Support\Facades\Gate::define('manage-users', function (\App\Models\User $user) {
            return in_array($user->role, [\App\Enums\UserRole::ADMIN, \App\Enums\UserRole::ASSISTANTE]);
        });

        // Gate : Gestion des formations (Admin uniquement)
        \Illuminate\Support\Facades\Gate::define('manage-formations', function (\App\Models\User $user) {
            return $user->role === \App\Enums\UserRole::ADMIN;
        });

        // Gate : Gestion des réservations (Admin + Assistante)
        \Illuminate\Support\Facades\Gate::define('manage-reservations', function (\App\Models\User $user) {
            return in_array($user->role, [\App\Enums\UserRole::ADMIN, \App\Enums\UserRole::ASSISTANTE]);
        });

        // Gate : Gestion des paiements (Admin + Assistante)
        \Illuminate\Support\Facades\Gate::define('manage-paiements', function (\App\Models\User $user) {
            return in_array($user->role, [\App\Enums\UserRole::ADMIN, \App\Enums\UserRole::ASSISTANTE]);
        });
    }
}
