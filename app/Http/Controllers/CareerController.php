<?php

namespace App\Http\Controllers;

use App\Http\Requests\CareerRequest;
use App\Services\CareerService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CareerController extends Controller
{
    protected $careerService;

    public function __construct(CareerService $careerService)
    {
        $this->careerService = $careerService;
    }

    public function index(): View
    {
        $jobs = $this->careerService->getAllCareers();
        return view('Portal.content.careers', compact('jobs'));
    }

    public function store(CareerRequest $request): JsonResponse
    {
        $career = $this->careerService->createCareer($request->validated());
        return response()->json($career, 201);
    }

    public function show(string $id): JsonResponse
    {
        $career = $this->careerService->getCareerById($id);
        return response()->json($career);
    }

    public function update(CareerRequest $request, string $id): JsonResponse
    {
        $career = $this->careerService->updateCareer($id, $request->validated());
        return response()->json($career);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->careerService->deleteCareer($id);
        return response()->json(null, 204);
    }
}