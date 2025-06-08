<?php
namespace App\Helpers;

use App\Models\App;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Feature;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionHelper
{
    public static function getAppIdBySlug(string $slug): ?int
    {
        return App::where('slug', $slug)->value('id');
    }

    public static function getActiveSubscription(int $appId): ?Subscription
    {
        $user = Auth::user();
        if (!$user) return null;

        return Subscription::where('user_id', $user->id)
            ->where('app_id', $appId)
            ->whereIn('status', ['active', 'trial', 'grace'])
            ->where(function ($query) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->first();
    }
   public static function hasFeature(string $appSlug, string $featureCode): bool
{
    $appId = self::getAppIdBySlug($appSlug);
    if (!$appId) return false;

    $subscription = self::getActiveSubscription($appId);
    if (!$subscription) return false;

    $currentPlan = Plan::where('id', $subscription->plan_id)
        ->where('app_id', $appId)
        ->first();

    if (!$currentPlan || $currentPlan->level === null) return false;

    $currentLevel = $currentPlan->level;

    // Get all plan IDs with level less than or equal to current plan (inheritance)
    $planIds = Plan::where('app_id', $appId)
        ->where('level', '<=', $currentLevel)
        ->pluck('id');

    $result= DB::table('feature_plans')
        ->join('features', 'feature_plans.feature_id', '=', 'features.id')
        ->whereIn('feature_plans.plan_id', $planIds)
        ->where('features.code', $featureCode)
        ->exists();
      return $result;
      }

      /**
     * Check if the currently authenticated user has access to a given feature
     * based on their subscription to a specific app.
     *
     * @param string $appSlug The slug identifier of the app (e.g., 'custosell')
     * @param string $featureCode The unique code of the feature (e.g., 'advanced-reports')
     * @return bool True if the user has access to the feature, false otherwise
     */

public static function userHasFeature(string $appSlug, string $featureCode): bool
{
    // Get the currently authenticated user
    $user = Auth::user();
    if (!$user) {
        return false; // No authenticated user
    }

    // Find the app by its slug
    $app = App::where('slug', $appSlug)->first();
    if (!$app) {
        return false; // App not found
    }

    Log::info("User ID: {$user->id}, App: {$app->name} (ID: {$app->id})");

    // Get the latest valid subscription (active, trial, or grace) for this app

$subscription = Subscription::where('user_id', $user->id)
    ->where('app_id', $app->id)
    ->whereIn('status', ['active', 'trial', 'grace'])
    ->where(function ($query) {
        $query->whereNull('ends_at')
              ->orWhere('ends_at', '>=', now());
    })
    ->latest('created_at')
    ->first();


    if (!$subscription) {
        return false; // No valid subscription
    }

    Log::info("Subscription ID: {$subscription->id}");

    // Get the plan attached to the subscription
    $plan = Plan::find($subscription->plan_id);
    if (!$plan) {
        return false; // No plan found
    }

    Log::info("Plan ID: {$plan->id}, Plan Name: {$plan->name}, Level: {$plan->level}");

    // Get all feature codes accessible under this plan level
    $accessibleFeatures = Feature::where('app_id', $app->id)
        ->where('min_plan_level', '<=', $plan->level)
        ->pluck('code')
        ->map(fn($code) => trim($code)) // Trim spaces for consistency
        ->toArray();

    Log::info("Accessible Feature Codes:");
    Log::info($accessibleFeatures);

    // Trim the incoming feature code as well
    $featureCodeTrimmed = trim($featureCode);
    Log::info("Checking access for Feature Code: '$featureCodeTrimmed' against Plan Level: {$plan->level}");

    // Determine if the feature is accessible
    $hasFeature = in_array($featureCodeTrimmed, $accessibleFeatures);

    Log::info("Feature '{$featureCodeTrimmed}' access: " . ($hasFeature ? 'GRANTED' : 'DENIED'));

    return $hasFeature;
}




}


