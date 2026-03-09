<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\UserRole;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [UserRole::ADMIN, UserRole::ASSISTANTE]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->role === UserRole::ADMIN || $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::ADMIN || $user->role === UserRole::ASSISTANTE;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->role === UserRole::ADMIN || $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->role === UserRole::ADMIN;
    }
}
