<?php

namespace App\Services;

use App\Models\Milestone;
use App\Repositories\MilestoneRepository;
use Illuminate\Database\Eloquent\Collection;

class MilestoneService
{
    public function __construct(private MilestoneRepository $milestoneRepository)
    {
    }

    public function getByProject(int $projectId): Collection
    {
        return $this->milestoneRepository->getByProject($projectId);
    }

    public function createMilestone(array $data): Milestone
    {
        return $this->milestoneRepository->create($data);
    }

    public function updateMilestone(Milestone $milestone, array $data): Milestone
    {
        return $this->milestoneRepository->update($milestone, $data);
    }

    public function deleteMilestone(Milestone $milestone): bool
    {
        return $this->milestoneRepository->delete($milestone);
    }
}