<?php

namespace App\Repositories;

use App\Models\Feature;

class FeatureRepository
{
    protected $feature;

    public function __construct(Feature $feature)
    {
        $this->feature = $feature;
    }

    public function create(array $data)
    {
        return $this->feature->create($data);
    }

    public function update(Feature $feature, array $data)
    {
        $feature->update($data);
        return $feature;
    }

    public function delete(Feature $feature)
    {
        return $feature->delete();
    }

    public function findById($id)
    {
        return $this->feature->findOrFail($id);
    }

    public function getAll()
    {
        return $this->feature->with('app')->get();
    }
}
