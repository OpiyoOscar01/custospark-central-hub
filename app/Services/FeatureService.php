<?php

// app/Services/FeatureService.php

namespace App\Services;

use App\Repositories\FeatureRepository;

class FeatureService
{
    protected $featureRepository;

    public function __construct(FeatureRepository $featureRepository)
    {
        $this->featureRepository = $featureRepository;
    }
    

    public function createFeature(array $data)
    {
        return $this->featureRepository->create($data);
    }

    public function updateFeature($id, array $data)
    {
        $feature = $this->featureRepository->findById($id);
        return $this->featureRepository->update($feature, $data);
    }

    public function deleteFeature($id)
    {
        $feature = $this->featureRepository->findById($id);
        return $this->featureRepository->delete($feature);
    }

    public function getAllFeatures()
    {
        return $this->featureRepository->getAll();
    }

    public function getFeatureById($id)
    {
        return $this->featureRepository->findById($id);
    }
}
