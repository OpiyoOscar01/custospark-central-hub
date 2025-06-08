<?php
// app/Http/Controllers/FeatureController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeatureRequest;
use App\Services\FeatureService;
use Illuminate\Http\Response;

class FeatureController extends Controller
{
    protected $featureService;

    public function __construct(FeatureService $featureService)
    {
        $this->featureService = $featureService;
    }

    public function index()
    {
        return response()->json($this->featureService->getAllFeatures(), Response::HTTP_OK);
    }

    public function show($id)
    {
        return response()->json($this->featureService->getFeatureById($id), Response::HTTP_OK);
    }

    public function store(StoreFeatureRequest $request)
    {
        $feature = $this->featureService->createFeature($request->validated());
        return response()->json($feature, Response::HTTP_CREATED);
    }

    public function update($id, StoreFeatureRequest $request)
    {
        $feature = $this->featureService->updateFeature($id, $request->validated());
        return response()->json($feature, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $this->featureService->deleteFeature($id);
        return response()->json(['message' => 'Feature deleted successfully'], Response::HTTP_OK);
    }
}
