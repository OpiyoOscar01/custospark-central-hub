<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\App;
use App\Models\User;use App\Services\SSOCookieService;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;


class testController extends Controller
{
    public function create(Request $request)
    {
        $redirectUrl = $request->query('redirect');
        $appName = 'custospark'; // default fallback
    
        if ($redirectUrl) {
            $parsed = parse_url($redirectUrl);
    
            if (isset($parsed['query'])) {
                parse_str($parsed['query'], $queryParams);
                if (isset($queryParams['app'])) {
                    $appName = ucfirst($queryParams['app']);
                }
            }
        }
    
    
        return view('auth.login', compact('appName', 'redirectUrl'));
    }

  
    
   

    

public function store(LoginRequest $request, SSOCookieService $cookieService): RedirectResponse
{
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return back()->withErrors([
            'email' => 'Invalid credentials provided.',
        ]);
    }

    $user = Auth::user();
    $request->session()->regenerate();

    // Step 1: Clean up expired or duplicate SSO tokens
    $user->tokens()
        ->where('name', 'sso-token')
        ->where(function ($query) {
            $query->where('expires_at', '<', now())
                  ->orWhereNull('expires_at');
        })
        ->delete();

    // Step 2: Create new token
    $token = $user->createToken(
        name: 'sso-token',
        abilities: ['sso-login'],
        expiresAt: Carbon::now()->addHours(12)
    )->plainTextToken;

    // Step 3: Create SSO cookie
    $cookie = $cookieService->create($token);

    // Step 4: Determine redirect URL dynamically
    $appSlug = strtolower($request->input('app', 'custospark'));

    // Step 4.1: Fetch all apps and match slug
    $apps = App::where('status', 'active')->get();
    $matchedApp = $apps->first(fn ($app) => strtolower($app->slug) === $appSlug);

    if ($matchedApp) {
        $redirectUrl = $matchedApp->base_url.'/dashboard';

        return redirect()->away($redirectUrl)
            ->withCookie($cookie)
            ->with(['success' => 'Login successful.']);
    }

    // Step 4.2: Fallback redirect if no match
    $fallbackUrl = 'https://custospark.com/dashboard';

    return redirect()->away($fallbackUrl)
        ->withCookie($cookie)
        ->with(['warning' => 'App not found. Redirected to default dashboard.']);
}

    
    
    
    public function loginWithToken(Request $request)
{
    $token = $request->cookie('sso_token');

    if (!$token) {
        return redirect()->route('login')->withErrors('Token missing.');
    }

    try {
        // Retrieve the token record using Sanctum
        $personalAccessToken = PersonalAccessToken::findToken($token);

        if (!$personalAccessToken) {
            return redirect()->route('login')->withErrors('Invalid token.');
        }

        $user = $personalAccessToken->tokenable;

        if (!$user) {
            return redirect()->route('login')->withErrors('User not found.');
        }

        // Log the user in using the Auth facade
        Auth::login($user);
        
        // Regenerate session to persist authenticated state
        $request->session()->regenerate();

        // Redirect to the dashboard with the authentication state in session
        return redirect()->intended(route('dashboard'));
    } catch (\Exception $e) {
        return redirect()->route('login')->withErrors('Authentication failed.');
    }
}

    

    /**
     * Destroy an authenticated session.
     */
    
     public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

