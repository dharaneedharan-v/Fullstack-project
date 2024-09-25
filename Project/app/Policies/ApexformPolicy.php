<?php

namespace App\Policies;

use App\Models\Apexform;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApexformPolicy
{
    public function viewAny(User $user): bool
    {
        return 1;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Apexform $apexForm): bool
    {
        return 1;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return ($user->role->name === 'Student');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Apexform $apexForm): bool
    {
        return 0;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Apexform $apexForm): bool
    {
        return 0;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Apexform $apexForm): bool
    {
        return 1;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Apexform $apexForm): bool
    {
        return 1;
    }
}
