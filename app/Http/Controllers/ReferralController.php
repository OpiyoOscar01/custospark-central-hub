<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Referral; // assuming you have a Referral model
use App\Models\ReferralLink;
use App\Models\App;
use App\Services\ReferralLinkService;
use App\Models\CashPayout;
class ReferralController extends Controller
{
    protected ReferralLinkService $referralLinkService;
    public function __construct(ReferralLinkService $referralLinkService)
    {
        $this->referralLinkService = $referralLinkService;
    }
   
    /**
     * Show the referral invite page where user can get/share their referral link or code.
     */

public function invite()
{
    $user = Auth::user();

    // Fetch all apps
    $apps = App::all();

    // Fetch existing referral links for the user, keyed by app_id
    $existingLinks = ReferralLink::with('app')
        ->where('user_id', $user->id)
        ->get()
        ->keyBy('app_id');

    // Calculate total referral earnings for the user (example)
    $totalReferralEarnings = Referral::where('referrer_id', $user->id)
        ->where('rewarded', true)
        ->sum('earned_amount');

    return view('users.referrals.invite', compact('apps', 'existingLinks', 'totalReferralEarnings'));
}





public function updateRewardPreference(Request $request)
{
    $request->validate([
        'referral_reward_preference' => 'required|in:coupon,cash',
    ]);

    $user = auth()->user();
    $user->referral_reward_preference = $request->referral_reward_preference;
    $user->save();

    return back()->with('success', 'Reward preference updated.');
}


public function generateLinkForAppUser($app)
{
    $user = Auth::user();
    $userId = $user->id;
    $app = App::findOrFail($app); // Ensure the app exists
   if(!$app) {
        return redirect()->back()->with('error', 'App not found.');
    }
    if(!$user) {
        return redirect()->back()->with('error', 'User not authenticated.');
    }
    $this->referralLinkService->generateLinkForAppUser($userId, $app);

    return redirect()->back()->with('success', 'Referral link generated.');
}

  

/**
 * Summary of history
 * @return \Illuminate\Contracts\View\View
 */
public function earnings()
{
   $user = Auth::user();

    // Fetch referrals and payouts
    $referrals = $user->referrals()
        ->with(['referredUser', 'app'])
        ->latest()
        ->get();

    $cashPayouts = $user->referralCashPayouts()->latest()->get();

    // Aggregate summary values
    $totalEarned = $referrals->sum('earned_amount');
    $totalPaid = $cashPayouts->where('status', 'paid')->sum('amount');
    $totalPending = $totalEarned - $totalPaid;

    // Referral links
    $referralLinks = $user->referralLinks()->latest()->get();

    return view('users.referrals.earnings', compact(
        'user',
        'referrals',
        'cashPayouts',
        'referralLinks',
        'totalEarned',
        'totalPaid',
        'totalPending'
    ));
}

    /**
     * Helper: Generate referral code for user (simple example).
     */
    protected function generateReferralCode($user)
    {
        $code = strtoupper(substr(md5($user->email . now()), 0, 8));
        $user->referral_code = $code;
        $user->save();

        return $code;
    }
}

