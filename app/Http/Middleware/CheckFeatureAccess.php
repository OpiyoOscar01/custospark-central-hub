<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\FeatureAccessHelper;
use App\Helpers\SubscriptionHelper;

class CheckFeatureAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $appSlug
     * @param  mixed  ...$featureCodes
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $appSlug, ...$featureCodes)
    {
        foreach ($featureCodes as $code) {
            if (!SubscriptionHelper::userHasFeature($appSlug, $code)) {
                abort(403, 'You do not have access to this feature.');
            }
        }

        return $next($request);
    }
}

