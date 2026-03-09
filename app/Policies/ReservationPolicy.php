<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use App\Enums\UserRole;

class ReservationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Tous les rôles ont une vue index (filtrée par le controller)
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reservation $reservation): bool
    {
        if (in_array($user->role, [UserRole::ADMIN, UserRole::ASSISTANTE])) {
            return true;
        }

        return $user->id === $reservation->candidat->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::CANDIDAT || in_array($user->role, [UserRole::ADMIN, UserRole::ASSISTANTE]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reservation $reservation): bool
    {
        return in_array($user->role, [UserRole::ADMIN, UserRole::ASSISTANTE]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reservation $reservation): bool
    {
        if (in_array($user->role, [UserRole::ADMIN, UserRole::ASSISTANTE])) {
            return true;
        }

        // Un candidat peut annuler seulement si c'est son propre dossier et en attente
        return $user->id === $reservation->candidat->user_id && $reservation->statut === 'en_attente';
    }
}
