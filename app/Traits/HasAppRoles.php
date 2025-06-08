<?php

namespace App\Traits;

use App\Models\Role;
use Illuminate\Support\Collection;

trait HasAppRoles
{
    /**
     * Assign a role to the user within a specific application.
     */
    public function assignRoleWithApp(string $roleName, int $appId)
    {
        $role = Role::where('name', $roleName)
            ->where('app_id', $appId)
            ->first();

        if (!$role) {
            throw new \Exception("Role '{$roleName}' not found for app_id {$appId}");
        }

        // Avoid duplicate assignment
        if (!$this->hasRoleWithApp($roleName, $appId)) {
            $this->roles()->attach($role->id);
        }

        return $this;
    }

    /**
     * Check if the user has a role for a specific app.
     */
    public function hasRoleWithApp(string $roleName, int $appId): bool
    {
        return $this->roles()
            ->where('name', $roleName)
            ->where('app_id', $appId)
            ->exists();
    }

    /**
     * Get all role names the user has for a specific app.
     */
    public function getAppRoleNames(int $appId): Collection
    {
        return $this->roles()
            ->where('app_id', $appId)
            ->pluck('name');
    }

    /**
     * Revoke a specific role for a specific app from the user.
     */
    public function revokeRoleFromApp(string $roleName, int $appId)
    {
        $role = Role::where('name', $roleName)
            ->where('app_id', $appId)
            ->first();

        if ($role) {
            $this->roles()->detach($role->id);
        }

        return $this;
    }

    /**
     * Rename a role within a specific app (affects all users).
     */
    public function updateAppRole(string $oldRoleName, string $newRoleName, int $appId)
    {
        $role = Role::where('name', $oldRoleName)
            ->where('app_id', $appId)
            ->first();

        if ($role) {
            $role->name = $newRoleName;
            $role->save();
        }

        return $role;
    }

    /**
     * Delete a role within a specific app (removes for all users).
     */
    public function deleteAppRole(string $roleName, int $appId): bool
    {
        $role = Role::where('name', $roleName)
            ->where('app_id', $appId)
            ->first();

        if ($role) {
            $role->delete();
        }

        return true;
    }

    /**
     * Replace all the user's roles for a given app with a new set.
     */
    public function syncRolesWithApp(array $roleNames, int $appId)
    {
        $roles = Role::whereIn('name', $roleNames)
            ->where('app_id', $appId)
            ->pluck('id');

        $this->roles()->syncWithoutDetaching($roles);

        return $this;
    }

    /**
     * Remove all roles for the user from a specific app.
     */
    public function removeAllRolesFromApp(int $appId)
    {
        $roleIds = Role::where('app_id', $appId)->pluck('id');
        $this->roles()->detach($roleIds);

        return $this;
    }

    /**
     * Get all the user's roles grouped by app_id.
     */
    public function getAllAppRoles(): Collection
    {
        return $this->roles()
            ->get()
            ->groupBy('app_id')
            ->map(fn($roles) => $roles->pluck('name'));
    }

    /**
     * Check if a role exists globally (for validation or setup).
     */
    public  function roleExists(string $roleName, int $appId): bool
    {
        $query = Role::where('name', $roleName);
        if (!$appId) {
            $query->where('app_id', $appId);
        }

        return $query->exists();
    }
}
