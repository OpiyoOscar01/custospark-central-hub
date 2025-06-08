<?php
namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Plan;
use App\Helpers\SubscriptionHelper;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class PricingController extends Controller
{public function showAppPlans(int $app)
{
    $app = App::findOrFail($app);

    $plans = $app->plans()
        ->with('features')
        ->orderBy('price', 'asc')
        ->get();

    $currentSubscription = SubscriptionHelper::getActiveSubscription($app->id);
    $currentPlan = $currentSubscription ? Plan::find($currentSubscription->plan_id) : null;

    return view('pricing.dashboard.app_plans', [
        'app' => $app,
        'plans' => $plans,
        'currentPlan' => $currentPlan,
        'currentSubscription' => $currentSubscription,
    ]);
}


    // public function showPricing(int $app)
    // {
    //     $app = App::findOrFail($app);

    //     $plans = $app->plans()
    //         ->with('features')
    //         ->orderBy('price', 'asc')
    //         ->get();

    //     $currentSubscription = SubscriptionHelper::getActiveSubscription($app->id);
    //     $currentPlan = $currentSubscription ? Plan::find($currentSubscription->plan_id) : null;

    //     return view('pages.app_plans', [
    //         'app' => $app,
    //         'plans' => $plans,
    //         'currentPlan' => $currentPlan,
    //     ]);
    // }
    // use at top:


public function showPricing(int $app)
{
    $app = App::with('plans.features')->findOrFail($app);

    // Fetch plans once, sorted by price
    $plans = $app->plans->sortBy('price')->values();

    if (Auth::check()) {
        $user = Auth::user();

        $currentSubscription = Subscription::where('user_id', $user->id)
            ->where('app_id', $app->id)
            ->whereNull('ends_at')
            ->latest()
            ->first();

        $currentPlan = $currentSubscription?->plan;

        return view('pages.app_plans', compact('app', 'plans', 'currentPlan', 'currentSubscription'));
    }

    return view('pages.app_plans', compact('app', 'plans'));
}


}


