<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\SSOCookieService;
use Illuminate\Support\Facades\Auth;
class LogoutController extends Controller
{
    /**
     * Handle the logout request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Services\SSOCookieService  $cookieService
     * @return \Illuminate\Http\RedirectResponse
     */

     public function globalLogout(Request $request, SSOCookieService $cookieService)
{

    $token = $request->cookie('sso_token');

   if ($token) {
    $personalAccessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);

    if ($personalAccessToken) {
        $personalAccessToken->delete();
        // dd('Token deleted', $personalAccessToken);
    } else {
        // dd('Token not found');
    }
}


    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    $forgetCookies = $cookieService->destroy();

    // Retrieve the app name from the request's URL parameter (defaults to 'custospark')
    $app = $request->query('app', 'custospark'); 

    // Create the response to redirect to the login page with the app parameter
    $response = redirect()->route('login.redirect', ['app' => $app])->with('success', 'You have been logged out successfully.');

    // Add the cleared cookies to the response
    foreach ($forgetCookies as $cookie) {
        $response->withCookie($cookie);
    }

    return $response;
}


}