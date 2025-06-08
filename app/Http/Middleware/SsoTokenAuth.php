<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\RegisteredUserController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class SsoTokenAuth
{
    protected RegisteredUserController $registeredUserController;

    public function __construct(RegisteredUserController $registeredUserController)
    {
        $this->registeredUserController = $registeredUserController;
    }

    public function handle(Request $request, Closure $next)
    {
        // If already authenticated, validate status
        if (Auth::check()) {
            $user = Auth::user();

            if (!$this->isUserAllowed($user)) {
                abort(403, $this->getStatusMessage($user->status));
            }

            return $next($request);
        }

        // Attempt SSO authentication via token
        $token = $request->cookie('sso_token');

        if (!$token) {
            // Store intended URL for redirect after login
            session()->put('url.intended', $request->fullUrl());

            return redirect()->route('login.redirect', ['app' => 'custospark'])
                ->with('error', 'Please login to proceed.');
        }

        $personalAccessToken = PersonalAccessToken::findToken($token);

        if (!$personalAccessToken) {
            // Store intended URL even on token failure
            session()->put('url.intended', $request->fullUrl());

            return redirect()->route('login.redirect', ['app' => 'custospark'])
                ->with('error', 'Invalid or expired session. Please login again.');
        }

        $user = $personalAccessToken->tokenable;

        if (!$user) {
            abort(404, 'User associated with token not found.');
        }

        if (!$this->isUserAllowed($user)) {
            abort(403, $this->getStatusMessage($user->status));
        }

        try {
            Auth::login($user);
        } catch (\Exception $e) {
            abort(500, 'An error occurred during authentication.');
        }

        return $next($request);
    }

    /**
     * Determine if user is allowed based on status.
     */
    protected function isUserAllowed($user): bool
    {
        return $user->status === 'active';
    }

    /**
     * Provide custom messages for different user statuses.
     */
    protected function getStatusMessage($status): string
    {
        return match ($status) {
            'pending'   => 'Your account is pending approval. Please wait for verification.',
            'inactive'  => 'Your account is inactive. Contact support for assistance.',
            'suspended' => 'Your account has been suspended. Contact support to resolve this issue.',
            'banned'    => 'Your account has been permanently banned due to policy violations.',
            default     => 'Your account is not permitted to access the application.',
        };
    }

    
}
