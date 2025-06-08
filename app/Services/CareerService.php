<?php

namespace App\Services;

use App\Repositories\CareerRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Career;

class CareerService
{
    protected $careerRepository;

    public function __construct(CareerRepository $careerRepository)
    {
        $this->careerRepository = $careerRepository;
    }

    public function getAllCareers(): Collection
    {
        return $this->careerRepository->getAll();
    }

    public function getCareerById(string $id): Career
    {
        return $this->careerRepository->findById($id);
    }

    public function createCareer(array $data): Career
    {
        return $this->careerRepository->create($data);
    }

    public function updateCareer(string $id, array $data): Career
    {
        return $this->careerRepository->update($id, $data);
    }

    public function deleteCareer(string $id): bool
    {
        return $this->careerRepository->delete($id);
    }
}