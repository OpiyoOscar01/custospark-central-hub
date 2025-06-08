<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository
{
    public function all(): Collection
    {
        return Project::with('client')->latest()->get();
    }

    public function getClients(): Collection
    {
        return Client::all();
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function update(Project $project, array $data): Project
    {
        $project->update($data);
        return $project;
    }

    public function delete(Project $project): bool
    {
        return $project->delete();
    }
}