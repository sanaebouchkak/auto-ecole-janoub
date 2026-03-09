<?php

namespace App\Policies;

use App\Models\Paiement;
use App\Models\User;
use App\Enums\UserRole;

class PaiementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Index filtré par rôle dans le controller
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Paiement $paiement): bool
    {
        if (in_array($user->role, [UserRole::ADMIN, UserRole::ASSISTANTE])) {
            return true;
        }

        return $user->id === $paiement->candidat->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::ADMIN, UserRole::ASSISTANTE]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Paiement $paiement): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Paiement $paiement): bool
    {
        return $user->role === UserRole::ADMIN;
    }
}
