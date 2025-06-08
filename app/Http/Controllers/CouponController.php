<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class CouponController extends Controller
{
    /**
     * Show all coupons that belong to the authenticated user (used or assigned).
     */


public function myCoupons(Request $request)
{
    $user = Auth::user();
    $now = now();

    // Fetch all coupons assigned to the user along with app and pivot data
    $coupons = $user->coupons()
        ->with(['app'])
        ->withPivot(['times_used', 'max_uses_per_user'])
        ->get()
        ->map(function ($coupon) use ($now) {
            $used = $coupon->pivot->times_used ?? 0;
            $maxPerUser = $coupon->pivot->max_uses_per_user ?? $coupon->max_uses_per_user ?? null;

            $isExpired = $coupon->expires_at && $coupon->expires_at->lt($now);
            $hasReachedUserLimit = $maxPerUser !== null && $used >= $maxPerUser;
            $isActive = $coupon->active && !$isExpired && !$hasReachedUserLimit;

            $daysLeft = $coupon->expires_at ? $coupon->expires_at->diffInDays($now, false) : null;

            // Attach computed attributes
            $coupon->is_active = $isActive;
            $coupon->is_expired = $isExpired;
            $coupon->has_reached_user_limit = $hasReachedUserLimit;
            $coupon->days_left = $daysLeft;
            $coupon->used = $used;
            $coupon->max_per_user = $maxPerUser;

            return $coupon;
        });

    // Pagination
    $perPage = 15;
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $pagedCoupons = new LengthAwarePaginator(
        $coupons->forPage($currentPage, $perPage),
        $coupons->count(),
        $perPage,
        $currentPage,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    // Coupon statistics
    $stats = [
        'total' => $coupons->count(),
        'active' => $coupons->where('is_active', true)->count(),
        'expired' => $coupons->where('is_expired', true)->count(),
        'used_up' => $coupons->where('has_reached_user_limit', true)->count(),
        'expiring_soon' => $coupons->filter(fn($c) => $c->is_active && $c->days_left !== null && $c->days_left <= 3)->count(),
    ];

    return view('users.coupons.my', [
        'coupons' => $pagedCoupons,
        'stats' => $stats,
    ]);
}



    /**
     * Show the earnings (rewards) from coupon usage for the authenticated user.
     * Could be earnings earned by the user via coupons they created or used.
     */
    public function earnings(Request $request)
    {
        $user = Auth::user();

        // Assuming you track coupon earnings in a related model or a field in pivot
        // Here is a simple example fetching coupons with a 'reward_earned' field on pivot

        $coupons = $user->coupons()
                        ->with('app')
                        ->get()
                        ->map(function ($coupon) use ($user) {
                            $timesUsed = $coupon->pivot->times_used ?? 0;
                            // Calculate total earned from this coupon — customize as per your logic
                            $earned = $timesUsed * $coupon->value; // example logic

                            return [
                                'code' => $coupon->code,
                                'app' => $coupon->app->name,
                                'times_used' => $timesUsed,
                                'earned' => $earned,
                                'type' => $coupon->type,
                            ];
                        });

        // Sum total earnings
        $totalEarnings = $coupons->sum('earned');

        return view('user.coupons.earnings', compact('coupons', 'totalEarnings'));
    }
    public function generateCoupon($appId, $type = 'percentage', $value = 10)
{
    return Coupon::create([
        'app_id' => $appId,
        'code' => strtoupper(Str::random(8)),
        'type' => $type,
        'value' => $value,
        'starts_at' => now(),
        'expires_at' => now()->addDays(30),
        'max_uses' => 100,
        'max_uses_per_user' => 1,
        'active' => true,
    ]);
}


public function rewardCouponCreator(Coupon $coupon)
{
    $usageCount = $coupon->users()->count();

    if ($usageCount >= 10 && !$coupon->rewarded) {
        // Example: grant bonus to coupon creator (if tracking creator)
        $creator = $coupon->createdBy;
        $creator->credits += 10;
        $creator->save();

        $coupon->rewarded = true;
        $coupon->save();
    }
}


public function applyCoupon(Request $request)
{
    $request->validate([
        'coupon_code' => 'required|string',
        'app_id' => 'required|exists:apps,id',
        'payment_amount' => 'required|numeric|min:0',
    ]);

    $user = Auth::user();
    $code = $request->input('coupon_code');
    $appId = $request->input('app_id');
    $price = (float) $request->input('payment_amount');
    $now = now();

    $coupon = Coupon::where('code', $code)
        ->where('app_id', $appId)
        ->where('active', 1)
        ->where(function ($q) use ($now) {
            $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
        })
        ->where(function ($q) use ($now) {
            $q->whereNull('expires_at')->orWhere('expires_at', '>=', $now);
        })
        ->first();

    if (!$coupon) {
        return back()->with('coupon_error', 'Invalid or expired coupon.');
    }

    // Prevent using coupons on zero-amount payments (except free_trial)
    if ($price <= 0 && $coupon->type !== 'free_trial') {
        return back()->with('coupon_error', 'Coupon cannot be applied to zero or negative payments.');
    }

    // Global usage check
    $totalUsage = $coupon->usages()->sum('times_used');
    if ($coupon->max_uses !== null && $totalUsage >= $coupon->max_uses) {
        return back()->with('coupon_error', 'This coupon has reached its usage limit.');
    }

    // Per-user usage check
    $userUsage = $coupon->usages()->where('user_id', $user->id)->first();
    if (
        $coupon->max_uses_per_user !== null &&
        $userUsage &&
        $userUsage->times_used >= $coupon->max_uses_per_user
    ) {
        return back()->with('coupon_error', 'You have already used this coupon the maximum allowed times.');
    }

    // Calculate discount with extra safety
    $discount = 0;

    switch ($coupon->type) {
        case 'percentage':
            if ($coupon->value > 100 || $coupon->value < 0) {
                return back()->with('coupon_error', 'Invalid percentage value in coupon.');
            }
            $discount = ($coupon->value / 100) * $price;
            break;

        case 'fixed':
        case 'custom':
            if ($coupon->value <= 0) {
                return back()->with('coupon_error', 'Invalid coupon value.');
            }
            $discount = min($coupon->value, $price);
            break;

        case 'free_trial':
            $discount = $price; // Cover entire payment
            break;

        default:
            return back()->with('coupon_error', 'Unknown coupon type.');
    }

    // Round and validate final amount
    $discount = round($discount, 2);
    $finalPrice = max(round($price - $discount, 2), 0);

    // If discount ends up being zero, warn user
    if ($discount <= 0) {
        return back()->with('coupon_error', 'This coupon does not provide any discount.');
    }

    // Optional: Save/update coupon usage (uncomment only on successful payment flow)
    /*
    
    */

    // Store for use during checkout
    Session::put('applied_coupon', [
        'code' => $coupon->code,
        'type' => $coupon->type,
        'value' => $coupon->value,
        'discount' => $discount,
        'final_price' => $finalPrice,
        'description' => $coupon->description,
    ]);

    return back()->with('coupon_success', 'Coupon applied successfully!');
}


public function remove(Request $request)
{
    session()->forget('applied_coupon');
    return back()->with('coupon_success', 'Coupon removed successfully.');
}



}

