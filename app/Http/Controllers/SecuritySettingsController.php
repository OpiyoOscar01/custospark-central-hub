<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SecuritySettingsController extends Controller
{
    public function edit()
    {
        return view('settings.user.edit_security', [
            'user' => Auth::user()
        ]);
    }

    public function updatePassword(Request $request, NotificationService $notificationService)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        $notificationService->sendNotification(
            title: 'Password Changed',
            mailBody: 'Your account password was successfully updated. If this wasn’t you, please contact support immediately.',
            targetType: 'user',
            channel: 'both',
            userId: $user->id
        );

        return redirect()->route('user.security.edit')
                         ->with('success', 'Password updated successfully.');
    }

    public function updateTwoFactor(Request $request, NotificationService $notificationService)
    {
        $user = Auth::user();

        $request->validate([
            'two_factor_enabled' => ['required', 'boolean'],
        ]);

        $oldTwoFactor = $user->two_factor_enabled;
        $newTwoFactor = $request->boolean('two_factor_enabled');

        if ($oldTwoFactor !== $newTwoFactor) {
            $user->two_factor_enabled = $newTwoFactor;
            $user->save();

          $enabledMessages = [
                'You have enabled two-factor authentication on your account. This adds an extra layer of security to protect your sensitive data.',
                'Two-factor authentication has been turned on. Your account is now more secure against unauthorized access.',
                'Security boost! You’ve successfully enabled two-factor authentication.',
            ];

            $disabledMessages = [
                'You have disabled two-factor authentication. Your account is now more vulnerable to unauthorized access.',
                'Warning: Two-factor authentication has been turned off. This reduces the security of your account.',
                'You disabled 2FA. Consider re-enabling it to keep your account secure from potential threats.',
            ];

// Pick a random message based on the new state
$mailBody = $newTwoFactor
    ? $enabledMessages[array_rand($enabledMessages)]
    : $disabledMessages[array_rand($disabledMessages)];

// Send notification
$notificationService->sendNotification(
    title: 'Two-Factor Authentication ' . ($newTwoFactor ? 'Enabled' : 'Disabled'),
    mailBody: $mailBody,
    targetType: 'user',
    channel: 'in_app',
    userId: $user->id
);

        }

        return redirect()->route('user.security.edit')
                         ->with('success', '2FA preference updated.');
    }
}
