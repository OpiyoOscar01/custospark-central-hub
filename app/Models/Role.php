<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = ['name', 'guard_name', 'app_id'];

public function app()
{
    return $this->belongsTo(App::class);
}
// In App\Models\Role.php
public static function roleExists(string $name, int $appId, string $guardName): bool
{
    return self::where('name', $name)
        ->where('app_id', $appId)
        ->where('guard_name', $guardName)
        ->exists();
}

public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
{
    return $this->belongsToMany(
        Permission::class,
        'role_has_permissions',
        'role_id',
        'permission_id'
    );
}
public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
{
    return $this->belongsToMany(User::class);
}
}
