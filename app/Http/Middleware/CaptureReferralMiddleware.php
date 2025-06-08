<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\App;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class CaptureReferralMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->has('ref')) {
            $referralCode = $request->get('ref');
            $slug = $request->segment(1); // e.g., 'custospace'

            if ($slug && $referralCode) {
                $app = App::where('slug', $slug)->first();
                $referrer = User::where('referral_code', $referralCode)->first();

                if ($app && $referrer) {
                    Session::put('referral', [
                        'referral_code' => $referralCode,
                        'referrer_id' => $referrer->id,
                        'app_id' => $app->id,
                        'source' => $request->get('source'), // optional UTM tracking
                        'medium' => $request->get('medium'),
                        'referral_url' => $request->fullUrl(), // 🚀 Store full referral URL
                    ]);
                }
            }
        }

        return $next($request);
    }
}
