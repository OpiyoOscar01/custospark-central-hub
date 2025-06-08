<?php
namespace App\Http\Controllers;

use App\Models\ReferralLink;
use App\Models\User;
use App\Models\App;
use App\Services\ReferralLinkService;
use Illuminate\Http\Request;


class ReferralLinkController extends Controller
{
    /**
     * Display a listing of all referral links.
     */
    public function index()
    {
        return ReferralLink::with(['user', 'app'])->get();
    }

    /**
     * Show a specific referral link.
     */
    public function show($id)
    {
        return ReferralLink::with(['user', 'app'])->findOrFail($id);
    }

    /**
     * Store a new referral link.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'app_id' => 'required|exists:apps,id',
            'referral_url' => 'required|url',
        ]);

        return ReferralLink::firstOrCreate(
            ['user_id' => $validated['user_id'], 'app_id' => $validated['app_id']],
            ['referral_url' => $validated['referral_url']]
        );
    }

    /**
     * Update an existing referral link.
     */
    public function update(Request $request, $id)
    {
        $referralLink = ReferralLink::findOrFail($id);

        $validated = $request->validate([
            'referral_url' => 'sometimes|required|url',
        ]);

        $referralLink->update($validated);

        return $referralLink;
    }

    /**
     * Delete a referral link.
     */
    public function destroy($id)
    {
        $referralLink = ReferralLink::findOrFail($id);
        $referralLink->delete();

        return redirect()->back();
    }

    /**
     * Generate referral links for all apps for a given user.
     */
   public function generateLinksForUser($userId)
{
    return app()->make(ReferralLinkService::class)->generateReferralLinksForUser($userId);
}


/**
     * Generate referral links for all apps for the authenticated user.
     */
 public function generateLinkForAppUser($userId, App $app)
{

    return app()->make(ReferralLinkService::class)->generateLinkForAppUser($userId, $app);
}





}