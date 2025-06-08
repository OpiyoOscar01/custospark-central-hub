<?php

namespace App\Http\Controllers;

use App\Models\FeaturePlan;
use App\Http\Requests\StoreFeatureRequest;
use App\Http\Requests\SyncPlanFeaturesRequest;
use App\Http\Requests\UpdateFeatureRequest;
use App\Models\Feature;
use App\Models\Plan;
use App\Services\FeatureService;
use App\Services\PlanService;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PlanFeatureController extends Controller
{

    protected $planService;
    protected $featureService;
    public function __construct(PlanService $planService, FeatureService $featureService)
    {
        $this->planService = $planService;
        $this->featureService = $featureService;
    }

        public function create(Plan $plan)
    {
        $app = $plan->app;
        return view('plans.features.create', compact('plan', 'app'));
}
     public function index(Plan $plan)
{
    $app = $plan->app;

    // Search by name or code if query is present
    $query = $plan->features()->withPivot('value')->orderBy('name');

    if (request()->has('search')) {
        $search = request('search');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('code', 'like', "%{$search}%");
        });
    }

    $attachedFeatures = $query->paginate(10)->withQueryString(); // 👈 Pagination with query preserved
    $features = $app->features; // optional if needed elsewhere

    return view('plans.features.index', compact('plan', 'app', 'features', 'attachedFeatures'));
}

    /**
     * Sync the features of a plan.
     *
     * @param SyncPlanFeaturesRequest $request
     * @param int $planId
     * @return \Illuminate\Http\JsonResponse
     */

//     public function syncFeatures(SyncPlanFeaturesRequest $request, $planId)
// {
//     $data = $request->validate([
//         'features' => 'required|array',
//         'features.*.id' => 'required|exists:features,id',
//         'features.*.value' => 'required|string'
//     ]);

//     $formatted = collect($data['features'])->mapWithKeys(fn ($f) => [$f['id'] => ['value' => $f['value']]])->toArray();

//     $this->planService->syncFeatures($planId, $formatted);

//     return response()->json(['message' => 'Features synced successfully.']);
// }
        public function edit($planId, $featureId):View
        {
            $plan = Plan::with('app')->findOrFail($planId);
            $feature = Feature::findOrFail($featureId);
            $pivot = $plan->features()->where('features.id', $featureId)->first()?->pivot;

            return view('plans.features.edit', [
                'currentApp' => $plan->app,
                'plan' => $plan,
                'feature' => $feature,
                'pivot' => $pivot
            ]);
        }
public function store(StoreFeatureRequest $request, $planId)
{
    $plan = Plan::findOrFail($planId);

    // First: Check if feature with this code + app_id exists
    $feature = Feature::where('app_id', $request->app_id)
                      ->where('code', $request->code)
                      ->first();

    if (!$feature) {
        // Create a new Feature
        $feature = Feature::create([
            'app_id' => $request->app_id,
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
        ]);
    }

    // Attach the feature to the plan (with pivot value)
    $plan->features()->syncWithoutDetaching([
        $feature->id => ['value' => $request->value]
    ]);

    return redirect()
        ->route('plans.features.index', $planId)->
        with('success', 'Feature added to plan successfully.');
}


    public function show($planId, $featureId)
    {
        $plan = Plan::findOrFail($planId);
        $feature = $plan->features()->where('features.id', $featureId)->firstOrFail();
        $app=$plan->app;

        return view('plans.features.show', [
            'app'=>$app,
            'plan' => $plan,
            'feature' => $feature,
            'pivotValue' => $feature->pivot->value,
        ]);
    }

            // Update the value of a feature on a plan (pivot value)
        public function update(UpdateFeatureRequest $request, $planId, $featureId)
        {
            $plan = Plan::findOrFail($planId);
            $feature = Feature::findOrFail($featureId);

            // Update the feature's main fields
            $feature->update([
                'app_id' => $request->app_id,
                'name' => $request->name,
                'code' => $request->code,
                'min_plan_level'=>$request->min_plan_level,
                'description' => $request->description,
            ]);

            // Update pivot value
            $plan->features()->updateExistingPivot($featureId, [
                'value' => $request->value,
            ]);

            return redirect()
                ->route('plans.features.index', $planId)
                ->with('success', 'Feature and pivot value updated successfully.');
        }


  

public function destroy($planId, $featureId)
{

    // Step 1: Find the plan
    $plan = Plan::find($planId);
    if (!$plan) {
        return redirect()->back()->with('error', 'Plan not found.');
    }

    // Step 2: Get the app_id from the plan
    $appId = $plan->app_id;

    // Step 3: Delete the feature only if it belongs to the same app
    $deleted = DB::table('features')
        ->where('id', $featureId)
        ->where('app_id', $appId)
        ->delete();

    if ($deleted) {
        return redirect()
            ->route('plans.features.index', $planId)
            ->with('success', 'Feature deleted successfully.');
    }

    return redirect()
        ->route('plans.features.index', $planId)
        ->with('error', 'Feature could not be deleted or does not belong to this plan\'s app.');
}



}
