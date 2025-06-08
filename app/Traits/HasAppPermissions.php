<?php

namespace App\Traits;

use App\Models\Permission; // Correct import for custom Permission model
use Illuminate\Support\Collection;

trait HasAppPermissions
{
    public function giveAppPermissionTo($permissionName, $appId)
    {
        // Fetch the permission for the given app_id
        $permission = Permission::where('name', $permissionName)
            ->where('app_id', $appId)
            ->firstOrFail();  // Ensure it throws an exception if not found

        // Attach the permission to the user
        $this->permissions()->attach($permission->id);

        return $this;
    }

    public function getAppPermissionNames($appId): Collection
    {
        // Fetch permission names for the given app_id
        return $this->permissions()
            ->where('app_id', $appId)
            ->pluck('name');
    }

    public function revokeAppPermissionTo($permissionName, $appId)
    {
        // Find and detach the permission for the given app_id
        $permission = Permission::where('name', $permissionName)
            ->where('app_id', $appId)
            ->first();

        if ($permission) {
            $this->permissions()->detach($permission->id);
        }

        return $this;
    }

    public function updateAppPermission($oldPermissionName, $newPermissionName, $appId)
    {
        // Find the old permission and update its name
        $permission = Permission::where('name', $oldPermissionName)
            ->where('app_id', $appId)
            ->first();

        if ($permission) {
            $permission->name = $newPermissionName;
            $permission->save();
        }

        return $permission;
    }

    public function deleteAppPermission($permissionName, $appId)
    {
        // Find and delete the permission for the given app_id
        $permission = Permission::where('name', $permissionName)
            ->where('app_id', $appId)
            ->first();

        if ($permission) {
            $permission->delete();
        }

        return true;
    }
}
