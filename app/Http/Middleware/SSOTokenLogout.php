<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class SSOTokenLogout
{
    public function handle(Request $request, Closure $next)
    {
        dd('SSOTokenLogout middleware');
        if (Auth::check()) {
            return $next($request);
        }


        $token = $request->cookie('sso_token');

        if (!$token) {

            return redirect()->route('login');
        }
        $personalAccessToken = PersonalAccessToken::findToken($token);

        if (!$personalAccessToken || !$personalAccessToken->tokenable) {
            return redirect()->route('login');
        }

        dd('okay');
        return $next($request);
    }
}
