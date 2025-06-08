<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
public function updateNewsletterOptIn(Request $request, User $user)
    {
        if (auth()->user()->id !== $user->id) {
            abort(403, 'Unauthorized access to this user\'s preferences.');
        }
        $request->validate([
            'newsletter_opt_in' => 'required|boolean',
        ]);

        $user->newsletter_opt_in = $request->input('newsletter_opt_in');
        $user->save();

        return redirect()->back()->with('success', 'Newsletter preferences updated.');
    }

    public function updateMarketingOptIn(Request $request, User $user)
    {
        $request->validate([
            'marketing_opt_in' => 'required|boolean',
        ]);

        $user->marketing_opt_in = $request->input('marketing_opt_in');
        $user->save();

        return redirect()->back()->with('success', 'Marketing preferences updated.');
    }}
