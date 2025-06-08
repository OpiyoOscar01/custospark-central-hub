<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\App;
use App\Models\Coupon;
use App\Models\Referral;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Services\SSOCookieService;
use App\Traits\HasAppRoles;
use App\Services\NotificationService;
use App\Services\ReferralLinkService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    protected $notifier;
    protected ReferralLinkService $referralLinkService;
    


    public function __construct(ReferralLinkService $referralLinkService)
    {
        $this->notifier = app('App\Services\NotificationService');
        $this->referralLinkService = $referralLinkService;
    }
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
        */

 public function store(StoreUserRequest $request)
{
    $validated = $request->validated();

    DB::transaction(function () use ($validated, &$user) {
        $user = $this->createUser($validated);
        $this->handleReferralIfExists($user);
    });

    // create new user's referral links
    $referralLinks = $this->referralLinkService->generateReferralLinksForUser($user->id);

    // Assign default role in Custohost app
    $this->assignDefaultRole($user);
    //Assign default role with Custospark
    $this->assignDefaultRoleWithCustospark($user);

    // Send welcome notification
    $this->sendWelcomeNotification($user);

    // Send verification code
    $this->sendVerificationCode($user);

    // Return verification view
    return view('auth.verify-code', compact('user'))
        ->with('success', 'A verification code has been sent to your email.');
}


    private function createUser(array $data)
{
    $user = User::create([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'status' => 'active',
    ]);

    $user->referral_code = $this->referralLinkService->generateReferralCodeForUser($user);
    $user->save();

    return $user;
}

private function handleReferralIfExists(User $user)
{
    $referral = Session::get('referral');

    if ($referral) {
        $this->referralLinkService->createReferralAndCouponRecordForNewUser($referral, $user);
        Session::forget('referral');
    }
}

private function assignDefaultRole(User $user)
{
    $custohostApp = App::where('slug', 'custohost')->first();
    $defaultRole = 'student';

    if ($custohostApp && Role::roleExists($defaultRole, $custohostApp->id, 'web')) {
        $user->assignRoleWithApp($defaultRole, $custohostApp->id);
    }
}

private function assignDefaultRoleWithCustospark(User $user)
{
    $custosparkApp = App::where('slug', 'custospark')->first();
    $defaultRole = 'normal-user';

    if ($custosparkApp && Role::roleExists($defaultRole, $custosparkApp->id, 'web')) {
        $user->assignRoleWithApp($defaultRole, $custosparkApp->id);
    }
}

private function sendWelcomeNotification(User $user)
{
    $message = "Hi {$user->first_name}, welcome to Custospark! Your registration was successful.Explore all our apps and start your journey with us.All your apps are available in the dashboard. If you have any questions, feel free to reach out to our support team.";

    $this->notifier->sendNotification(
        'Welcome ' . $user->first_name,
        $message,
        'user',
        'both',
        $user->id
    );
}

    private function sendVerificationCode(User $user)
    {
        $this->generateAndSendVerificationCode($user, $this->notifier, 'Account');
    }

    public function sendVerificationCodeAndRedirectUnverifiedUser($user){
        $this->generateAndSendVerificationCode($user, $this->notifier, 'Verification');
         return view('auth.verify-code', compact('user'))
        ->with('success', 'A verification code has been sent to your email.');
    }
    public function generateAndSendVerificationCode($user, $notifier, $type = 'Login')
    {
        $code = rand(100000, 999999);

        $user->update([
            'verification_code' => Hash::make($code),
            'verification_code_expires_at' => now()->addMinutes(10),
        ]);


        $message = "Hi {$user->first_name}, your {$type} verification code is {$code}. This code will expire in 10 minutes.";

        $notifier->sendNotification(
            "{$type} Verification Code",
            $message,
            'user',
            'email',
            $user->id
        );
    }

}
