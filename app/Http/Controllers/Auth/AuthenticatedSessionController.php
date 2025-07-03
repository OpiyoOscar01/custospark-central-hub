<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\App;
use App\Models\User;
use App\Services\SSOCookieService;
use App\Services\NotificationService;
use App\Services\ReferralLinkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    protected NotificationService $notifier;

    public function __construct(NotificationService $notifier,ReferralLinkService $referralLinkService)
    {
        $this->notifier = $notifier;
    }

 
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


    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Manually retrieve user
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Auth::getProvider()->validateCredentials($user, $credentials)) {
            return back()->withErrors(['email' => 'Invalid credentials provided.']);
        }
        //set users referral code if not set

        $user->referral_code = $user->referral_code ?? app(ReferralLinkService::class)->generateReferralCodeForUser($user);
 
        //Allow user login if two-factor authentication is disabled
        if(!$user->two_factor_enabled){
            return $this->loginWithTwoFaDisabled($request, app(SSOCookieService::class));
        }
        // Generate a 6-digit verification code
        $verificationCode = rand(100000, 999999);

        $user->update([
            'verification_code' => Hash::make($verificationCode),
            'verification_code_expires_at' => now()->addMinutes(10),
        ]);

        // Notify user via email + in-app
        $message = "Hi {$user->first_name}, your verification code is {$verificationCode}. This code will expire in 10 minutes.";

        $this->notifier->sendNotification(
            'Login Verification Code',
            $message,
            'user',
            'email',
            $user->id
        );

        return view('auth.verify-code', compact('user'));
    }

   public function verifyCode(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'code' => 'required|digits:6',
    ]);

    $user = User::findOrFail($request->input('user_id'));

    if (!$user->verification_code || !$user->verification_code_expires_at) {
        return view('auth.verify-code', compact('user'))->withErrors(['code' => 'Verification code not found.']);
    }

    if (now()->gt($user->verification_code_expires_at)) {
        return view('auth.verify-code', compact('user'))->withErrors(['code' => 'The verification code has expired.']);
    }

    if (!Hash::check($request->input('code'), $user->verification_code)) {
        return view('auth.verify-code', compact('user'))->withErrors(['code' => 'Invalid verification code.']);
    }

        $updates = [
            'verification_code' => null,
            'verification_code_expires_at' => null,
        ];

        if (is_null($user->email_verified_at)) {
            $updates['email_verified_at'] = now();
        }
        $user->update($updates);

    // Step 1: Login the user and regenerate session
    Auth::login($user);
    $request->session()->regenerate();

    // Step 2: Clean up expired or duplicate SSO tokens
    $user->tokens()
        ->where('name', 'sso-token')
        ->where(function ($query) {
            $query->where('expires_at', '<', now())
                  ->orWhereNull('expires_at');
        })
        ->delete();

    // Step 3: Create new SSO token
    $token = $user->createToken(
        name: 'sso-token',
        abilities: ['sso-login'],
        expiresAt: now()->addHours(12)
    )->plainTextToken;

    // Step 4: Generate SSO cookie
    $cookie = app(SSOCookieService::class)->create($token);

    // Step 5: Determine app slug and redirect URL
    $appSlug = strtolower($request->input('app', 'custospark'));
    $apps = App::where('status', 'active')->get();
    $matchedApp = $apps->first(fn ($app) => strtolower($app->slug) === $appSlug);

     //Redirect to order summary if session is set
    if ($redirect = Self::redirectToOrderSummaryIfSessionSet($cookie)) {
        return $redirect;
    }
    //Redirect to jobs if session is set
    if ($redirect = Self::redirectToJobsIfSessionSet($cookie)) {
        return $redirect;
    }
    //Redirect to intended page if session is set
    $redirectUrl = session('url.intended');
    $redirect = Self::redirectToIntendedPage($cookie);
    if($redirect && $redirect instanceof RedirectResponse && $redirectUrl){
        return $redirect;
    }
    // Step 6: Redirect to matched app or fallback URL
    // Check if matched app exists

    if ($matchedApp) {
        return redirect()->away($matchedApp->base_url.'/dashboard')
            ->withCookie($cookie)
            ->with(['success' => 'Login successful.']);
    }
        $fallBackUrl=env('APP_ENV')==='local'?'http://custospark.test:8000/dashboard':'https://custospark.com/dashboard';
    // Fallback if app not found
    return redirect()->away($fallBackUrl)
        ->withCookie($cookie)
        ->with(['info' => 'Welcome to your accounts page on Custospark.']);
}


    public function resendCode(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        $code = rand(100000, 999999);

        $user->update([
            'verification_code' => Hash::make($code),
            'verification_code_expires_at' => now()->addMinutes(10),
        ]);

        $message = "Hi {$user->first_name}, your new verification code is {$code}. It will expire in 10 minutes.";

        $this->notifier->sendNotification(
            'New Verification Code',
            $message,
            'user',
            'email',
            $user->id
        );

        return view('auth.verify-code',compact('user'))->with('status', 'A new verification code has been sent.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    
public function loginWithTwoFaDisabled(LoginRequest $request, SSOCookieService $cookieService): RedirectResponse
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
    //Redirect to order summary if session is set
    if ($redirect = Self::redirectToOrderSummaryIfSessionSet($cookie)) {
        return $redirect;
    }
    if ($redirect = Self::redirectToJobsIfSessionSet($cookie)) {
        return $redirect;
    }
    $redirectUrl = session('url.intended');
    $redirect = Self::redirectToIntendedPage($cookie);
    if($redirect && $redirect instanceof RedirectResponse && $redirectUrl){
        return $redirect;
    }
    if ($matchedApp) {
        $redirectUrl = $matchedApp->base_url.'/dashboard';
        return redirect()->away($redirectUrl)
            ->withCookie($cookie)
            ->with(['success' => 'Login successful.']);
    }

    // Step 4.2: Fallback redirect if no match
   $fallBackUrl=env('APP_ENV')==='local'?'http://custospark.test:8000/dashboard':'https://custospark.com/dashboard';
    // Fallback if app not found
    return redirect()->away($fallBackUrl)
        ->withCookie($cookie)
        ->with(['info' => 'Welcome to your accounts page on Custospark.']);
}

public static function redirectToOrderSummaryIfSessionSet($cookie = null)
{
    if (Session::has('selected_app_id') && Session::has('selected_plan_id')) {
        $appId = Session::get('selected_app_id');
        $planId = Session::get('selected_plan_id');
        $appSlug=App::findOrFail($appId)->slug;

        // Clean up session to prevent repeated redirection
        Session::forget(['selected_app_id', 'selected_plan_id']);

        return redirect()->route('subscriptions.summary', [
            'app' => $appSlug,
            'plan' => $planId,
        ])->withCookie($cookie);
    }

    return null; // Explicitly return null if no redirect needed
}

public static function redirectToJobsIfSessionSet($cookie = null)
{
    if (Session::has('job_id')) {
        $jobId = Session::get('job_id');

        // Clean up session to prevent repeated redirection
        Session::forget('job_id');

        return redirect()->route('applications.create', 
        $jobId)->withCookie($cookie);
    }

    return null; // Explicitly return null if no redirect needed

}

 /**
     * Handles redirect to login with intended URL storage.
     *
     * @param Request $request
     * @param string $loginRoute
     * @param array $routeParams
     * @param string|null $errorMessage
     * @return RedirectResponse
     */
    public static function redirectToIntendedPage($cookie=null){
        //Get redirect URL from session
        $redirectUrl = session('url.intended', route('login.redirect', ['app' => 'custospark']));
        return redirect()->away($redirectUrl)
            ->withCookie($cookie);
    }
}


