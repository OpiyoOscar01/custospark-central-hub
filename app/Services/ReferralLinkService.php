<?php
namespace App\Services;

use App\Models\App;
use App\Models\Coupon;
use App\Models\Referral;
use App\Models\ReferralLink;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class ReferralLinkService{
  protected $notifier;

    /**
     * ReferralLinkService constructor.
     */

  public function __construct(NotificationService $notifier)
    {
        $this->notifier = $notifier;
    }
   

    /**
     * Generate referral links for a specific user across all apps.
     *
     * @param int $userId
     * @return array
     */

  
   public function generateReferralLinksForUser($userId)
{
    $user = User::findOrFail($userId);
    $apps = App::all();
    $links = [];

    foreach ($apps as $app) {
        $referralLink = ReferralLink::firstOrCreate(
            ['user_id' => $user->id, 'app_id' => $app->id],
            ['referral_url' => $this->buildReferralUrl($user, $app)]
        );

        $links[] = $referralLink;
    }

    return $links;
}

  public function generateLinkForAppUser($userId, App $app)
{
    $user = User::findOrFail($userId);

    $referralLink = ReferralLink::firstOrCreate(
        ['user_id' => $user->id, 'app_id' => $app->id],
        ['referral_url' => $this->buildReferralUrl($user, $app)]
    );

    return $referralLink;
}


    /**
     * Helper to build referral URL.
     */
   protected function buildReferralUrl(User $user, App $app)
{
    $domain = match (config('app.env')) {
        'production' => 'https://custospark.com',
        default => 'http://custospark.test:8000',
    };

    return "{$domain}/{$app->slug}/signup?ref={$user->referral_code}";
}

public function generateReferralCodeForUser(User $user): string
{
    if ($user->referral_code) {
        return $user->referral_code;
    }

    $firstNameSlug = strtoupper($user->first_name);
    $timestamp = now()->format('YmdHis');
    $randomPart = strtoupper(Str::random(4));

    $code = "REF-{$firstNameSlug}-{$randomPart}-{$timestamp}";

    // Optionally: check uniqueness here, regenerate if exists (rare)
    while (User::where('referral_code', $code)->exists()) {
        $randomPart = strtoupper(Str::random(4));
        $timestamp = now()->format('YmdHis');
        $code = "REF-{$firstNameSlug}-{$randomPart}-{$timestamp}";
    }

    return $code;
}


public function createReferralAndCouponRecordForNewUser(array $referral, User $user)
{
    if (!$this->referralRecordExists($referral, $user)) {
       $this->createReferralRecord($referral, $user);
    }
    $coupon = $this->createReferralCoupon($referral, $user);

    $this->attachCouponToUser($coupon, $referral['app_id'], $user->id);

    $this->sendReferralCouponCodeNotification($user, $coupon);

    Session::forget('referral');
}
private function referralRecordExists(array $referral, User $user): bool
{
    return Referral::where('referrer_id', $referral['referrer_id'])
        ->where('referred_user_id', $user->id)
        ->where('app_id', $referral['app_id'])
        ->exists();
}

private function createReferralRecord(array $referral, User $user) : Referral
{
  $referral=  Referral::create([
        'referrer_id' => $referral['referrer_id'],
        'referred_user_id' => $user->id,
        'app_id' => $referral['app_id'],
        'referral_url' => $referral['referral_url'],
        'status' => 'pending',
        'source' => $referral['source'] ?? null,
        'medium' => $referral['medium'] ?? null,
    ]);
    return $referral;
}


private function createReferralCoupon(array $referral, User $user): Coupon
{
    return Coupon::create([
        'app_id' => $referral['app_id'],
        'code' => strtoupper('WELCOME-' . Str::random(8)),
        'type' => 'percentage',
        'value' => 10.00,
        'max_uses' => 1,
        'max_uses_per_user' => 1,
        'starts_at' => now(),
        'expires_at' => now()->addDays(30),
        'active' => true,
        'created_by_admin' => false,
        'creator_id' => $referral['referrer_id'],
        'description' => 'Referral bonus for signing up via referral link',
        'metadata' => json_encode([
            'referral_code' => $referral['referral_code'],
            'referred_user_id' => $user->id,
        ]),
    ]);
}

private function attachCouponToUser(Coupon $coupon, int $appId, int $userId): void
{
    DB::table('coupon_user')->insert([
        'user_id' => $userId,
        'coupon_id' => $coupon->id,
        'app_id' => $appId,
        'used_at' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

private function sendReferralCouponCodeNotification(User $user, Coupon $coupon): void
{
  $appName=$coupon->app->name ?? 'Custospark';
    $message = "Hi {$user->first_name}, you have received a referral bonus! Use the code {$coupon->code} to get {$coupon->value}% off your next subscription for {$appName}. This code is valid until {$coupon->expires_at->format('Y-m-d H:i:s')}.";

   $this->notifier->sendNotification(
        'Referral Bonus',
        $message,
        'user',
        'both',
        $user->id
    );
}
}