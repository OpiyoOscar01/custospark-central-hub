<?php

namespace App\Repositories;

use App\Models\Milestone;
use Illuminate\Database\Eloquent\Collection;

class MilestoneRepository
{
    public function getByProject(int $projectId): Collection
    {
        return Milestone::where('project_id', $projectId)
            ->latest()
            ->get();
    }

    public function create(array $data): Milestone
    {
        return Milestone::create($data);
    }

    public function update(Milestone $milestone, array $data): Milestone
    {
        $milestone->update($data);
        return $milestone;
    }

    public function delete(Milestone $milestone): bool
    {
        return $milestone->delete();
    }
}