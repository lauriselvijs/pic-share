<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\AdminRole;

class AdminService
{
    /**
     * Store admin in database.
     *
     * @param array<string, mixed> $adminData
     * @return Admin
     */
    public function store(array $adminData): Admin
    {
        $role = AdminRole::where('role', $adminData['role'])->first();

        unset($adminData["role"]);

        $admin = Admin::create($adminData);
        $admin->roles()->attach($role->id);
        $admin->refresh();

        return $admin;
    }

    /**
     * Update admin
     *
     * @param array<string, mixed> $adminData
     * @param Admin $admin
     * @return Admin
     */
    public function update(array $adminData, Admin $admin): Admin
    {
        $role = $adminData['role'];

        if ($admin->roles()->where('role', $role)->doesntExist()) {
            $newRole = AdminRole::where('role', $role)->first();
            $admin->roles()->syncWithoutDetaching([$newRole->id]);
            $admin->refresh();
        }

        unset($adminData['role']);
        $admin->update($adminData);

        return $admin;
    }
}
