<?php

// app/Http/Controllers/SubscriptionController.php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Models\App;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class SubscriptionController extends Controller
{
    protected $notifier;
    protected $service;
    public function __construct()
    {
        $this->notifier = app('App\Services\NotificationService');

    }


    public function cancelDowngrade(Request $request, $appSlug)
{
    $app = App::where('slug', $appSlug)->firstOrFail();

    $subscription = Subscription::where('app_id', $app->id)
        ->where('user_id', Auth::id())
        ->where('status', 'active')
        ->first();

    if (!$subscription || !$subscription->next_plan_id) {
        return redirect()->back()->with('error', 'No scheduled downgrade found.');
    }

    $subscription->next_plan_id = null;
    $subscription->save();

    return redirect()->back()->with('success', 'Scheduled downgrade has been cancelled.');
}



     public function scheduleDowngradePayLater(Request $request, App $app, Plan $plan)
{
     $request->validate([
        'finalAmount' => 'required|numeric|min:0',
    ]);

    $amountToBePaid=$request->input('finalAmount');
    $user = Auth::user();

    $subscription = Subscription::where('user_id', $user->id)
        ->where('app_id', $app->id)
        ->where(function ($query) {
            $query->whereNull('ends_at')->orWhere('ends_at', '>', now());
        })
        ->latest()
        ->first();


   if (!$subscription) {
    return back()->with('error', 'No active subscription found for this app.');
}

    // Prevent new downgrade if one is already scheduled and paid
    if ($subscription->next_plan_id && $subscription->next_plan_payment_status === 'paid') {
        return back()->with('error', 'A downgrade is already scheduled and paid. You cannot schedule another downgrade.');
    }


    // Ensure the current plan is higher than the one they're trying to downgrade to
    $currentPlan = $subscription->plan;

    if ($plan->level >= $currentPlan->level) {
        return back()->with('error', 'You can only schedule a downgrade to a lower-tier plan.');
    }

      $convertedAmount = \App\Helpers\CurrencyHelper::convert($currentPlan->price, $user->preferred_currency, $currentPlan->currency);   

    // Create payment record
    $payment = Payment::create([
        'user_id'          => $user->id,
        'subscription_id'  => $subscription->id,
        'amount'           => $amountToBePaid ?? $convertedAmount,
        'currency'         => $user->preferred_currency ?? $currentPlan->currency,
        'method'           => 'flutterwave',
        'status'           => 'pending',
        'description'      => 'Scheduled downgrade - pay later',
        'paid_at'          => null, // Payment not completed yet
        // Don't set 'paid_at' until payment is completed
    ]);

    // Schedule the downgrade
    $subscription->update([
        'next_plan_id'         => $plan->id,
        'next_plan_pay_status' => 'pending',
        'next_plan_payment_id' => $payment->id,
    ]);

    // Notify user
    $message = "Your downgrade to the {$plan->name} plan has been scheduled. Please complete the payment before the end of your current billing cycle to ensure a smooth transition.";
    app(NotificationService::class)->sendNotification(
        'Downgrade Scheduled - Payment Pending',
        $message,
        'user',
        'both',
        $user->id
    );

    return redirect()->route('dashboard')->with('success', 'Your downgrade has been scheduled. Please complete payment before the next billing cycle to activate it.');
}


public function start($appId, $planId)
{
    $user = Auth::user();

    // Retrieve app and plan
    $app = App::findOrFail($appId);
    $plan = Plan::where('id', $planId)
                ->where('app_id', $app->id)
                ->firstOrFail();

    // Check if user already has a subscription for this app
    $existingSubscription = Subscription::where('user_id', $user->id)
                                ->where('app_id', $app->id)
                                ->first();

    if ($existingSubscription) {
        return redirect()->back()
            ->with('info', 'You already have a subscription for this app.');
    }

    DB::beginTransaction();

    try {
        // Create new subscription instance
        $subscription = new Subscription();
        $subscription->user_id = $user->id;
        $subscription->app_id = $app->id;
        $subscription->plan_id = $plan->id;

        if ($plan->plan_type === 'free') {
            // For free plans, active indefinitely with no expiration
            $subscription->status = 'active';
            $subscription->trial_ends_at = null;
            $subscription->ends_at = null;
            $subscription->renews_at = null;

        } elseif ($plan->plan_type === 'trial') {
            // For trial plans, set trial period end date
            $trialDays = $plan->trial_days ?? 14;
            $subscription->status = 'trial';
            $subscription->trial_ends_at = now()->addDays($trialDays);
            $subscription->ends_at = null;
            $subscription->renews_at = null;

        } else {
            // For paid plans, defer to payment flow
            DB::rollBack();
            return redirect(route('dashboard.pricing.app', $app->id))
                ->with('warning', "Please select a paid plan for $app->name to get started.");
        }

        $subscription->save();

        // No payment record for free/trial plans, but notify user
        app(NotificationService::class)->sendNotification(
            'Subscription Activated',
            "Hello $user->first_name, you've successfully subscribed to $app->name's {$plan->name} plan.",
            'user',
            'in_app',
            $user->id
        );

        DB::commit();

        return redirect()->back()
            ->with('success', "Successfully subscribed to {$plan->name}.");

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('[Subscription Start] Exception caught', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'user_id' => $user->id,
            'app_id' => $app->id,
            'plan_id' => $plan->id,
        ]);
        return redirect()->back()
            ->with('error', 'Failed to start subscription. Please try again or contact support.');
    }
}

public function show()
{
    $user = Auth::user();
    $subscriptions = $user->subscriptions()
        ->with(['plan.app', 'payments']) // eager load relationships
        ->latest()
        ->get();

    return view('subscriptions.index', compact('subscriptions'));
}


    public function payment($appSlug, $planId)
{
    $user = Auth::user();

    // Find the app by slug
    $app = App::where('slug', $appSlug)->firstOrFail();

    // Ensure the plan belongs to the app and is a paid plan
    $plan = Plan::where('id', $planId)
                ->where('app_id', $app->id)
                ->where('plan_type', 'paid')
                ->firstOrFail();

    // Check if user already has an active subscription to this app and plan
    $existingSubscription = Subscription::where('user_id', $user->id)
                                        ->where('app_id', $app->id)
                                        ->where('plan_id', $plan->id)
                                        ->whereIn('status', ['active', 'trial', 'grace'])
                                        ->first();

    if ($existingSubscription) {
        return redirect($app->baseurl . '/dashboard')
            ->with('message', 'You are already subscribed to this plan.');
    }

    // Show the payment page
    return view('subscriptions.payment', compact('app', 'plan'));
}


    public function store(SubscriptionRequest $request)
    {
        $subscription = $this->service->create($request->validated());

        return response()->json([
            'message' => 'Subscription created successfully.',
            'data' => $subscription,
        ]);
    }

    public function update(SubscriptionRequest $request, Subscription $subscription)
    {
        $updated = $this->service->update($subscription, $request->validated());

        return response()->json([
            'message' => 'Subscription updated successfully.',
            'data' => $updated,
        ]);
    }

    public function destroy(Subscription $subscription)
    {
        $this->service->delete($subscription);

        return response()->json(['message' => 'Subscription deleted.']);
    }
    // app/Http/Controllers/SubscriptionController.php

public function activate(Subscription $subscription)
{
    $sub = $this->service->activate($subscription);
    return response()->json(['message' => 'Activated', 'data' => $sub]);
}

public function cancel(Subscription $subscription)
{
    $sub = $this->service->cancel($subscription);
    return response()->json(['message' => 'Cancelled', 'data' => $sub]);
}

public function renew(Subscription $subscription)
{
    $sub = $this->service->renew($subscription);
    return response()->json(['message' => 'Renewed', 'data' => $sub]);
}

}

