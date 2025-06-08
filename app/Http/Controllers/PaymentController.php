<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\App;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Services\NotificationService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Services\SharedLogicService;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService,
        protected SharedLogicService $sharedLogicService
    ) {}

    public function getPaymentPage(){
        return view('payment.form');
    }

 
public function updateCurrency(Request $request)
{
    $request->validate([
        'currency' => 'required|exists:currencies,code',
    ]);

    $user = Auth::user();
    $user->preferred_currency = $request->currency;
    $user->save();

    return back()->with('success', 'Preferred currency updated.');
}

    /**
     * Cancel a payment by ID.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */

public function cancel($id)
{
    $payment = Payment::where('id', $id)
        ->whereIn('status', ['pending', 'failed'])
        ->firstOrFail();

    // Optional: Make sure only the owner can cancel
    if ($payment->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    $payment->delete();

    return redirect()->back()->with('success', 'Payment cancelled successfully.');
}


    public function orderSummary($appSlug, $planId)
{
    $user = Auth::user();

    $app = App::where('slug', $appSlug)->firstOrFail();
    $newPlan = Plan::findOrFail($planId);

    // Get the active subscription for this user and app
    $existingSubscription = Subscription::where('user_id', $user->id)
        ->where('app_id', $app->id)
        ->where('status', 'active')
        ->where(function ($query) {
            $query->whereNull('ends_at')->orWhere('ends_at', '>', now());
        })
        ->latest()
        ->first();
                    // Prevent new downgrade if one is already scheduled and paid
        if (
            optional($existingSubscription)->next_plan_id &&
            optional($existingSubscription->plan)->level &&
            optional($newPlan)->level &&
            ($newPlan->level <= $existingSubscription->plan->level) &&
            optional($existingSubscription)->next_plan_payment_status === 'paid'
        ) {
            return back()->with('error', 'A downgrade is already scheduled and paid. You cannot schedule another downgrade.');
        }


    // If free or trial plan and no existing subscription, activate immediately
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

    $now = now();
    $finalAmount = $newPlan->price;
    $isUpgrade = false;
    $isPaidDowngrade = false;
    $remainingDays=0;
    $proratedCredit = 0;
    

    if ($existingSubscription) {
        $oldPlan = Plan::find($existingSubscription->plan_id);
        $oldLevel = (int) trim($oldPlan->level ?? 0);
        $newLevel = (int) trim($newPlan->level ?? 0);

                if ($existingSubscription->plan_id === $planId) {
                    return back()->with('info', 'You are already subscribed to this plan.');
                }
   

                if ($newLevel > $oldLevel) {
                        // === Upgrade case ===
                        $isUpgrade = true;

                        // Default values
                        $proratedCredit = 0;
                        $finalAmount = $newPlan->price;

                        // Only apply proration if a successful payment exists for the current subscription
                        $hasSuccessfulPayment = Payment::where('subscription_id', $existingSubscription->id)
                            ->where('status', 'successful')
                            ->exists();

                        if ($hasSuccessfulPayment) {
                            // Calculate remaining days on old subscription (can be 0 or negative if expired)
                            $remainingDays = $existingSubscription->ends_at
                                ? max(0, $now->diffInDays($existingSubscription->ends_at))
                                : 0;
                            // Calculate prorated credit: price of old plan per day * remaining days
                            $dailyRateOldPlan = $oldPlan->price / 30; // assuming 30-day billing cycle
                            $proratedCredit = round($dailyRateOldPlan * $remainingDays, 2);

                            // Final amount = new plan price - prorated credit from old plan
                            $finalAmount = max(0, $newPlan->price - $proratedCredit);
                        }
                      
                    }
                 elseif ($newLevel < $oldLevel) {
                                    // === Downgrade case ===
                                    if ($newPlan->price == 0 || $newPlan->plan_type === 'free') {
                                        // Free downgrade - schedule immediately without payment
                                        $existingSubscription->update([
                                            'next_plan_id' => $newPlan->id,
                                        ]);

                                        app(NotificationService::class)->sendNotification(
                                            'Downgrade Scheduled',
                                            'Your plan will be downgraded to ' . $newPlan->name .
                                            ' after your current billing period ends on ' . optional($existingSubscription->ends_at)->toFormattedDateString() . '.',
                                            'user',
                                            'both',
                                            $user->id
                                        );

                                        return redirect()->back()->with('info',
                                            "Your downgrade to {$newPlan->name} has been scheduled after the current period."
                                        );
                                    }

                                    // Paid downgrade: user must pay difference - show order summary with payment
                                    $isPaidDowngrade = true;
                                               }

            }
    return view('payment.order_summary', [
        'user' => $user,
        'app' => $app,
        'plan' => $newPlan,
        'existingSubscription' => $existingSubscription,
        'finalAmount' => $finalAmount,
        'isUpgrade' => $isUpgrade,
        'isPaidDowngrade' => $isPaidDowngrade,
        'remainingDays' => $remainingDays,
        'proratedCredit' => $proratedCredit,
    ]);
}



 public function initiatePayment(Request $request, $appId, $planId)
{

    //Disabled for now
    return redirect()->back()->with('error', 'This Service is temporarily unavailable. Please try again later.');

      $request->validate([
        'finalAmount' => 'required|numeric|min:0',
        'payment_currency' => 'nullable|exists:currencies,code',
        'payment_id' => 'nullable|exists:payments,id',
    ]);


    // Get the final amount from the form input
    $finalAmount = $request->input('finalAmount');
    $paymentCurrency = $request->input('payment_currency');
    $paymentId = $request->input('payment_id');

    // Retrieve the app and plan
    $user = Auth::user();
    $app = App::findOrFail($appId);
    $plan = Plan::where('id', $planId)
        ->where('app_id', $app->id)
        ->whereIn('plan_type', ['paid','trial', 'free'])
        ->firstOrFail();
    
    // 🧾 Generate a unique transaction reference (tx_ref)
    $tx_ref = 'TX-' . uniqid($app->name . '-') . '-' . now()->format('YmdHis');

    // 🔗 Redirect URL after payment
              $redirect_url = route('payment.callback');


            if($paymentId && !is_null($paymentCurrency)){
                $pendingPayment = Payment::find($paymentId);
                if(!$pendingPayment){
                    return back()->with('error', 'Invalid payment ID provided.');
                }
            $response = Http::withToken(env('FLW_SECRET_KEY'))->post(env('FLW_BASE_URL').'/payments', [
                'tx_ref' => $tx_ref,
                'amount' => $finalAmount ?? $plan->price,
                'currency' => $paymentCurrency ?? ($user->preferred_currency ?? 'USD'),
                'redirect_url' => $redirect_url,
                'payment_options' => 'card,mobilemoneyuganda',
                'customer' => [
                    'email' => $user->email,
                    'phonenumber' => $user->phone ?? '256000000000',
                    'name' => $user->full_name ?? "{$user->first_name} {$user->last_name}",
                ],
                'customizations' => [
                    'title' => "{$app->name} - {$plan->name} Plan",
                    'description' => "Subscription payment for {$app->name}",
                    'logo' => 'https://yourdomain.com/logo.png',
                ]
            ]);

            $data = $response->json();

            // 🔁 Redirect to payment page if successful
            if (isset($data['data']['link'])) {
                session([
                    'tx_ref' => $tx_ref,
                    'app_id' => $appId,
                    'plan_id' => $planId,
                    'pending_payment_id' => $pendingPayment ? $pendingPayment->id : null,
                ]);

                return redirect()->away($data['data']['link']);
            }
            }


    // 🔍 Check if user already has an active subscription for this app and plan
    $existingSubscription = Subscription::where('user_id', $user->id)
        ->where('app_id', $app->id)
        ->where('plan_id', $plan->id)
        ->where('status', 'active')
        ->where(function ($query) {
            $query->whereNull('ends_at')->orWhere('ends_at', '>', now());
        })
        ->first();


    if ($existingSubscription && $existingSubscription->status === 'active') {
        return back()->with('info', 'You already have an active subscription for this plan.');
    }
    
    // 🔗 Initiate payment request to Flutterwave
    $response = Http::withToken(env('FLW_SECRET_KEY'))->post(env('FLW_BASE_URL').'/payments', [
        'tx_ref' => $tx_ref,
        'amount' => $finalAmount ?? $plan->price,
        'currency' => $paymentCurrency ?? ($user->preferred_currency ?? 'USD'),
        'redirect_url' => $redirect_url,
        'payment_options' => 'card,mobilemoneyuganda',
        'customer' => [
            'email' => $user->email,
            'phonenumber' => $user->phone ?? '256000000000',
            'name' => $user->full_name ?? "{$user->first_name} {$user->last_name}",
        ],
        'customizations' => [
            'title' => "{$app->name} - {$plan->name} Plan",
            'description' => "Subscription payment for {$app->name}",
            'logo' => 'https://yourdomain.com/logo.png',
        ]
    ]);

    $data = $response->json();

    if (isset($data['data']['link'])) {
        $sessionData = [
            'tx_ref' => $tx_ref,
            'app_id' => $appId,
            'plan_id' => $planId,
        ];

        // Include applied_coupon if it's present in session
        if (session()->has('applied_coupon')) {
            $sessionData['applied_coupon'] = session('applied_coupon');
        }

    session($sessionData);

    return redirect()->away($data['data']['link']);
}


    return back()->with('error', 'Unable to initiate payment at the moment.');
}

public function callback(Request $request)
{
    // dd('Callback received', $request->all());
    $user = Auth::user();
    $tx_ref = session('tx_ref');
    $appId = session('app_id');
    $planId = session('plan_id');
    $transaction_id = $request->query('transaction_id');
    $pendingPaymentId = session('pending_payment_id');
    $appliedCoupon = session('applied_coupon');
   
       if (!$user || !$tx_ref || !$transaction_id) {
        Log::error('[FLW Callback] Missing required user or session data.', [
            'user' => $user ? $user->id : null,
            'tx_ref' => $tx_ref,
            'transaction_id' => $transaction_id,
        ]);
        return redirect()->route('dashboard')->with('error', 'Missing or invalid payment data.');
    }

     $verifyResponse = Http::withToken(env('FLW_SECRET_KEY'))
        ->get(env('FLW_BASE_URL') . '/transactions/' . $transaction_id . '/verify');

    if (!$verifyResponse->ok()) {
        Log::error('[FLW Callback] Verification request failed', ['response' => $verifyResponse->body()]);
        return redirect()->route('dashboard')->with('error', 'Could not verify payment.');
    }

    $data = $verifyResponse->json();

    if (!isset($data['data']['status']) || $data['data']['status'] !== 'successful') {
        Log::warning('[FLW Callback] Unsuccessful or incomplete payment', ['response' => $data]);
        return redirect()->route('dashboard')->with('error', 'Payment was unsuccessful.');
    }

    if (Payment::where('transaction_id', $transaction_id)->exists()) {
        Log::info('[FLW Callback] Duplicate transaction detected', ['transaction_id' => $transaction_id]);
        return redirect()->route('dashboard')->with('info', 'This payment has already been processed.');
    }
    
    if ($pendingPaymentId) {
        $pendingPayment = Payment::find($pendingPaymentId);
       // If there's a pending payment, we don't need to create a new one
        $pendingPayment->update([
            'status' => 'successful',
            'paid_at' => now(),
            'transaction_id' => $transaction_id,
        ]);
        $existingSubscription=Subscription::where('id',$pendingPayment->subscription_id)->first();
        $existingSubscription->update([
            'next_plan_payment_status' => 'paid',
            'next_plan_payment_id' => $pendingPayment->id,
        ]);
        
        Log::info('[FLW Callback] Pending payment updated successfully', [
            'payment_id' => $pendingPayment->id,
            'transaction_id' => $transaction_id,
        ]);
        app(NotificationService::class)->sendNotification(
            'Payment Successful',
            'Your payment of '.$pendingPayment->currency.' '.$pendingPayment->amount. ' has been successfully completed.',
            'user',
            'both',
            $user->id
        );
        Session::forget(['pending_payment_id']);
        return redirect()->route('dashboard')->with('success', 'Payment updated successfully.');
                
       
    }


    if (!$user || !$tx_ref || !$appId || !$planId || !$transaction_id) {
        Log::error('[FLW Callback] Missing required user or session data.', [
            'user' => $user ? $user->id : null,
            'tx_ref' => $tx_ref,
            'app_id' => $appId,
            'plan_id' => $planId,
            'transaction_id' => $transaction_id,
        ]);
        return redirect()->route('dashboard')->with('error', 'Missing or invalid payment data.');
    }

    Log::info('[FLW Callback] Callback received', [
        'user_id' => $user->id,
        'tx_ref' => $tx_ref,
        'transaction_id' => $transaction_id,
        'app_id' => $appId,
        'plan_id' => $planId,
    ]);

     // Process any applied coupon if it exists in the session
 if ($appliedCoupon) {
        Log::info('[FLW Callback] Applied coupon', [
            'coupon_type' => $appliedCoupon['type'] ?? 'unknown',
            'code' => $appliedCoupon['code'],
            'value' => $appliedCoupon['value'] ?? null,
            'app_id' => $appId,
            'discount' => $appliedCoupon['discount'] ?? null,
        ]);
        $this->sharedLogicService->processCouponReferralAndRewards($appliedCoupon, $appId);
    } else {
        Log::info('[FLW Callback] No applied coupon found in session.');
    }

    DB::beginTransaction();

    try {
        $newAmount = $data['data']['amount'];
        $currency = $data['data']['currency'];
        $method = $data['data']['payment_type'] ?? 'unknown';

        $existingSubscription = Subscription::where('user_id', $user->id)
            ->where('app_id', $appId)
            ->first();

        $payment = new Payment([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'subscription_id' => null, // To be set after creation
            'amount' => $newAmount,
            'currency' => $currency,
            'method' => $method,
            'status' => 'successful',
            'transaction_id' => $transaction_id,
            'paid_at' => now(),
        ]);

        $newPlan = Plan::find($planId);

        if (!$newPlan) {
            throw new \Exception('New plan not found.');
        }

        if ($existingSubscription) {
            $canUpdate = false;
            $oldPlan = Plan::find($existingSubscription->plan_id);

            if (
                $existingSubscription->status === 'trial' ||
                $existingSubscription->status === 'grace' ||
                (
                    $existingSubscription->status === 'active' &&
                    $existingSubscription->plan_id !== $planId
                ) ||
                (
                    is_null($existingSubscription->ends_at) &&
                    is_null($existingSubscription->trial_ends_at)
                )
            ) {
                $canUpdate = true;
            }

            if ($canUpdate) {
            $proratedAmount = 0;
            $proratedExtraDays = 0;
            $direction = 'upgrade'; // default assumption
            $now = now();
            $finalAmount = $newAmount;

            // Trim levels to avoid any whitespace issues and convert to int
            $oldLevel = isset($oldPlan->level) ? (int) trim($oldPlan->level) : 0;
            $newLevel = isset($newPlan->level) ? (int) trim($newPlan->level) : 0;

            if ($existingSubscription->ends_at ||($oldPlan && $newPlan)) {
                $remainingDays = $now->diffInDays($existingSubscription->ends_at, false);
                $proratedExtraDays = (Int)round( $remainingDays,1);

                if ($oldLevel < $newLevel) {
                    // Immediate Upgrade
                    $direction = 'upgrade';

                    // Calculate proration credit based on old plan price and remaining days
                    $proratedAmount = round(($oldPlan->price / 30) * $proratedExtraDays, 2);

                    // Final amount is new amount minus prorated credit (min 0)
                    $finalAmount = max(0, $newAmount - $proratedAmount);

                    $existingSubscription->update([
                        'plan_id' => $planId,
                        'status' => 'active',
                        'trial_ends_at' => null,
                        'ends_at' => $now->copy()->addMonth(),
                        'renews_at' => $now->copy()->addMonth(),
                        'next_plan_id' => null,
                    ]);


                    Log::info('[FLW Callback] Upgrade with proration', [
                        'old_plan' => $oldPlan->name,
                        'new_plan' => $newPlan->name,
                        'prorated_amount' => $proratedAmount,
                        'extra_days' => $proratedExtraDays,
                        'final_amount' => $finalAmount,
                    ]);

                } elseif ($oldLevel > $newLevel) {
                // Downgrade (Deferred)
                $direction = 'downgrade';

                // Full amount for new plan, effect after current period ends
                $finalAmount = $newAmount;

                // Update subscription to schedule downgrade after current period
                $existingSubscription->update([
                    'next_plan_id' => $planId,
                    'next_plan_payment_status' => 'paid',
                    'next_plan_payment_id' => $payment->id,
                ]);

                Log::info('[FLW Callback] Downgrade scheduled', [
                    'old_plan' => $oldPlan->name,
                    'new_plan' => $newPlan->name,
                    'final_amount' => $finalAmount,
                    'effective_on' => optional($existingSubscription->ends_at)->toDateTimeString(),
                ]);
            }
            else {
                    // Neutral switch - same level, possibly different plan
                    $direction = 'neutral';

                    Log::info('[FLW Callback] Plan switch with same level', [
                        'old_plan' => $oldPlan->name,
                        'new_plan' => $newPlan->name,
                    ]);

                    // Update immediately without proration or scheduling
                    $existingSubscription->update([
                        'plan_id' => $planId,
                        'status' => 'active',
                        'trial_ends_at' => null,
                        'ends_at' => $now->copy()->addMonth(),
                        'renews_at' => $now->copy()->addMonth(),
                        'next_plan_id' => null,
                    ]);
                                        

                }
            }

            // Save payment info
            $payment->amount = $finalAmount;
            $payment->prorated_amount = $proratedAmount;
            $payment->prorated_extra_days = $proratedExtraDays;
            $payment->subscription_id = $existingSubscription->id;
            $payment->save();

            DB::commit();
            app(NotificationService::class)->sendNotification(
                'Payment Successful',
                'Thank you for your payment of '.$payment->currency.' '.$payment->amount. '.Your subscription has been updated successfully.',
                'user',
                'both',
                $user->id
            );

            // Notify user based on direction
            if ($direction === 'upgrade') {
                app(NotificationService::class)->sendNotification(
                    'Subscription Upgraded',
                    'Your subscription has been upgraded to the ' . $newPlan->name .
                    ' plan. You received credit for ' . $proratedExtraDays . ' unused days from your previous plan.',
                    'user',
                    'both',
                    $user->id
                );

                return redirect()->route('dashboard')->with('success', 'Subscription upgraded successfully!');
            } elseif ($direction === 'downgrade') {
                app(NotificationService::class)->sendNotification(
                    'Downgrade Scheduled',
                    'Your plan will be downgraded to ' . $newPlan->name .
                    ' after your current billing period ends on ' . optional($existingSubscription->ends_at)->toFormattedDateString() . '.',
                    'user',
                    'both',
                    $user->id
                );

                return redirect()->route('dashboard')->with('info', 'Downgrade scheduled. You will remain on your current plan until the end of your billing cycle.');
            }

            return redirect()->route('dashboard')->with('success', 'Subscription updated successfully!');
        }




            DB::commit();
            return redirect()->route('dashboard')->with('info', 'You already have an active subscription.');
        }

        // No existing subscription — create new
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'app_id' => $appId,
            'plan_id' => $planId,
            'status' => 'active',
            'trial_ends_at' => null,
            'ends_at' => now()->addMonth(),
            'renews_at' => now()->addMonth(),
        ]);

        $payment->subscription_id = $subscription->id;
        $payment->save();

        DB::commit();

        app(NotificationService::class)->sendNotification(
            'Subscription Activated',
            'Thank you! Your subscription to ' . $newPlan->name . ' has been successfully activated.',
            'user',
            'both',
            $user->id
        );

        Session::forget(['tx_ref', 'app_id', 'plan_id']);

        return redirect()->route('dashboard')->with('success', 'Subscription created successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('[FLW Callback] Exception caught', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        Session::forget(['tx_ref', 'app_id', 'plan_id']);

        return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please contact support.');
    }

    // Process any applied coupon if it exists in the session
 if ($appliedCoupon) {
        Log::info('[FLW Callback] Applied coupon', [
            'coupon_type' => $appliedCoupon['type'] ?? 'unknown',
            'code' => $appliedCoupon['code'],
            'value' => $appliedCoupon['value'] ?? null,
            'app_id' => $appId,
            'discount' => $appliedCoupon['discount'] ?? null,
        ]);
        $this->sharedLogicService->processCouponReferralAndRewards($appliedCoupon, $appId);
    } else {
        Log::info('[FLW Callback] No applied coupon found in session.');
    }

}


    /**
     * Store a new payment.
     *
     * @param  StorePaymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentRequest $request)
    {
        $paymentData = $request->validated();
        
        // Call service to create a payment
        $payment = $this->paymentService->createPayment($paymentData);

        return response()->json([
            'message' => 'Payment recorded successfully.',
            'data' => $payment
        ], 201);
    }

    /**
     * Get all payments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = $this->paymentService->getAllPayments();
        
        return response()->json([
            'data' => $payments
        ], 200);
    }

    /**
     * Get a payment by ID.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = $this->paymentService->getPaymentById($id);

        if (!$payment) {
            return response()->json([
                'message' => 'Payment not found'
            ], 404);
        }

        return response()->json([
            'data' => $payment
        ], 200);
    }
}

