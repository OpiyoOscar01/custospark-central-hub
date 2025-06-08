<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\CouponControler;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UserPreferenceController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ConsultationController;


Route::prefix('apps')->middleware(['sso.auth','check.app.roles:super-admin'])->group(function () {
    Route::get('/', [AppController::class, 'index'])->name('apps.index');
    Route::get('/create', [AppController::class, 'create'])->name('apps.create');
   
    Route::post('/store', [AppController::class, 'store'])->name('apps.store');
    Route::get('/{id}/edit', [AppController::class, 'edit'])->name('apps.edit');
    Route::put('/apps/{app:slug}', [AppController::class, 'update'])->name('apps.update');
    Route::get('/{id}', [AppController::class, 'show'])->name('apps.show');
    Route::delete('/{id}', [AppController::class, 'destroy'])->name('apps.destroy');
});



Route::get('login/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('login/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');


Route::
// middleware([
//     // 'auth',
//     'feature.access:custosell,user-role,user-permissions' // <- Your custom middleware with slug & features
// ])->
prefix('management')->middleware(['sso.auth','check.app.roles:super-admin'])->group(function () {

    // Users CRUD
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{user}/roles', [UserController::class, 'roles'])->name('users.roles');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::post('/users/{user}/toggle-role/{role}/{app}', [UserController::class, 'toggleRole'])->name('users.toggle-role');

    Route::post('/users/{user}/toggle-permission/{permission}/{app}', [UserController::class, 'togglePermission'])->name('users.toggle-permission');

    Route::put('/users/{user}/status', [UserController::class, 'updateStatus'])->name('users.update.status');

    // Role assignment (Spatie)
    Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
    Route::post('/users/{user}/revoke-role', [UserController::class, 'revokeRole'])->name('users.revoke-role');
    Route::put('/users/{user}/update-roles', [UserController::class, 'updateRoles'])->name('users.update-roles');

    // Roles CRUD
    Route::resource('roles', RoleController::class)->except(['show']);

    // Permissions CRUD
    Route::resource('permissions', PermissionController::class)->except(['show']);
});


Route::prefix('/roles')->middleware(['sso.auth','check.app.roles:super-admin'])->group(callback: function () {
    Route::get('/', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::get('/{role}/show', [RoleController::class, 'show'])->name('roles.show');
    Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});
//Feedback Routes

Route::prefix('feedback')->middleware(['sso.auth'])->group(function () {
    Route::get('/create', [FeedBackController::class, 'create'])->name('feedback.create');
    Route::post('/store', [FeedbackController::class, 'store'])->name('feedback.store');
  
    Route::middleware(['check.app.roles:super-admin,admin'])->group(function () {
    Route::get('/', [FeedbackController::class, 'index'])->name('feedback.index'); // Optional for admin
    Route::get('/{feedback}', [FeedbackController::class, 'show'])->name('feedback.show'); // Optional for admin
    Route::get('/{feedback}/edit', [FeedbackController::class, 'edit'])->name('feedback.edit'); // Optional for admin
    Route::put('/{feedback}/update', [FeedbackController::class, 'update'])->name('feedback.update'); // Optional for admin
    Route::delete('/{feedback}/delete', [FeedbackController::class, 'destroy'])->name('feedback.destroy'); // Optional for admin
    Route::get('/attachment/{filename}', [FeedbackController::class, 'downloadAttachment'])->name('feedback.attachment.download');
    Route::get('/attachment/view/{filename}', [FeedbackController::class, 'viewAttachment'])->name('feedback.attachment.view');  
  });



});
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PlanController;

Route::middleware(['sso.auth'])->group(function () {
  
    // User view
        Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
        Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::put('/notifications/{notification}/update', [NotificationController::class, 'update'])->name('notifications.update');
        Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read_all');

    Route::middleware(['check.app.roles:super-admin,admin'])->group(function () {
        // Admin view
        Route::delete('/notifications/bulk-delete', [NotificationController::class, 'bulkDelete'])->name('notifications.bulkDelete');
        Route::put('/notifications/{notification}/update', [NotificationController::class, 'update'])->name('notifications.update');
        Route::delete('/notifications/{notification}/delete', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::get('/notifications/{notification}/edit', [NotificationController::class, 'edit'])->name('notifications.edit');  
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index'); 
        Route::get('/notifications-create', [NotificationController::class, 'create'])->name('notifications.create');
        Route::post('/notifications', action: [NotificationController::class, 'store'])->name('notifications.store');
        });
});


// });

//Pricing
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\SecuritySettingsController;
Route::get('/dashboard/pricing/{app}', [PricingController::class, 'showAppPlans'])
    ->name('dashboard.pricing.app')->middleware('sso.auth');

Route::view('pricing/custom', 'pages.custom_plans')
    ->name('pricing.custom');
Route::get('/home/pricing/{app}', [PricingController::class, 'showPricing'])
    ->name('home.pricing.show');


    //Handling user subscriptions
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserBillingAndSubscriptionController;
Route::middleware(['sso.auth'])->group(function () {
    Route::get('/subscriptions/start/{app}/{plan}', [SubscriptionController::class, 'start'])
        ->name('subscriptions.start');

    Route::get('/subscriptions/payment/{app}/{plan}', [SubscriptionController::class, 'payment'])
        ->name('subscriptions.payment');

    Route::get('/subscriptions/all', [SubscriptionController::class, 'show'])
        ->name('subscriptions.show');

    Route::get('/subscriptions/index', [SubscriptionController::class, 'index'])
        ->name('subscriptions.index');
    // Order summary before payment
    Route::get('/subscriptions/{app}/{plan}/summary', [PaymentController::class, 'orderSummary'])->name('subscriptions.summary');

    // Payment will now be initiated from the summary page
    Route::post('/subscriptions/{app}/{plan}/pay', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');

    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::post('/apps/{app}/subscriptions/cancel-downgrade', [SubscriptionController::class, 'cancelDowngrade'])->name('subscriptions.cancel-downgrade');
    Route::delete('/payments/{payment}/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    
});

// routes/web.php or routes/app.php


Route::post('/apps/{app}/plans/{plan}/schedule-downgrade', [SubscriptionController::class, 'scheduleDowngradePayLater'])
    ->name('subscription.schedule.paylater');

//Settings:User
Route::middleware(['auth'])->name('user.profile.')->group(function () {
    Route::get('/my-profile', [UserController::class, 'profile'])->name('show');
    Route::get('/users/{user}/edit', [UserController::class, 'editUserForm'])->name('edit');
    Route::put('/users/{user}', [UserController::class, 'updateUserInfo'])->name('update');

});
Route::middleware(['sso.auth'])->group(function(){
   Route::get('/user/security', [SecuritySettingsController::class, 'edit'])->name('user.security.edit');
    Route::put('/user/security/update-password', [SecuritySettingsController::class, 'updatePassword'])->name('user.security.updatePassword');
    Route::put('/user/security/two-factor/{user}', [SecuritySettingsController::class, 'updateTwoFactor'])->name('user.security.updateTwoFactor');
   Route::put('/users/{user}/notifications/preferences', [NotificationController::class, 'updateUserNotificationPreferences'])
    ->name('user.notifications.updatePreferences')
    ->middleware(['auth']);
   Route::put('/user/{user}/preferences/newsletter', [UserPreferenceController::class, 'updateNewsletterOptIn'])->name('user.preferences.updateNewsletter');
   Route::put('/user/{user}/preferences/marketing', [UserPreferenceController::class, 'updateMarketingOptIn'])->name('user.preferences.updateMarketing');
    Route::get('/user/notifications-settings', [NotificationController::class, 'updateUserNotificationSettings'])
        ->name('user.settings.notifications');
    Route::get('/users/{user}/billing-history', [UserBillingAndSubscriptionController::class, 'index'])->name('user.billing-history');
    Route::get('/user/{user}/my-subscriptions', [UserBillingAndSubscriptionController::class, 'userSubscriptions'])->name('user.subscriptions');
    Route::put('/settings/preferred-currency', [PaymentController::class, 'updateCurrency'])->name('settings.update.currency');
});




//Help and support
Route::view('/help/support', 'help.support')
    ->name('help.support');
Route::view('/privacy-policy', 'help.privacy_policy')->name('privacy.policies');
Route::view('/terms-of-service', 'help.terms_of_service')->name('help.terms');
Route::view('/contacts', 'help.contacts')->name('help.contacts');


//Verification code
Route::post('/verify', [AuthenticatedSessionController::class, 'verifyCode'])->name('verify.code');
Route::post('/verify/resend', [AuthenticatedSessionController::class, 'resendCode'])->name('resend.code');

// General Pricing

Route::view('/general/pricing', 'users.general_pricing')
    ->name('general.pricing');



Route::middleware(['sso.auth'])->prefix('user')->name('user.')->group(function () {
    
    // Coupon Codes
    Route::get('my-coupons', [CouponController::class, 'myCoupons'])->name('coupons.my');
    // Referrals
    Route::get('referrals/invite', [ReferralController::class, 'invite'])->name('referrals.invite');
    Route::get('referrals/earnings', [ReferralController::class, 'earnings'])->name('referrals.earnings');
    Route::post('/referrals/generate/{app}', [ReferralController::class, 'generateLinkForAppUser'])
    ->name('referrals.generate');
    Route::post('coupon/apply', [CouponController::class, 'applyCoupon'])->name('coupon.apply');
    // web.php
    Route::post('/coupon/remove', [CouponController::class, 'remove'])->name('coupon.remove');
    Route::post('reward-preference', [ReferralController::class, 'updateRewardPreference'])->name('update-reward-preference');


});

Route::get('/select-plan/{app}/{plan}', [PlanController::class, 'storeSelection'])->name('plan.select');

//consultation routes

Route::resource('consultations', ConsultationController::class);
Route::get('consultations-all', [ConsultationController::class, 'index'])->name('consultations.all')->middleware(['sso.auth', 'check.app.roles:super-admin,admin']);


//Contact
use App\Http\Controllers\ContactController;

Route::post('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');


