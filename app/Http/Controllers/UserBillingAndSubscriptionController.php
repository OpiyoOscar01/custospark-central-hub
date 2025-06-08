<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserBillingAndSubscriptionController extends Controller
{
      public function index(User $user)
    {
        $userId = $user->id;
        if(Auth::check() && Auth::user()->id !== $userId) {
            abort(403, 'Unauthorized access to this user\'s billing history.');
        }
        $payments = Payment::with('subscription')
            ->where('user_id', $user->id)
            ->orderByDesc('paid_at')
            ->get();

        return view('users.billing-history', compact('user', 'payments'));
    }


//  public function userSubscriptions(User $user)
// {
//     $subscriptions = $user->subscriptions()
//         ->with(['app', 'plan.features', 'payments'])
//         ->get();

//     $payments = $user->payments()->latest()->get();

//     $stats = [
//         'total_subscriptions' => $subscriptions->count(),
//         'active_subscriptions' => $subscriptions->where('status', 'active')->count(),
//         'trial_subscriptions' => $subscriptions->where('status', 'trial')->count(),
//         'total_spent' => $payments->sum('amount'),
//     ];

//     return view('users.subscriptions', compact('user', 'subscriptions', 'stats'));
// }
public function userSubscriptions(Request $request, $userId)
{
    // Check if the authenticated user is trying to access their own subscriptions
    if (Auth::check() && Auth::user()->id !== (int)$userId) {
        abort(403, 'Unauthorized access to this user\'s subscriptions.');
    }
    // Fetch the user by ID, eager load subscriptions with plans, apps, and payments
    $user = User::with([
        'subscriptions.plan.app',
        'subscriptions.payments.app',
    ])->findOrFail($userId);

    // Collect all subscriptions for the user
    $subscriptions = $user->subscriptions;

    // Calculate stats
    $totalSubscriptions = $subscriptions->count();
    $activeSubscriptions = $subscriptions->where('status', 'active')->count();
    $trialSubscriptions = $subscriptions->where('status', 'trial')->count();

    // Sum total spent from payments, assuming payments are related via subscriptions
    $totalSpent = $subscriptions->flatMap->payments
        ->where('status', 'paid') // Only count paid payments
        ->sum('amount');
     $payments = Payment::with('subscription')
            ->where('user_id', $user->id)
            ->orderByDesc('paid_at')
            ->get();

    // Prepare stats array
    $stats = [
        'total_subscriptions' => $totalSubscriptions,
        'active_subscriptions' => $activeSubscriptions,
        'trial_subscriptions' => $trialSubscriptions,
        'total_spent' => $totalSpent,
        'payments' => $payments,
    ];

    // Return the view with all necessary data
    return view('users.subscriptions', compact('user', 'subscriptions', 'stats'));
}

}

