<?php

namespace App\Services;

class FeaturePlanService
{
    protected $featurePlanRepository;

    public function __construct($featurePlanRepository)
    {
        $this->featurePlanRepository = $featurePlanRepository;
    }
    /**
     * Create a new class instance.
     */
    public function syncFeatures($planId, array $features)
{
    $this->featurePlanRepository->syncFeaturesToPlan($planId, $features);
}

}
