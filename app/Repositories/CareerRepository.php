<?php

namespace App\Repositories;

use App\Models\Career;
use Illuminate\Database\Eloquent\Collection;

class CareerRepository
{
    protected $model;

    public function __construct(Career $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->latest()->get();
    }

    public function findById(string $id): Career
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Career
    {
        return $this->model->create($data);
    }

    public function update(string $id, array $data): Career
    {
        $career = $this->findById($id);
        $career->update($data);
        return $career->fresh();
    }

    public function delete(string $id): bool
    {
        return $this->findById($id)->delete();
    }
}