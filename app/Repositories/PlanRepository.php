<?php
// app/Repositories/PlanRepository.php

namespace App\Repositories;

use App\Models\Plan;

class PlanRepository
{
    protected $plan;

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    public function create(array $data)
    {
        return $this->plan->create($data);
    }

    public function update(Plan $plan, array $data)
    {
        $plan->update($data);
        return $plan;
    }

    public function delete(Plan $plan)
    {
        return $plan->delete();
    }

    public function findById($id)
    {
        return $this->plan->findOrFail($id);
    }

    public function getAll()
    {
        return $this->plan->with('app')->get();
    }
}
