<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAppRoles
{
    /**
     * Handle an incoming request.
     *
     * Usage example in routes/web.php:
     * Route::get('/app/settings/{appSlug}', ...)
     *     ->middleware('check.app.roles:admin,app-admin,custosell');
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles (comma-separated role names)
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        $appSlug = 'custospark';//specify the app slug

        if (!$user || !$appSlug) {
            abort(403, 'Unauthorized - no user or app slug provided.');
        }

        $app = App::where('slug', $appSlug)->first();

        if (!$app) {
            abort(404, "App with slug '{$appSlug}' not found.");
        }

        // Check if user has any of the required roles for this app
        foreach ($roles as $role) {
            if (method_exists($user, 'hasRoleWithApp') && $user->hasRoleWithApp($role, $app->id)) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized - insufficient role for this app.');
    }
}
