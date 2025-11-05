<?php

namespace App\Policies;

use App\Models\User;

class BasePolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Tous les utilisateurs peuvent voir la liste
    }

    public function view(User $user, $model): bool
    {
        return true; // Tous les utilisateurs peuvent lire
    }

    public function create(User $user): bool
    {
        return true; // Tous les utilisateurs peuvent créer
    }

    public function update(User $user, $model): bool
    {
        return true; // Tous les utilisateurs peuvent modifier
    }

    public function delete(User $user, $model): bool
    {
        return $user->role === 'admin'; // Seul admin peut supprimer
    }

    public function restore(User $user, $model): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, $model): bool
    {
        return $user->role === 'admin';
    }
}
