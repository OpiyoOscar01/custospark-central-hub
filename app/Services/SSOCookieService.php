<?php
namespace App\Services;

use Illuminate\Support\Facades\Cookie;

class SSOCookieService
{
    public function create(string $token)
    {
        $isLocal = env('APP_ENV') === 'local';

        return cookie(
            'sso_token',
            $token,
            60 * 24 * 7, // 7 days
            '/',
            $isLocal ? '.custospark.test' : '.custospark.com',
            !$isLocal,     // secure
            true,          // httpOnly
            false,         // raw
            $isLocal ? 'Lax' : 'None'
        );
    }

    public function destroy(): array
    {
        $isLocal = env('APP_ENV') === 'local';

        $baseDomain = $isLocal ? '.custospark.test' : '.custospark.com';
        $host = request()->getHost(); // e.g., "custospace.custospark.test"

        // Extract subdomain (e.g., "custospace")
        $parts = explode('.', $host);
        $subdomain = count($parts) > 2 ? $parts[0] : null;

        $cookies = [];

        // Forget base domain cookie
        $cookies[] = Cookie::forget('sso_token', '/', $baseDomain);

        // Also forget subdomain-specific cookie (if present)
        if ($subdomain) {
            $cookies[] = Cookie::forget('sso_token', '/', $host);
        }

        return $cookies;
    }
}
