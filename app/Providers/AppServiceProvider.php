<?php

namespace App\Providers;

use App\Helpers\FeatureAccessHelper;
use App\Helpers\SubscriptionHelper;
use App\Models\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blade::if('hasAppRole', function ($roles, $appSlug) {
            $user = Auth::user();

            // Check if user is authenticated and active
            if (!$user || !($user->status === 'active' || $user->is_active === 1)) {
                return false;
            }

            $app = App::where('slug', $appSlug)->first();

            // App must exist and user must implement hasRoleWithApp method
            if (!$app || !method_exists($user, 'hasRoleWithApp')) {
                return false;
            }

            // Normalize to array
            $roles = is_array($roles) ? $roles : [$roles];

            // Check if user has any of the specified roles in this app
            foreach ($roles as $role) {
                if ($user->hasRoleWithApp($role, $app->id)) {
                    return true;
                }
            }

            return false;
        });
        
        
         Blade::if('hasAppPermission', function ($permissions, $appSlug) {
        $user = Auth::user();

        if (!$user || !method_exists($user, 'getAppPermissionNames')) {
            return false;
        }

        $app = App::where('slug', $appSlug)->first();

        if (!$app || !$user->is_active) {
            return false;
        }

        $permissions = is_array($permissions) ? $permissions : [$permissions];

        $userPermissions = $user->getAppPermissionNames($app->id)->toArray();

        foreach ($permissions as $permission) {
            if (in_array($permission, $userPermissions)) {
                return true;
            }
        }

        return false;
    });
    // Define a custom Blade directive @feature('appSlug', 'featureCode')
    Blade::if('hasFeature', function ($appSlug, $featureCode) {
        return SubscriptionHelper::userHasFeature($appSlug, $featureCode);
    });

    }
}
