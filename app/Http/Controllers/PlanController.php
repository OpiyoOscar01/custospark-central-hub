<?php
// app/Http/Controllers/PlanController.php

namespace App\Http\Controllers;

use App\Http\Requests\PlanRequest;
use App\Http\Requests\StorePlanRequest;
use App\Models\App;
use App\Models\Feature;
use App\Models\Plan;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    protected $planService;

    public function __construct(PlanService $planService)
    {
        $this->planService = $planService;
    }

  
// return response()->json($this->planService->getAllPlans(), Response::HTTP_OK);
public function index(Request $request)
{
    $query = Plan::with('app');

    // Filter by app
    if ($request->filled('app_id')) {
        $query->where('app_id', $request->app_id);
    }

    // Filter by billing cycle
    if ($request->filled('billing_cycle')) {
        $query->where('billing_cycle', $request->billing_cycle);
    }

    // Filter by feature
    if ($request->filled('feature')) {
        $query->whereHas('features', function ($q) use ($request) {
            $q->where('features.id', $request->feature);
        });
    }

    // Search by plan name or code
    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%")
              ->orWhere('code', 'like', "%{$searchTerm}%");
        });
    }

    $plans = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

    $apps = App::orderBy('name')->get();

    $features = collect();
    if ($request->filled('app_id')) {
        $features =Feature::where('app_id', $request->app_id)->orderBy('name')->get();
    }

    return view('plans.index', [
        'plans' => $plans,
        'apps' => $apps,
        'features' => $features,
    ]);
}


    

    public function show($id)
    {
        $plan=$this->planService->getPlanById($id);
        return view('plans.show', compact('plan'));
    }

    public function create()
{
    $apps=App::all(); // or however you're getting the current app
    return view('plans.create', compact('apps'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'app_id' => 'required|exists:apps,id',
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:plans,slug',
        'price' => 'required|numeric|min:0',
        'billing_cycle' => 'required|in:monthly,yearly',
        'plan_type'   => 'required|in:free,trial,paid',
        'level'   => 'required|numeric|min:1',
        'trial_days'  => 'nullable|integer|min:0|max:365|required_if:plan_type,trial',
        'description' => 'nullable|string',
        'is_popular' => 'nullable|boolean',
    ]);
// dd($validated);
    $validated['is_popular'] = $request->has('is_popular');

    Plan::create($validated);

    return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
}


    public function update($id, StorePlanRequest $request)
    {
        $plan = $this->planService->updatePlan($id, $request->validated());
    return redirect()->route('plans.index')->with('success', 'Plan updated successfully.');
    }
    public function edit($id)
{
    $plan = Plan::findOrFail($id);
    $apps = App::all();

    return view('plans.edit', compact('plan', 'apps'));
}

    public function destroy($id)
    {
        $this->planService->deletePlan($id);
          return redirect()->route('plans.index')->with('success', 'Plan deleted successfully.');

    }
    public function storeSelection($appId, $planId, Request $request)
    {
        // Optionally validate
        $app = App::findOrFail($appId);
        $plan = Plan::findOrFail($planId);
        if (!$plan || !$app || $plan->app_id !== $app->id) {
            return redirect()->back()->withErrors(['error' => 'Selected plan does not belong to the selected app.']);
        }

        // Store in session
        Session::put('selected_app_id', $app->id);
        Session::put('selected_plan_id', $plan->id);

        // Redirect to login if guest, or directly to summary if already logged in
        if (!Auth::check()) {
            return redirect()->route('register');
        }

        return redirect()->route('subscriptions.summary', ['app' => $app->id, 'plan' => $plan->id]);
    }
}

