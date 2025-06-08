<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // ... authenticate user
        $token = $user->createToken('sso-token')->plainTextToken;
    
        // Secure cookie set for all subdomains
        $cookie = cookie('sso_token', $token, 60 * 24 * 7, '/', '.custospark.com', true, true, false, 'Strict');
    
        // Redirect back to intended app
        $redirectUrl = $request->input('redirect') ?? 'https://custospark.com/dashboard';
    
        return redirect($redirectUrl)->withCookie($cookie);
    }
    }
