<?php
namespace App\services;

use App\Models\Coupon;
use App\Models\Plan;
use App\Models\Referral;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CashPayout;
use App\Models\CouponUsage;
use App\Models\CouponUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SharedLogicService{


  public function __construct(
    protected NotificationService $notifier
  ) {}
  /**
   * Get the existing active subscription for a user and app.
   *
   * @param \App\Models\User $user
   * @param \App\Models\App $app
   * @return \App\Models\Subscription|null
   */
  public function getUserExistingAppSubscription($user, $app)
  {
   return  Subscription::where('user_id', $user->id)
        ->where('app_id', $app->id)
        ->where('status', 'active')
        ->where(function ($query) {
            $query->whereNull('ends_at')->orWhere('ends_at', '>', now());
        })
        ->latest()
        ->first();
  }
  /**
   * Check if a user has an active subscription for a specific app and a a paid downgrade scheduled.This helps prevent scheduling multiple downgrades.
   *
   * @param \App\Models\User $user
   * @param \App\Models\App $app
   * @return bool
   */

  public function checkIfUserHasPaidScheduledDowngrade($existingSubscription, $newPlan)
  {
   if (
      optional($existingSubscription)->next_plan_id &&
      optional($existingSubscription->plan)->level &&
      optional($newPlan)->level &&
      ($newPlan->level <= $existingSubscription->plan->level) &&
      optional($existingSubscription)->next_plan_payment_status === 'paid'
        ) {
            return true;
        } 
    return false;
  }
  /**
   * Summary of activateUserSubscriptionForFreeOrTrialPlan Immediately.
   * @param mixed $newPlan
   * @param mixed $existingSubscription
   * @param mixed $user
   * @param mixed $app
   * @return \Illuminate\Http\RedirectResponse
   */
  public function activateUserSubscriptionForFreeOrTrialPlan(
    $newPlan,$existingSubscription,$user,$app
  ){
     if (in_array($newPlan->plan_type, ['free', 'trial']) && !$existingSubscription) {
        $trialDays = $newPlan->trial_days ?? 14;
        $trialEndsAt = $newPlan->plan_type === 'trial' ? now()->addDays($trialDays) : null;

        Subscription::create([
            'user_id' => $user->id,
            'app_id' => $app->id,
            'plan_id' => $newPlan->id,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
            'ends_at' => $trialEndsAt,
            'trial_ends_at' => $trialEndsAt,
        ]);

        // Notification message
        $message = $newPlan->plan_type === 'trial'
            ? "You've started a {$trialDays}-day free trial of the {$newPlan->name} plan. Your trial ends on {$trialEndsAt->toFormattedDateString()}. You can upgrade at any time to ensure uninterrupted access and enjoy more features."
            : "You're now subscribed to the {$newPlan->name} plan for {$app->name}. Upgrade at any time to unlock premium features and tools.";

        app(NotificationService::class)->sendNotification(
            'Subscription Activated',
            $message,
            'user',
            'both',
            $user->id
        );

        $successMessage = $newPlan->plan_type === 'trial'
            ? "Trial started: {$trialDays} days on the {$newPlan->name} plan. Ends on {$trialEndsAt->toFormattedDateString()}."
            : "You're now on the {$newPlan->name} plan for {$app->name}.";

        return redirect()->route('dashboard')->with('success', $successMessage);
    }
    return redirect()->route('dashboard')->with('error', 'Unable to activate subscription. Please try again later.');
  }

  /**
   * Check if the selected plan is the current plan for the user.
   *
   * @param \App\Models\Subscription|null $existingSubscription
   * @param \App\Models\Plan $newPlan
   * @param int $planId
   * @return bool
   */
  public function checkIfSelectedPlanIsCurrentPlan(
$existingSubscription,$planId
  ){
    if ($existingSubscription && ($existingSubscription->plan_id === $planId)) {
       
      return true;

      }
      return false;
}
public function processCouponReferralAndRewards($appliedCouponData, $appId)
{
    $user = Auth::user();

    // Step 1: Calculate 20% referral commission from final price
    $referralCommission = 0.20 * $appliedCouponData['final_price'];

    // Step 2: Check for a pending referral for this user and app
    $referral = Referral::where('referred_user_id', $user->id)
                        ->where('app_id', $appId)
                        ->where('status', 'pending')
                        ->first();

    if ($referral) {
        // Step 3: Update referral record to rewarded
        $referral->status = 'rewarded';
        $referral->rewarded = true;
        $referral->rewarded_at = now();
        $referral->earned_amount = $referral->earned_amount ?: 0;

        // Step 4: Reward the referrer according to the user's preference
        if ($user->referral_reward_preference === 'coupon') {
            // 4.a: Create a reward coupon
            $rewardCoupon = Coupon::create([
                'app_id'            => $appId,
                'code'              => strtoupper('REF-' . Str::random(8)),
                'type'              => 'fixed',
                'value'             => 20.00,
                'active'            => true,
                'max_uses'          => 1,
                'max_uses_per_user' => 1,
                'creator_id'        => $referral->referrer_id,
                'created_by_admin'  => false,
                'description'       => 'Referral reward',
                'starts_at'         => now(),
                'expires_at'        => now()->addDays(30),
            ]);

            // Link coupon to the referrer
            CouponUser::create([
                'coupon_id' => $rewardCoupon->id,
                'user_id'   => $referral->referrer_id,
                'app_id'    => $appId,
                'used_at'   => null,
            ]);

            // ✅ Send referral coupon notification
            $referrer = User::find($referral->referrer_id);
            if ($referrer) {
                $this->sendReferralCouponCodeNotification($referrer, $rewardCoupon);
            }

        } 
        elseif ($user->referral_reward_preference === 'cash') 
        {
            // 4.b: Create a pending cash payout
              CashPayout::create([
                  'user_id'         => $referral->referrer_id,
                  'app_id'          => $appId,
                  'referral_id'     => $referral->id,
                  'amount'          => $referralCommission,
                  'status'          => 'pending',
                  'payment_method'  => null,
                  'payment_details' => null,
                  'approved_by'     => null,
                  'paid_at'         => null,
                  'currency'        => 'USD',
              ]);

              // Notify referrer about pending payout
              $referrer = User::find($referral->referrer_id);
              if ($referrer) {
                  $this->sendReferralCashRewardNotification($referrer, $referralCommission);
              }
        }
        // Update referral record with the earned amount
        $referral->earned_amount += $referralCommission;
        $referral->save();
    }
/* * Step 5: Process the coupon usage and limits

*/
   // Step 5.1: Retrieve the coupon that matches the applied code, is active, and not expired or overused
$coupon = Coupon::where('code', $appliedCouponData['code'])
    ->where('app_id', $appId)
    ->where('active', true)
    ->where(function ($query) {
        $query->whereNull('expires_at')
              ->orWhere('expires_at', '>', now()); // Not expired
    })
    ->where(function ($query) {
        $query->whereNull('max_uses')
              ->orWhere('max_uses', '>', 0); // Not globally overused
    })
    ->first();

if ($coupon) {
    // Step 5.2: Decrease global usage count if applicable
    if (!is_null($coupon->max_uses)) {
        $coupon->max_uses = max(0, $coupon->max_uses - 1);
    }

    // Step 5.3: Check how many times this user has used the coupon
    $couponUser = CouponUser::firstOrNew([
        'user_id'   => $user->id,
        'coupon_id' => $coupon->id,
        'app_id'    => $appId,
    ]);

    // Increment per-user usage
    $couponUser->times_used = ($couponUser->times_used ?? 0) + 1;
    $couponUser->used_at = now();

    // Step 5.4: Save or update user usage record
    $couponUser->save();

    // Step 5.5: Mark coupon as inactive if either limit is reached
    $userUsageLimitReached = $coupon->max_uses_per_user !== null && $couponUser->times_used >= $coupon->max_uses_per_user;
    $globalLimitReached = $coupon->max_uses !== null && $coupon->max_uses <= 0;

    if ($userUsageLimitReached || $globalLimitReached) {
        $coupon->active = false;
    }

    // Save the updated coupon limits and status
    $coupon->save();

    // Step 5.6: Log detailed usage to `coupon_usages` table
    CouponUsage::updateOrCreate(
        [
            'user_id'   => $user->id,
            'coupon_id' => $coupon->id,
            'app_id'    => $appId,
        ],
        [
            'context'         => 'subscription_purchase',
            'discount_amount' => $appliedCouponData['discount'] ?? 0,
            'currency'        => 'USD',
            'times_used'      => DB::raw('times_used + 1'), // Increment usage
            'last_used_at'    => now(),
        ]
    );
}


    // Step 8: Clear temporary session data
    session()->forget([
        'applied_coupon',
        
    ]);

}

private function sendReferralCouponCodeNotification(User $user, Coupon $coupon): void
{
    $appName = $coupon->app->name ?? 'Custospark';
    $message = "Hi {$user->first_name}, you have received a referral bonus! Use the code {$coupon->code} to get {$coupon->value}% off your next subscription for {$appName}. This code is valid until {$coupon->expires_at->format('Y-m-d H:i:s')}.";

    $this->notifier->sendNotification(
        'Referral Bonus',
        $message,
        'user',  
        'both',   
        $user->id 
    );
}

private function sendReferralCashRewardNotification(User $user, float $amount, string $currency = 'USD'): void
{
    $message = "Hi {$user->first_name}, you've earned a referral reward of {$amount} {$currency}! This will be paid out to your selected payment method at the end of the month. Thank you for sharing the word about Custospark.";

    $this->notifier->sendNotification(
        'Referral Cash Reward Pending',
        $message,
        'user',
        'both',
        $user->id
    );
}

}




