<?php

namespace App\Policies;

use App\Models\Admin;

class AdminPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $authAdmin): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $authAdmin, Admin $admin): bool
    {
        return $authAdmin->id === $admin->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $authAdmin, Admin $admin): bool
    {
        return $authAdmin->id === $admin->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $authAdmin): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $authAdmin): bool
    {
        return false;
    }
}
