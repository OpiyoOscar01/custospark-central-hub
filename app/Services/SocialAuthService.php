<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\SSOCookieService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialUser;
use Carbon\Carbon;
use App\Repositories\SocialAuthRepository;

class SocialAuthService
{
    protected SocialAuthRepository $userRepo;
    protected SSOCookieService $cookieService;

    public function __construct(SocialAuthRepository $userRepo, SSOCookieService $cookieService)
    {
        $this->userRepo = $userRepo;
        $this->cookieService = $cookieService;
    }

    /**
     * Authenticate a user via social provider (Google, Facebook).
     * If user exists, logs in; otherwise, creates and logs in.
     * Then issues an SSO token and sets the cookie for cross-subdomain access.
     *
     * @param SocialUser $socialUser The user object from the provider.
     * @param string $provider The name of the provider (e.g., google, facebook).
     * @return RedirectResponse
     */
    public function authenticate(SocialUser $socialUser, string $provider): RedirectResponse
    {
        // Attempt to find user by provider ID or email.
        $user = $this->userRepo->findByProviderOrEmail($provider, $socialUser->getId(), $socialUser->getEmail());

        // If not found, create a new user based on social data.
        if (!$user) {
            $user = $this->userRepo->createFromSocialProvider($socialUser, $provider);
        }

        // Log the user into the application.
        Auth::login($user, true);

        // Clean up expired or duplicate SSO tokens.
        $user->tokens()
            ->where('name', 'sso-token')
            ->where(fn($q) => $q->where('expires_at', '<', now())->orWhereNull('expires_at'))
            ->delete();

        // Create a new SSO token valid for 12 hours.
        $token = $user->createToken('sso-token', ['sso-login'], Carbon::now()->addHours(12))->plainTextToken;

        // Create a cookie using the token (for cross-subdomain SSO login).
        $cookie = $this->cookieService->create($token);

        // Redirect the user to their app’s dashboard (based on environment + app name).
        $redirectUrl = $this->resolveRedirectUrl(request('app', 'custospark'));

        return redirect()->away($redirectUrl)->withCookie($cookie);
    }

    /**
     * Resolve dashboard redirect URL based on app name and environment.
     * Useful for subdomain-based SSO redirection.
     *
     * @param string $app The app name passed from request (?app=...)
     * @return string
     */
    protected function resolveRedirectUrl(string $app): string
    {
        $isLocal = env('APP_ENV') === 'local';

        return match ([$isLocal, strtolower($app)]) {
            [true, 'custospark'] => 'http://custospark.test:8000/dashboard',
            [true, 'custospace'] => 'http://custospace.custospark.test:8001/dashboard',
            [true, 'custohost']  => 'http://custohost.custospark.test:8002/dashboard',
            [true, 'custosell']  => 'http://custosell.custospark.test:8003/dashboard',
            [false, 'custospark'] => 'https://custospark.com/dashboard',
            [false, 'custospace'] => 'https://custospace.custospark.com/dashboard',
            [false, 'custohost']  => 'https://custohost.custospark.com/dashboard',
            [false, 'custosell']  => 'https://custosell.com/dashboard',
            default => 'https://custospark.com',
        };
    }
}
