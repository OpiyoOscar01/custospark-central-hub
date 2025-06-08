<?php
// app/Services/PlanService.php

namespace App\Services;

use App\Repositories\PlanRepository;

class PlanService
{
    protected $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function createPlan(array $data)
    {
        return $this->planRepository->create($data);
    }

    public function updatePlan($id, array $data)
    {
        $plan = $this->planRepository->findById($id);
        return $this->planRepository->update($plan, $data);
    }

    public function deletePlan($id)
    {
        $plan = $this->planRepository->findById($id);
        return $this->planRepository->delete($plan);
    }

    public function getAllPlans()
    {
        return $this->planRepository->getAll();
    }

    public function getPlanById($id)
    {
        return $this->planRepository->findById($id);
    }
}

