<?php

namespace App\Providers;

use App\Models\App;
use App\Models\Currency;
use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use Illuminate\Support\Facades\Route;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('layouts.employee', function ($view) {
            $user = Auth::user();
            $subscriptionCount = 0;
            $currentPlan = 'Free';

            if ($user) {
                $subscriptionCount = Subscription::where('user_id', $user->id)->count();
                $latestSubscription = $user->subscriptions()->latest()->first();
                $currentPlan = $latestSubscription?->plan?->name ?? 'Free';
            }
            
    


        $apps = App::select('id', 'name', 'slug', 'icon_url')->get();
        $defaultIcon = asset('images/custospark.png'); // default icon path

        // Check if any pricing-related route is active to open dropdown
        $isPricingActive = Route::is('dashboard.pricing.app');
        // Get the current app route parameter (app ID)
        $currentAppId = request()->route('app');
      

        $notifications = Notification::where(function ($q) {
            $q->where('target_type', 'system')
            ->orWhere('user_id', Auth::id());
        })
        ->with('readers') // eager load to reduce queries
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get();

        $unreadCount = $notifications->filter(function ($notification) {
            return !$notification->isReadBy(Auth::user());
        })->count();
        $user = Auth::user();
         

            $view->with([
                'subscriptionCount' => $subscriptionCount,
                'currentPlan' => $currentPlan,
                'apps' => $apps,
                'defaultIcon' => $defaultIcon,
                'isPricingActive' => $isPricingActive,
                'currentAppId' => $currentAppId,
                'notifications' => $notifications,
                'unreadCount' => $unreadCount,
                'user' => $user,
            ]);
        });
    }
    /**
     * Register any application services.
     *
     * @return void
     */
   public function register(): void
    {
        //
    }
}
